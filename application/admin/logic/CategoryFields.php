<?php
/**
 *
 * 字段管理 - 栏目 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: CategoryFields.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/25
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use think\Lang;
use think\Loader;
use app\admin\model\Fields as AdminFields;
use app\admin\model\Category as AdminCategory;
use app\admin\model\FieldsType as AdminFieldsType;

class CategoryFields extends Model
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
        $map = [];
        if ($key = $this->request->param('key')) {
            $map['f.name'] = ['LIKE', '%' . $key . '%'];
        }
        if ($cid = $this->request->param('cid/f')) {
            $map['f.category_id'] = $cid;
        }
        if ($mid = $this->request->param('mid/f')) {
            $map['m.id'] = $mid;
        }

        $fields = new AdminFields;
        $result =
        $fields->view('fields f', 'id,category_id,name,description,is_require')
        ->view('category c', ['name'=>'cat_name'], 'c.id=f.category_id')
        ->view('fields_type t', ['name'=>'type_name'], 't.id=f.type_id')
        ->view('model m', ['name'=>'model_name'], 'm.id=c.model_id')
        ->where($map)
        ->order('f.id DESC')
        ->paginate();

        $list = [];
        foreach ($result as $value) {
            $list[] = $value->toArray();
        }

        $page = $result->render();

        return ['list' => $list, 'page' => $page];
    }

    /**
     * 获得栏目
     * @access public
     * @param  mixed $ajax_param Ajax参数 默认为False 非Ajax
     * @return array
     */
    public function getCategory($ajax_param = false)
    {
        $map = [
            'pid' => $this->request->post('id/f', 0),
            'model_id' => [
                'not in',
                [8, 9]
                ]
        ];
        $field = ['id', 'name'];

        $category = new AdminCategory;
        $result =
        $category->field($field)
        ->where($map)
        ->select();

        $data = [];
        foreach ($result as $value) {
            $data[] = $value->toArray();
        }

        // 非AJAX请求子类栏目
        if (false === $ajax_param) {
            return $data;
        }

        // AJAX请求返回内容
        if (empty($data)) {
            return ;
        }
        $option = '<select name="category_id[]" id="category_id_' . $ajax_param . '" class="form-control op fieldsCategory" data-type="' . $ajax_param . '">';
        $option .= '<option value="0">' . Lang::get('select category') . '</option>';
        foreach ($data as $value) {
            $option .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
        }
        $option .= '</select>';

        return $option;
    }

    /**
     * 获得字段类型
     * @access public
     * @param
     * @return array
     */
    public function getType()
    {
        $field = ['id', 'name'];

        $fields_type = new AdminFieldsType;
        $result =
        $fields_type->field($field)
        ->select();

        $data = [];
        foreach ($result as $value) {
            $data[] = $value->toArray();
        }

        return $data;
    }

    /**
     * 添加数据
     * @access public
     * @param
     * @return boolean
     */
    public function added()
    {
        $category_id = $this->request->post('category_id/a');
        $category_id = (float) end($category_id);

        $data = [
            'name'        => $this->request->post('name'),
            'type_id'     => $this->request->post('type_id/f'),
            'category_id' => $category_id,
            'is_require'  => $this->request->post('is_require/d'),
            'description' => $this->request->post('description'),
        ];

        $fields = new AdminFields;
        $fields->data($data)
        ->allowField(true)
        ->isUpdate(false)
        ->save();

        return $fields->id ? true : false;
    }

    /**
     * 查询编辑数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {
        $map = ['f.id' => $this->request->param('id/f')];

        $fields = new AdminFields;
        $result =
        $fields->view('fields f', 'id,category_id,type_id,name,description,is_require')
        ->view('category c', ['name'=>'cat_name'], 'c.id=f.category_id')
        ->where($map)
        ->find();

        return !empty($result) ? $result->toArray() : [];
    }

    /**
     * 编辑数据
     * @access public
     * @param
     * @return boolean
     */
    public function editor()
    {
        $data = [
            'name'        => $this->request->post('name'),
            'is_require'  => $this->request->post('is_require/d'),
            'description' => $this->request->post('description')
        ];
        $map = ['id' => $this->request->post('id/f')];

        $fields = new AdminFields;
        $result =
        $fields->allowField(true)
        ->isUpdate(true)
        ->save($data, $map);

        return $result ? true : false;
    }

    /**
     * 删除数据
     * @access public
     * @param
     * @return boolean
     */
    public function remove()
    {
        $id = $this->request->param('id/f');

        $map = ['f.id' => $id];

        $fields = new AdminFields;
        $table_name =
        $fields->view('fields f', 'id')
        ->view('category c', ['id'=>'cid'], 'c.id=f.category_id')
        ->view('model m', 'table_name', 'm.id=c.model_id')
        ->where($map)
        ->value('m.table_name');

        // 删除扩展表对应字段数据
        $map = ['fields_id' => $id];
        $model_data_name = ucfirst($table_name) . 'Data';
        $model_data = Loader::model($model_data_name);
        $result =
        $model_data->where($map)
        ->delete();

        $map = ['id' => $id];
        $fields->name('fields');
        $result =
        $fields->where($map)
        ->delete();

        return $result ? true : false;
    }
}
