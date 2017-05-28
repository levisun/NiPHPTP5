<?php
/**
 *
 * 登录|注销|权限菜单|系统基本信息|操作系统日志 - 帐户 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: CommonLogin.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/29
 */
namespace app\admin\logic;

use think\Model;
use think\Config;
use think\Request;
use think\Session;
use net\IpLocation;
use app\admin\model\Admin as AdminAdmin;


class CommonLogin extends Model
{
    protected $request = null;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 登录验证
     * @access public
     * @param
     * @return mixed
     */
    public function checkLogin()
    {
        $map = ['a.username' => $this->request->post('username')];
        $admin = new AdminAdmin;
        $result =
        $admin->view('admin a', 'id,username,password,email,salt')
        ->view('role_admin ra', 'user_id', 'a.id=ra.user_id')
        ->view('role r', ['id'=>'role_id', 'name'=>'role_name'], 'r.id=ra.role_id')
        ->where($map)
        ->find();

        $user_data = !empty($result) ? $result->toArray() : [];

        $password = $this->request->post('password', '', 'trim,md5');
        if (empty($user_data) || $user_data['password'] !== md5($password . $user_data['salt'])) {
            return 'error username or password';
        }
        unset($user_data['password']);

        $ip = new IpLocation();
        $area = $ip->getlocation($this->request->ip(0, true));
        $user_data['last_login_ip'] = $this->request->ip(0, true);
        $user_data['last_login_ip_attr'] = $area['country'] . $area['area'];

        $map = ['id' => $user_data['id']];
        $field = [
            'last_login_time',
            'last_login_ip',
            'last_login_ip_attr'
        ];

        $admin->allowField($field)
        ->save($user_data, $map);

        Session::set('ADMIN_DATA', $user_data);
        Session::set(Config::get('USER_AUTH_KEY'), $user_data['id']);

        return true;
    }

    /**
     * 注销
     * @access public
     * @param
     * @return boolean
     */
    public function logout()
    {
        Session::delete('ADMIN_DATA');
        Session::delete(Config::get('USER_AUTH_KEY'));
        Session::delete('_ACCESS_LIST');
        return true;
    }
}
