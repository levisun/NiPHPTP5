<?php
/**
 *
 * 留言 - 验证
 *
 * @package   NiPHPCMS
 * @category  index\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Message.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\index\validate;

use think\Validate;

class Message extends Validate
{
    protected $rule = [
        'title'    => ['require', 'length:4,255', 'token'],
        'username' => ['require', 'length:4,20'],
        'content'  => ['require', 'max:500'],
        'captcha'  => ['require', 'length:4', 'captcha'],
    ];

    protected $message = [
        'title.require'    => 'error message title require',
        'title.length'     => 'error message title length not',
        'username.require' => 'error message username require',
        'username.length'  => 'error message username length not',
        'content.require'  => 'error message content require',
        'content.max'      => 'error message content length not',
    ];
}
