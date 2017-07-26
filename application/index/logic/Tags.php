<?php
/**
 *
 * 标签 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  index\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Tags.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\index\logic;

use think\Model;
use think\Request;
use think\Lang;
use think\Url;
use think\Config;
use think\Db;
use app\admin\model\Tags as ModelTags;
use app\admin\model\Article as ModelArticle;
use app\admin\model\Download as ModelDownload;
use app\admin\model\Picture as ModelPicture;
use app\admin\model\Product as ModelProduct;
use app\admin\model\Category as ModelCategory;
use app\admin\model\Level as ModelLevel;
use app\admin\model\Type as ModelType;
use app\admin\model\Admin as ModelAdmin;

class Tags extends Model
{
    protected $request = null;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 列表数据
     * @access public
     * @param
     * @return array
     */
    public function getListData()
    {
        $map = [
            't.lang' => Lang::detect(),
        ];

        $CACHE = check_key($map, __METHOD__);

        if ($CACHE && $list = Cache::get($CACHE)) {
            return $list;
        }

        $tags = new ModelTags;
        $result =
        $tags->view('tags t', ['name'=>'tags_name'])
        ->view('tags_article ta', true, 'ta.tags_id=t.id')
        ->where($map)
        ->select();

        $article_id = $category_id = [];
        foreach ($result as $value) {
            $value = $value->toArray();
            $article_id[] = $value['article_id'];
            $category_id[] = $value['category_id'];
            $tags_name = $value['tags_name'];
        }
        $article_id  = array_unique($article_id);
        $category_id = array_unique($category_id);

        $where = ' WHERE is_pass=1 AND lang=\'' . Lang::detect() . '\'';
        $where .= ' AND show_time<=' . strtotime(date('Y-m-d'));

        $where .= ' AND id IN(' . implode(',', $article_id) . ')';
        $where .= ' AND category_id IN(' . implode(',', $category_id) . ')';

        $order = 'sort DESC, update_time DESC';
        $where .= ' ORDER BY ' . $order;

        // 统计
        $field = 'count(1) as count';
        $sql[] = 'SELECT ' . $field . ' FROM ' . Config::get('database.prefix') . 'article' . $where;
        $sql[] = 'SELECT ' . $field . ' FROM ' . Config::get('database.prefix') . 'download' . $where;
        $sql[] = 'SELECT ' . $field . ' FROM ' . Config::get('database.prefix') . 'picture' . $where;
        $sql[] = 'SELECT ' . $field . ' FROM ' . Config::get('database.prefix') . 'product' . $where;

        $union = '(' . implode(') union (', $sql) . ')';
        $result = Db::query($union);

        $total = 0;
        foreach ($result as $key => $value) {
            $total += $value['count'];
        }

        // 分页
        $config = Config::get('paginate');
        $listRows = $config['list_rows'];

        $class = false !== strpos($config['type'], '\\') ? $config['type'] : '\\think\\paginator\\driver\\' . ucwords($config['type']);
        $page  = isset($config['page']) ? (int) $config['page'] : call_user_func([
            $class,
            'getCurrentPage',
        ], $config['var_page']);

        $page = $page < 1 ? 1 : $page;

        $config['path'] = isset($config['path']) ? $config['path'] : call_user_func([$class, 'getCurrentPath']);

        // 列表数据
        $field = 'id, title, keywords, description, thumb, category_id, type_id, is_com, is_top, is_hot, hits, comment_count, username, url, is_link, create_time, update_time, user_id, access_id';

        $sql = [];
        $sql[] = 'SELECT ' . $field . ' FROM ' . Config::get('database.prefix') . 'article' . $where;
        $sql[] = 'SELECT ' . $field . ' FROM ' . Config::get('database.prefix') . 'download' . $where;
        $sql[] = 'SELECT ' . $field . ' FROM ' . Config::get('database.prefix') . 'picture' . $where;
        $sql[] = 'SELECT ' . $field . ' FROM ' . Config::get('database.prefix') . 'product' . $where;

        $limit = $page - 1;
        $limit .= ', ' . $listRows;

        $union = '(' . implode(') union (', $sql) . ') LIMIT ' . $limit;
        $result = Db::query($union);

        $page_obj = $class::make($result, $listRows, $page, $total, false, $config);
        $page = $page_obj->render();

        $category = new ModelCategory;
        $type = new ModelType;
        $level = new ModelLevel;
        $admin = new ModelAdmin;

        $list = [];
        foreach ($result as $value) {
            if ($value['is_link']) {
                $value['url'] = Url::build('/jump/' . $value['category_id'] . '/' . $value['id']);
            } else {
                $value['url'] = Url::build('/article/' . $value['category_id'] . '/' . $value['id']);
            }
            $value['cat_url'] = Url::build('/list/' . $value['category_id']);

            $value['cat_name'] = $category->where(['id'=>$value['category_id']])->value('name');
            $value['type_name'] = $type->where(['id'=>$value['type_id']])->value('name');
            $value['level_name'] = $level->where(['id'=>$value['access_id']])->value('name');
            $value['editor_name'] = $admin->where(['id'=>$value['user_id']])->value('username');

            $list[] = $value;
        }

        $data = ['list' => $list, 'page' => $page, 'tags_name' => $tags_name];

        if ($CACHE) {
            Cache::set($CACHE, $data);
        }

        return $data;
    }
}
