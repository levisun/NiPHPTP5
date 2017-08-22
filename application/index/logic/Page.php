<?php
/**
 *
 * 单页 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  index\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Page.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\index\logic;

use think\Model;
use think\Request;
use think\Lang;
use think\Url;
use think\Loader;
use think\Cache;
use app\admin\model\Page as ModelPage;
use app\admin\model\Fields as ModelFields;
use app\admin\model\TagsArticle as ModelTagsArticle;

class Page extends Model
{
    protected $request    = null;
    protected $modelName = null;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 页面数据
     * 单页面数据
     * @access public
     * @param
     * @return array
     */
    public function getListData()
    {
        $map = [
            'a.category_id' => $this->request->param('cid/f'),
            'a.lang'        => Lang::detect()
        ];

        $model = new ModelPage;

        $result =
        $model->view('page a', true)
        ->view('type t', ['name' => 'type_name'], 't.id=a.type_id', 'LEFT')
        ->view('level l', ['name' => 'level_name'], 'l.id=a.access_id', 'LEFT')
        ->view('category c', ['name' => 'cat_name'], 'c.id=a.category_id')
        ->where($map)
        ->cache(!APP_DEBUG)
        ->find();

        $list = $result ? $result->toArray() : '';
        if (!empty($list)) {
            $list['content'] = htmlspecialchars_decode($list['content']);
            $list['field']   = $this->getFieldsData($list['id']);
            $list['tags']    = $this->getTagsData($list['id']);

            $this->hits();
        }

        return ['list' => $list, 'page' => ''];
    }

    /**
     * 查询字段数据
     * @access protected
     * @param  string $table_name_ 表名
     * @return array
     */
    protected function getFieldsData($id)
    {
        $map = ['f.category_id' => $this->request->param('cid/f')];
        $table_name = 'page_data d';

        $fields = new ModelFields;

        $result =
        $fields->view('fields f', ['id', 'name' => 'field_name'])
        ->view('fields_type t', ['name' => 'field_type'], 'f.type_id=t.id')
        ->view($table_name, ['data' => 'field_data'], 'f.id=d.fields_id AND d.main_id=' . $id, 'LEFT')
        ->where($map)
        ->cache(!APP_DEBUG)
        ->select();

        $list = [];
        foreach ($result as $value) {
            $list[] = $value->toArray();
        }

        return $list;
    }

    /**
     * 查询标签数据
     * @access protected
     * @param
     * @return array
     */
    protected function getTagsData($id)
    {
        $map = [
            'a.category_id' => $this->request->param('cid/f'),
            'a.article_id'  => $id
        ];

        $tags = new ModelTagsArticle;

        $result =
        $tags->view('tags_article a', 'tags_id')
        ->view('tags t', 'name', 't.id=a.tags_id')
        ->where($map)
        ->cache(!APP_DEBUG)
        ->select();

        $list = [];
        foreach ($result as $value) {
            $value = $value->toArray();
            $list[] = $value['name'];
        }

        return implode(' ', $list);
    }

    /**
     * 更新阅读数
     * @access protected
     * @param
     * @return void
     */
    protected function hits()
    {
        $map = [
            'category_id' => $this->request->param('cid/f'),
            'lang'        => Lang::detect(),
        ];

        $model = new ModelPage;
        $model->where($map)
        ->setInc('hits');
    }
}
