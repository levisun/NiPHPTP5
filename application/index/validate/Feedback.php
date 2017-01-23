<?php
/**
 *
 * 反馈 - 验证
 *
 * @package   NiPHPCMS
 * @category  index\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Feedback.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\index\validate;

use think\Validate;

class Feedback extends Validate
{
    protected $rule = [
        'title'    => ['require', 'length:4,255', 'token'],
        'username' => ['require', 'length:4,20'],
        'content'  => ['require', 'max:500'],
        'captcha'  => ['require', 'length:4', 'captcha'],
    ];

    protected $message = [
        'title.require'    => 'error feedback title require',
        'title.length'     => 'error feedback title length not',
        'username.require' => 'error feedback username require',
        'username.length'  => 'error feedback username length not',
        'content.require'  => 'error feedback content require',
        'content.max'      => 'error feedback content length not',
    ];
}
