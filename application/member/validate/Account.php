<?php
/**
 *
 * 登录|注销 - 帐户 - 验证
 *
 * @package   NiPHPCMS
 * @category  member\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Account.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/12/27
 */
namespace app\member\validate;
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