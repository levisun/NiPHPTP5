<?php
/**
 *
 * 管理员管理 - 用户 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: UserAdmin.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/07
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use app\admin\model\Admin as AdminAdmin;
use app\admin\model\Role as AdminRole;
use app\admin\model\RoleAdmin as AdminRoleAdmin;

class UserAdmin extends Model
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
        $map = ['a.id' => ['NEQ', 1]];
        if ($key = $this->request->param('key')) {
            $map['a.username'] = ['LIKE', '%' . $key . '%'];
        }

        $admin = new AdminAdmin;
        $result =
        $admin->view('admin a', 'id,username,last_login_ip,last_login_ip_attr,last_login_time')
        ->view('role_admin ra', 'user_id', 'ra.user_id=a.id')
        ->view('role r', ['name'=>'role_name'], 'r.id=ra.role_id')
        ->where($map)
        ->order('a.id DESC')
        ->paginate();

        $list = [];
        foreach ($result as $value) {
            $list[] = $value->toArray();
        }

        $page = $result->render();

        return ['list' => $list, 'page' => $page];
    }

    /**
     * 管理员组数据
     * @access public
     * @param
     * @return array
     */
    public function getRole()
    {
        $map = [
            'status' => 1,
            'id' => ['NEQ', 1],
        ];

        $role = new AdminRole;
        $result =
        $role->field(true)
        ->where($map)
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
        $data = [
            'username' => $this->request->post('username'),
            'email'    => $this->request->post('email')
        ];

        $password         = $this->request->post('password', '', 'trim,md5');
        $data['salt']     = substr(encrypt($password), 0, 6);
        $data['password'] = md5($password . $data['salt']);

        $admin = new AdminAdmin;
        $admin->data($data)
        ->isUpdate(false)
        ->save();

        if (!$admin->id) {
            return false;
        }

        // 管理员组
        $data = [
            'user_id' => $admin->id,
            'role_id' => $this->request->post('role/d')
        ];

        $role_admin = new AdminRoleAdmin;
        $role_admin->data($data)
        ->allowField(true)
        ->isUpdate(false)
        ->save();

        return true;
    }

    /**
     * 查询编辑数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {
        $map = ['a.id' => $this->request->param('id/f')];

        $admin = new AdminAdmin;
        $result =
        $admin->view('admin a', 'id,username,email')
        ->view('role_admin ra', 'user_id', 'ra.user_id=a.id')
        ->view('role r', ['id'=>'role_id', 'name'=>'role_name'], 'r.id=ra.role_id')
        ->where($map)
        ->order('a.id DESC')
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
            'username' => $this->request->post('username'),
            'email'    => $this->request->post('email')
        ];

        $password         = $this->request->post('password', '', 'trim,md5');
        $data['salt']     = substr(encrypt($password), 0, 6);
        $data['password'] = md5($password . $data['salt']);

        $map = ['id' => $this->request->post('id/f')];

        $admin = new AdminAdmin;
        $result =
        $admin->allowField(true)
        ->isUpdate(true)
        ->save($data, $map);

        if (!$result) {
            return false;
        }

        // 管理员组
        $data = [
            'role_id' => $this->request->post('role/d')
        ];

        $map = ['user_id' => $this->request->post('id/f')];

        $role_admin = new AdminRoleAdmin;
        $result =
        $role_admin->allowField(true)
        ->isUpdate(true)
        ->save($data, $map);

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
        $map = ['id' => $this->request->param('id/f')];
        $admin = new AdminAdmin;
        $result =
        $admin->where($map)
        ->delete();

        return $result ? true : false;
    }
}
