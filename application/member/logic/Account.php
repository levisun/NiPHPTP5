<?php
/**
 *
 * 帐户登录|注册|找回|信息 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  member\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Account.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\member\logic;
use think\Model;
use think\Request;
use think\Config;
use think\Cookie;
use net\IpLocation;
use app\admin\model\Member as MemberMember;
class Account extends Model
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
		$map = ['m.username' => $this->request->post('username')];
		$member = new MemberMember;
		$result =
		$member->view('member m', 'id,username,password,email,salt')
		->view('level_member lm', 'user_id', 'm.id=lm.user_id')
		->view('level l', ['id'=>'level_id', 'name'=>'Level_name'], 'l.id=lm.level_id')
		->where($map)
		->find();

		$user_data = !empty($result) ? $result->toArray() : [];

		$password = $this->request->post('password', '', 'trim,md5');
		if (empty($user_data) || $user_data['password'] !== md5($password . $user_data['salt'])) {
			return 'error username or password';
		}
		unset($user_data['password']);

		$user_data['last_login_ip'] = $this->request->ip();

		$ip = new IpLocation();
		$area = $ip->getlocation($this->request->ip());
		$user_data['last_login_ip_attr'] = $area['country'] . $area['area'];

		$map = ['id' => $user_data['id']];
		$field = [
			'last_login_time',
			'last_login_ip',
			'last_login_ip_attr'
		];

		$member->allowField($field)
		->save($user_data, $map);

		Cookie::set('USER_DATA', $user_data);
		Cookie::set(Config::get('USER_AUTH_KEY'), $user_data['id']);

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
		Cookie::delete('USER_DATA');
		Cookie::delete(Config::get('USER_AUTH_KEY'));
		return true;
	}

	/**
	 * 注册
	 * @access public
	 * @param
	 * @return string
	 */
	public function reg()
	{
		# code...
	}

	/**
	 * 找回密码
	 * @access public
	 * @param
	 * @return string
	 */
	public function forget()
	{
		# code...
	}
}