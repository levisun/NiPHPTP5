<?php
/**
 *
 * 登录|注销|权限菜单|系统基本信息|操作系统日志 - 帐户 - 验证
 *
 * @package   NiPHPCMS
 * @category  admin\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Account.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\validate;
use think\Validate;
class Account extends Validate
{
	protected $rule = [
		'username' => ['require', 'length:4,20', 'token'],
		'password' => ['require', 'length:6,20'],
		'captcha'  => ['require', 'length:4', 'captcha'],
	];

	protected $message = [
		'username.require' => 'error username require',
		'username.length'  => 'error username length not',
		'password.require' => 'error password require',
		'password.length'  => 'error password length not',
		'captcha.require'  => 'error captcha require',
		'captcha.length'   => 'error captcha length',
		'captcha.captcha'  => 'error captcha',
	];

	protected $scene = [
		'login'  =>  ['username', 'password', 'captcha'],
	];
}