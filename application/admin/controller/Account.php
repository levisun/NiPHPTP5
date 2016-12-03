<?php
/**
 *
 * 帐户 - 控制器
 *
 * @package   NiPHPCMS
 * @category  admin\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Account.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\controller;
use think\Loader;
use think\Url;
use think\Lang;
use app\admin\controller\Common;
use app\admin\logic\CommonLogin as AdminCommonLogin;
class Account extends Common
{
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
				$result = Loader::model('CommonLogin', 'logic')->checkLogin();
			}

			if (true === $result) {
				$this->actionLog('admin_login');
				$this->redirect(Url::build('settings/info'));
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
		$this->actionLog('admin_logout');
		$result = Loader::model('CommonLogin', 'logic')->logout();
		if (true === $result) {
			$this->redirect(Url::build('account/login'));
		}
	}
}