<?php
/**
 *
 * 类别管理 - 栏目 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: CategoryType.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/04
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use app\admin\model\Type as AdminType;
use app\admin\model\Category as AdminCategory;

class CategoryType extends Model
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
            $map = ['t.name' => ['LIKE', '%' . $key . '%']];
        }
        if ($cid = $this->request->param('cid/f')) {
            $map['t.category_id'] = $cid;
        }

        $type = new AdminType;
        $result =
        $type->view('type t', 'id,category_id,name,description')
        ->view('category c', ['name'=>'cat_name'], 'c.id=t.category_id')
        ->where($map)
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
    public function getCategory($ajax_param=false)
    {
        $map = ['pid' => $this->request->post('id/f', 0)];
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
        $option = '<select name="category_id[]" id="category_id_' . $ajax_param . '" class="form-control op" data-type="' . $ajax_param . '" onchange="fieldsCategory(this)">';
        $option .= '<option value="0">' . Lang::get('select category') . '</option>';
        foreach ($data as $value) {
            $option .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
        }
        $option .= '</select>';

        return $option;
    }

    /**
     * 添加数据
     * @access public
     * @param
     * @return boolean
     */
    public function added()
    {
        $data = [
            'name'        => $this->request->post('name'),
            'category_id' => $this->request->post('category_id/f'),
            'description' => $this->request->post('description')
        ];

        $type = new AdminType;
        $type->data($data)
        ->allowField(true)
        ->isUpdate(false)
        ->save();

        return $type->id ? true : false;
    }

    /**
     * 查询编辑数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {
        $map = ['t.id' => $this->request->param('id/f')];

        $type = new AdminType;
        $result =
        $type->view('type t', 'id,name,category_id,description')
        ->view('category c', ['name'=>'cat_name'], 'c.id=t.category_id')
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
            'description' => $this->request->post('description')
        ];
        $map = ['id' => $this->request->post('id/f')];

        $type = new AdminType;
        $result =
        $type->allowField(true)
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
        // TODO 修改表中关联type_id

        $map = ['id' => $this->request->param('id/f')];

        $type = new AdminType;
        $result =
        $type->where($map)
        ->delete();

        return $result ? true : false;
    }
}
