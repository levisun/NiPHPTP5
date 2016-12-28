<?php
/**
 *
 * 首页 - 控制器
 *
 * @package   NiPHPCMS
 * @category  member\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Index.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\member\controller;
use think\Url;
use think\Lang;
use app\member\controller\Base;
use app\member\logic\Account as MemberAccount;
class Index extends Base
{

	public function index()
	{

	}

	/**
	 * 登录
	 * @access public
	 * @param
	 * @return string
	 */
	public function login()
	{
		if ($this->request->isPost()) {
			$result = $this->validate($_POST, 'Account.login');

			if(true === $result){
				$model = new MemberAccount;
				$result = $model->checkLogin();
			}

			if (true === $result) {
				$this->redirect(Url::build('/member'));
			} else {
				$this->error(Lang::get($result));
			}
		}
		return $this->fetch();
	}

	/**
	 * 注销
	 * @access public
	 * @param
	 * @return void
	 */
	public function logout()
	{
		$model = new MemberAccount;
		$result = $model->logout();
		if (true === $result) {
			$this->redirect(Url::build('/member/login'));
		}
	}

	/**
	 * 注册
	 * @access public
	 * @param
	 * @return string
	 */
	public function reg()
	{
		return $this->fetch();
	}

	/**
	 * 找回密码
	 * @access public
	 * @param
	 * @return string
	 */
	public function forget()
	{
		return $this->fetch();
	}
}