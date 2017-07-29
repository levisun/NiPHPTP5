<?php
/**
 *
 * 标签（类）文件
 *
 * @package   NiPHPCMS
 * @category  extend\taglib\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: common.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace taglib;

use think\Request;
use think\Lang;
use think\Loader;
use think\Url;
use think\Config;
use think\Cache;
use think\Db;
use app\admin\model\Category as ModelCategory;
use app\admin\model\Ads as ModelAds;
use app\admin\model\Banner as ModelBanner;
use app\admin\model\Tags as ModelTags;
use app\admin\model\Level as ModelLevel;
use app\admin\model\Type as ModelType;
use app\admin\model\Admin as ModelAdmin;

class LabelFun
{

    /**
     * category标签函数
     * @access public
     * @param  intval $type_id
     * @return array
     */
    public static function tagCategory($type_id)
    {
        $map = [
            'type_id' => $type_id,
            'is_show' => 1,
            'pid'     => 0,
            'lang'    => Lang::detect()
        ];
        $order = 'sort ASC, id DESC';
        $field = [
            'id',
            'name',
            'pid',
            'aliases',
            'seo_title',
            'seo_keywords',
            'seo_description',
            'image',
            'url'
        ];

        $category = new ModelCategory;
        $CACHE = check_key($map, __METHOD__);

        $result =
        $category->field($field)
        ->where($map)
        ->order($order)
        ->cache($CACHE)
        ->select();

        $data = [];
        foreach ($result as $value) {
            $data[] = $value->toArray();
        }

        return self::__getChild($data);
    }

    /**
     * 获得子导航
     * @access protected
     * @param  array $data
     * @return array
     */
    protected static function __getChild($data)
    {
        $nav = $id = [];

        $map   = ['lang' => Lang::detect()];
        $field = [
            'id',
            'name',
            'pid',
            'aliases',
            'seo_title',
            'seo_keywords',
            'seo_description',
            'image',
            'url'
        ];
        $order = 'sort ASC,id DESC';

        foreach ($data as $key => $value) {
            $nav[$key] = $value;
            $nav[$key]['url'] = Url::build('/list/' . $value['id']);

            // 查询子类
            $map['pid'] = $value['id'];

            $category = new ModelCategory;
            $CACHE = check_key($map, __METHOD__);

            $result =
            $category->field($field)
            ->where($map)
            ->order($order)
            ->cache($CACHE)
            ->select();

            $child = [];
            foreach ($result as $value) {
                $child[] = $value->toArray();
            }

            if (!empty($child)) {
                // 递归查询子类
                $_child = self::__getChild($child);
                $child = !empty($_child) ? $_child : $child;
                $nav[$key]['child'] = $child;
            }
        }

        return $nav;
    }

    /**
     * breadcrumb标签函数
     * @access public
     * @param
     * @return array
     */
    public static function tagBreadcrumb()
    {
        $request = Request::instance();
        if (!$request->has('cid', 'param')) {
            return [];
        }

        $id = $request->param('cid/f');

        return self::__getParent($id);
    }

    /**
     * 获得父级栏目
     * @access protected
     * @param  intval $pid
     * @return intval
     */
    protected static function __getParent($pid)
    {
        $parent = [];

        $map = [
            'id'   => $pid,
            'lang' => Lang::detect()
        ];

        $field = [
            'id',
            'name',
            'pid',
            'aliases',
            'seo_title',
            'seo_keywords',
            'seo_description',
            'image',
            'url'
        ];

        $category = new ModelCategory;
        $CACHE = check_key($map, __METHOD__);

        $result =
        $category->field($field)
        ->where($map)
        ->cache($CACHE)
        ->find();

        $data = $result ? $result->toArray() : [];

        if (!empty($data['pid'])) {
            $parent = self::__getParent($data['pid']);
        }

        $parent[] = $data;

        return $parent;
    }

    /**
     * sidebar标签函数
     * @access public
     * @param
     * @return string|void
     */
    public static function tagSidebar()
    {
        $request = Request::instance();
        if (!$request->has('cid', 'param')) {
            return [];
        }

        $id = $request->param('cid/f');

        $id = self::__toParent($id);

        $map = [
            'id'      => $id,
            'is_show' => 1,
            'pid'     => 0,
            'lang'    => Lang::detect()
        ];
        $field = [
            'id',
            'name',
            'pid',
            'aliases',
            'seo_title',
            'seo_keywords',
            'seo_description',
            'image',
            'url'
        ];

        $category = new ModelCategory;
        $CACHE = check_key($map, __METHOD__);

        $result =
        $category->field($field)
        ->where($map)
        ->cache($CACHE)
        ->select();

        $data = [];
        foreach ($result as $value) {
            $data[] = $value->toArray();
        }

        if (empty($data)) {
            return ;
        }

        return self::__getChild($data);

    }

    /**
     * 获得父级ID
     * @access protected
     * @param  intval $cid
     * @return intval
     */
    protected static function __toParent($cid)
    {
        $map = [
            'id'   => $cid,
            'lang' => Lang::detect()
        ];

        $field = [
            'id',
            'name',
            'pid',
            'aliases',
            'seo_title',
            'seo_keywords',
            'seo_description',
            'image',
            'url'
        ];

        $category = new ModelCategory;
        $CACHE = check_key($map, __METHOD__);

        $result =
        $category->field($field)
        ->where($map)
        ->cache($CACHE)
        ->find();

        $data = $result ? $result->toArray() : [];

        if (!empty($data['pid'])) {
            return self::__toParent($data['pid']);
        }

        return $data['id'];
    }

    /**
     * ads标签函数
     * @access public
     * @param  intval $id
     * @return array
     */
    public static function tagAds($id)
    {
        $map = [
            'id' => $id,
            'end_time' => ['EGT', strtotime(date('Y-m-d'))],
            'start_time' => ['ELT', strtotime(date('Y-m-d'))],
            'lang' => Lang::detect()
        ];

        $category = new ModelAds;
        $CACHE = check_key($map, __METHOD__);

        $result =
        $category->field(true)
        ->where($map)
        ->cache($CACHE)
        ->find();

        return $result ? $result->toArray() : [];
    }

    /**
     * 幻灯片标签函数
     * @access public
     * @param  intval $id
     * @return array
     */
    public static function tagBanner($id)
    {
        if (empty($id)) {
            return ;
        }

        $map = [
            'id' => $id,
            'lang' => Lang::detect()
        ];
        $banner = new ModelBanner;
        $CACHE = !APP_DEBUG ? __METHOD__ . 'PARENT' . implode('', $map) : false;

        $result =
        $banner->field(true)
        ->where($map)
        ->cache($CACHE)
        ->find();

        $size = $result ? $result->toArray() : [];

        if (empty($size)) {
            return ;
        }

        $map = [
            'pid' => $id,
            'lang' => Lang::detect()
        ];
        $CACHE = check_key($map, __METHOD__);

        $result =
        $banner->field(true)
        ->where($map)
        ->cache($CACHE)
        ->select();

        $data = [];
        foreach ($result as $value) {
            $value = $value->toArray();
            $value['url'] = Url::build('/banner/' . $vo['id']);
            $value['width'] = $size['width'];
            $value['height'] = $size['height'];
            $data[] = $value;
        }

        return ['data' => $data, 'size' => $size];
    }

    /**
     * 文章标签函数
     * @access public
     * @param  intval $id
     * @param  intval $cid
     * @return array
     */
    public static function tagArticle($id, $cid)
    {
        if (empty($id) || empty($cid)) {
            return ;
        }

        $table_name = self::__getModelTable($cid);
        if (empty($table_name)) {
            return ;
        }

        $map = [
            'a.id'          => $id,
            'a.category_id' => $cid,
            'a.is_pass'     => 1,
            'a.show_time'   => ['ELT', strtotime(date('Y-m-d'))],
            'a.lang'        => Lang::detect()
        ];

        $model = Loader::model(ucfirst($table_name), 'model', false, 'admin');
        $CACHE = check_key($map, __METHOD__);

        $result =
        $model->view($table_name . ' a', true)
        ->view('type t', ['name' => 'type_name'], 't.id=a.type_id', 'LEFT')
        ->view('level l', ['name' => 'level_name'], 'l.id=a.access_id', 'LEFT')
        ->view('category c', ['name' => 'cat_name'], 'c.id=a.category_id')
        ->view('admin ad', ['username' => 'editor_name'], 'a.user_id=ad.id')
        ->where($map)
        ->cache($CACHE)
        ->find();

        $data = $result ? $result->toArray() : [];

        if (!empty($data)) {
            $data['content'] = htmlspecialchars_decode($data['content']);
            if ($data['is_link']) {
                $data['url'] = Url::build('/jump/' . $data['category_id'] . '/' . $data['id']);
            } else {
                $data['url'] = Url::build('/article/' . $data['category_id'] . '/' . $data['id']);
            }
            $data['cat_url'] = Url::build('/list/' . $data['category_id']);
        }

        /*
        TODO
        $data['field'] = $this->getFieldsData();
        $data['tags'] = $this->getTagsData();

        if (in_array($this->model_name, ['picture', 'product'])) {
            $data['album'] = $this->getAlbumData();
        }*/

        return $data;
    }

    /**
     * list标签函数
     * @access public
     * @param  intval $id
     * @param  array  $param
     * @return array
     */
    public static function tagList($id, $param)
    {
        $CACHE = check_key($param, __METHOD__);

        if ($CACHE && $list = Cache::get($CACHE)) {
            return $list;
        }

        $field = 'id, title, keywords, description, thumb, category_id, type_id, is_com, is_top, is_hot, hits, comment_count, username, url, is_link, sort, create_time, update_time, user_id, access_id';

        $where = ' WHERE is_pass=1 AND lang=\'' . Lang::detect() . '\'';
        $where .= ' AND show_time<=' . strtotime(date('Y-m-d'));
        $where .= ' AND category_id IN(' . $id . ')';

        // 推荐
        if (!empty($param['com'])) {
            $where .= ' AND is_com=1';
        }
        // 置顶
        if (!empty($param['top'])) {
            $where .= ' AND is_top=1';
        }
        // 最热
        if (!empty($param['hot'])) {
            $where .= ' AND is_hot=1';
        }

        $order = !empty($param['order']) ? $param['order'] : 'ORDER BY sort DESC, update_time DESC';

        $sql[] = 'SELECT ' . $field . ' FROM ' . Config::get('database.prefix') . 'article' . $where;
        $sql[] = 'SELECT ' . $field . ' FROM ' . Config::get('database.prefix') . 'download' . $where;
        $sql[] = 'SELECT ' . $field . ' FROM ' . Config::get('database.prefix') . 'picture' . $where;
        $sql[] = 'SELECT ' . $field . ' FROM ' . Config::get('database.prefix') . 'product' . $where;

        $limit = !empty($param['limit']) ? (float) $param['limit'] : 10;

        $union = 'SELECT * FROM (' . implode(' union ', $sql) . ') as a ' . $order . ' LIMIT ' . $limit;
        $result = Db::query($union);

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

            // $value['create_time'] = date(Config::get('database.datetime_format'), $value['create_time']);
            // $value['update_time'] = date(Config::get('database.datetime_format'), $value['update_time']);

            $list[] = $value;
        }

        if ($CACHE) {
            Cache::set($CACHE, $list);
        }

        return $list;
    }

    /**
     * tags标签函数
     * @access public
     * @param
     * @return array
     */
    public static function tagTags()
    {
        $map = ['lang' => Lang::detect()];

        $tags = new ModelTags;
        $CACHE = check_key($map, __METHOD__);

        $result =
        $tags->field(true)
        ->where($map)
        ->cache($CACHE)
        ->select();

        $data = [];
        foreach ($result as $value) {
            $value = $value->toArray();
            $value['url'] = Url::build('/tags/' . $value['id']);
            $data[] = $value;
        }

        return $data;
    }

    /**
     * 获得模型表
     * @access protected
     * @param
     * @return array
     */
    protected static function __getModelTable($cid)
    {
        $map = [
            'c.id' => $cid,
            'c.lang' => Lang::detect()
        ];

        $category = new ModelCategory;
        $CACHE = check_key($map, __METHOD__);

        $result =
        $category->view('category c', 'id')
        ->view('model m', ['name' => 'model_name'], 'm.id=c.model_id AND m.name!=\'external\'')
        ->view('category cc', 'pid', 'c.id=cc.pid', 'LEFT')
        ->where($map)
        ->cache($CACHE)
        ->find();

        $data = $result ? $result->toArray() : [];

        return $data ? $data['model_name'] : '';
    }
}
