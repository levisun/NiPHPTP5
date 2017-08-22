<?php
/**
 *
 * 管理员 - 验证
 *
 * @package   NiPHPCMS
 * @category  admin\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Admin.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/28
 */
namespace app\admin\validate;

use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'id'           => ['require', 'number'],
        'username'     => ['require', 'length:6,20', 'unique:admin', 'token'],
        'password'     => ['require', 'max:30'],
        'not_password' => ['require', 'confirm:password'],
        'email'        => ['require', 'email'],
        'role'         => ['require', 'number'],
    ];

    protected $message = [
        'id.require'           => '{%illegal operation}',
        'id.number'            => '{%illegal operation}',
        'username.require'     => '{%error adminname require}',
        'username.length'      => '{%error adminname length not}',
        'username.unique'      => '{%error adminname unique}',
        'password.require'     => '{%error password require}',
        'password.max'         => '{%error password length not}',
        'not_password.require' => '{%error not_password require}',
        'not_password.confirm' => '{%error not_password confirm}',
        'email.require'        => '{%error email require}',
        'email.email'          => '{%error email email}',
        'role.require'         => '{%error role require}',
        'role.number'          => '{%error role number}',
    ];

    protected $scene = [
        'added' => [
            'username',
            'password',
            'not_password',
            'email',
            'role'
        ],
        'editor' => [
            'id',
            'username',
            'password',
            'not_password',
            'email',
            'role'
        ],
        'illegal' => ['id'],
        'remove' => ['id'],
    ];
}
