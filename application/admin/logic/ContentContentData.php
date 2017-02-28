<?php
/**
 *
 * 内容 - 内容 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: ContentContentData.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/14
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use think\Lang;
use think\Loader;
use app\admin\model\Config as AdminConfig;
use app\admin\model\Category as AdminCategory;
use app\admin\model\Models as AdminModels;
use app\admin\model\Type as AdminType;
use app\admin\model\Fields as AdminFields;
use app\admin\model\TagsArticle as AdminTagsArticle;
use app\admin\model\Level as AdminLevel;

class ContentContentData extends Model
{
    protected $request = null;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    public function isPass()
    {
        $map = [
            'name' => 'content_check',
            'lang' => 'niphp'
        ];

        $config = new AdminConfig;
        return
        $config->field(true)
        ->where($map)
        ->value('value');
    }

    /**
     * 获得模型表
     * @access public
     * @param
     * @return array
     */
    public function getModelTable()
    {
        $map = [
            'c.id' => $this->request->param('cid/f'),
            'c.lang' => Lang::detect()
        ];

        $category = new AdminCategory;
        $result =
        $category->view('category c', 'id')
        ->view('model m', ['name' => 'model_name'], 'm.id=c.model_id AND m.name!=\'external\'')
        ->view('category cc', 'pid', 'c.id=cc.pid', 'LEFT')
        ->where($map)
        ->find();

        $data = $result ? $result->toArray() : [];

        return $data ? $data['model_name'] : '';
    }

    /**
     * 查询编辑分类数据
     * @access public
     * @param
     * @return array
     */
    public function getTypeData()
    {
        $map = ['t.category_id' => $this->request->param('cid/f')];

        $type = new AdminType;
        $result =
        $type->view('type t', 'id,category_id,name,description')
        ->view('category c', ['name'=>'cat_name'], 'c.id=t.category_id')
        ->where($map)
        ->select();

        $list = [];
        foreach ($result as $value) {
            $list[] = $value->toArray();
        }

        return $list;
    }

    /**
     * 查询编辑权限数据
     * @access public
     * @param
     * @return array
     */
    public function getLevelData()
    {
        $map = [];

        $level = new AdminLevel;
        $result =
        $level->field(true)
        ->where($map)
        ->select();

        $list = [];
        foreach ($result as $value) {
            $list[] = $value->toArray();
        }

        return $list;
    }

    /**
     * 查询编辑字段数据
     * @access public
     * @param  array  $master_data 主数据
     * @param  string $table_name  表名
     * @return array
     */
    public function getEditorFieldsData($master_data, $table_name)
    {
        $map = ['f.category_id' => $master_data['category_id']];
        $table_name .= '_data d';

        $fields = new AdminFields;
        $result =
        $fields->view('fields f', ['id', 'name' => 'field_name'])
        ->view('fields_type t', ['name' => 'field_type'], 'f.type_id=t.id')
        ->view($table_name, ['data' => 'field_data'], 'f.id=d.fields_id AND d.main_id=' . $master_data['id'], 'LEFT')
        ->where($map)
        ->select();

        $list = [];
        foreach ($result as $value) {
            $value = $value->toArray();
            $value['input'] = to_option_type($value);
            $list[] = $value;
        }

        return $list;
    }

    /**
     * 查询编辑标签数据
     * @access public
     * @param  array $master_data 主数据
     * @return array
     */
    public function getEditorTagsData($master_data)
    {
        $map = [
            'a.category_id' => $master_data['category_id'],
            'a.article_id'  => $master_data['id']
        ];

        $tags = new AdminTagsArticle;
        $result =
        $tags->view('tags_article a', 'tags_id')
        ->view('tags t', 'name', 't.id=a.tags_id')
        ->where($map)
        ->select();

        $list = [];
        foreach ($result as $value) {
            $value = $value->toArray();
            $list[] = $value['name'];
        }

        return implode(' ', $list);
    }

    /**
     * 查询添加字段数据
     * @access public
     * @param
     * @return array
     */
    public function getAddedFieldsData()
    {
        $map = ['f.category_id' => $this->request->param('cid/f')];

        $fields = new AdminFields;
        $result =
        $fields->view('fields f', ['id', 'name' => 'field_name'])
        ->view('fields_type t', ['name' => 'field_type'], 'f.type_id=t.id')
        ->where($map)
        ->select();

        $list = [];
        foreach ($result as $value) {
            $value = $value->toArray();
            $value['field_data'] = '';
            $value['input'] = to_option_type($value);
            $list[] = $value;
        }

        return $list;
    }

    /**
     * 查询编辑相册数据
     * @access public
     * @param  string $table_name 表名
     * @return array
     */
    public function getEditorAlbumData($table_name)
    {
        $map = ['main_id' => $this->request->param('id/f')];

        $album = Loader::model(ucfirst($table_name) . 'Album');
        $result =
        $album->field(true)
        ->where($map)
        ->select();

        $list = [];
        foreach ($result as $value) {
            $list[] = $value->toArray();
        }

        return $list;
    }
}
