<?php
/**
 *
 * 管理员组管理 - 用户 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: UserRole.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/07
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use app\admin\model\Role as ModelRole;
use app\admin\model\Node as ModelNode;
use app\admin\model\Access as ModelAccess;

class UserRole extends Model
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
        $map = ['id' => ['neq', 1]];
        if ($key = $this->request->param('key')) {
            $map['name'] = ['LIKE', '%' . $key . '%'];
        }

        $role = new ModelRole;
        $result =
        $role->field(true)
        ->where($map)
        ->order('id DESC')
        ->paginate();

        $list = [];
        foreach ($result as $value) {
            $list[] = $value->toArray();
        }

        $page = $result->render();

        return ['list' => $list, 'page' => $page];
    }

    /**
     * 获得权限节点
     * @access public
     * @param  intval $parent_id 父ID
     * @return array
     */
    public function getNode($parent_id=0)
    {
        $map = [
            'status' => 1,
            'pid' => $parent_id
        ];
        if (!$parent_id) {
            $map['id'] = 1;
        }
        $order = 'sort ASC';

        $node = new ModelNode;
        $result =
        $node->field(true)
        ->where($map)
        ->order($order)
        ->select();

        $data = [];
        foreach ($result as $key => $value) {
            $array = $value->toArray();
            $data[$key] = $array;
            $child = $this->getNode($array['id']);
            if (!empty($child)) {
                $data[$key]['child'] = $child;
            }

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
        $data = [
            'name'   => $this->request->post('name'),
            'status' => $this->request->post('status/d'),
            'remark' => $this->request->post('remark'),
        ];

        $role = new ModelRole;
        $role->data($data)
        ->isUpdate(false)
        ->save();

        if (!$role->id) {
            return false;
        }

        $map = ['role_id' => $role->id];

        $access = new ModelAccess;
        $access->where($map)
        ->delete();

        $node = $this->request->post('node/a');
        $data = [
            'role_id' => $role->id,
            'status' => 1,
        ];
        foreach ($node as $key => $value) {
            foreach ($value as $k => $val) {
                $k = explode('_', $k);
                $k = !empty($k[1]) ? $k[1] : $k[0];
                $data['node_id'] = $val;
                $data['level'] = $key;
                $data['module'] = $k;

                $access->data($data)
                ->allowField(true)
                ->isUpdate(false)
                ->save();
            }
        }

        return $role->id ? true : false;
    }

    /**
     * 查询编辑数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {
        $map = ['id' => $this->request->param('id/f')];

        $role = new ModelRole;
        $result =
        $role->field(true)
        ->where($map)
        ->find();

        $data = !empty($result) ? $result->toArray() : [];

        $map = ['role_id' => $this->request->param('id/f')];

        $access = new ModelAccess;
        $result =
        $access->field(true)
        ->where($map)
        ->select();

        foreach ($result as $value) {
            $value = $value->toArray();
            $data['node'][] = $value['node_id'];
        }

        return $data;
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
            'name'   => $this->request->post('name'),
            'status' => $this->request->post('status/d'),
            'remark' => $this->request->post('remark'),
        ];
        $id = $this->request->post('id/f');
        $map = ['id' => $id];

        $role = new ModelRole;
        $role->where($map)
        ->update($data);

        $map = ['role_id' => $id];

        $access = new ModelAccess;
        $access->where($map)
        ->delete();

        $node = $this->request->post('node/a');
        $data = [
            'role_id' => $id,
            'status' => 1,
        ];
        foreach ($node as $key => $value) {
            foreach ($value as $k => $val) {
                $k = explode('_', $k);
                $k = !empty($k[1]) ? $k[1] : $k[0];
                $data['node_id'] = $val;
                $data['level'] = $key;
                $data['module'] = $k;

                $access->data($data)
                ->allowField(true)
                ->isUpdate(false)
                ->save();
            }
        }

        return true;
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
        $map = ['id' => $id];

        $role = new ModelRole;
        $result =
        $role->where($map)
        ->delete();

        $map = ['role_id' => $id];

        $access = new ModelAccess;
        $result =
        $access->where($map)
        ->delete();

        return $result ? true : false;
    }
}
