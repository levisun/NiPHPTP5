<?php
/**
 *
 * 评论 - 验证
 *
 * @package   NiPHPCMS
 * @category  admin\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Comment.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/28
 */
namespace app\admin\validate;

use think\Validate;

class Comment extends Validate
{
    protected $rule = [
        'id'          => ['require', 'number'],
        'category_id' => ['require', 'number', 'token'],
        'content_id'  => ['require', 'number'],
        'user_id'     => ['require', 'number'],
        'pid'         => ['require', 'number'],
        'content'     => ['require', 'max:1000'],
        'is_pass'     => ['require', 'number', 'token'],
        'is_report'   => ['require', 'number'],
    ];

    protected $message = [
        'id.require'          => 'illegal operation',
        'id.number'           => 'illegal operation',
        'category_id.require' => 'error category_id require',
        'category_id.number'  => 'error category_id number',
        'content_id.require'  => 'error content_id require',
        'content_id.number'   => 'error content_id number',
        'user_id.require'     => 'error user_id require',
        'user_id.number'      => 'error user_id number',
        'pid.require'         => 'error pid require',
        'pid.number'          => 'error pid number',
        'content.require'     => 'error content require',
        'content.max'         => 'error content length not',
        'is_pass.require'     => 'error is_pass require',
        'is_pass.number'      => 'error is_pass number',
        'is_report.require'   => 'error is_report require',
        'is_report.number'    => 'error is_report number',
    ];

    protected $scene = [
        'added' => [
            'category_id',
            'content_id',
            'user_id',
            'pid',
            'content'
        ],
        'editor' => [
            'id',
            'is_pass',
            'is_report'
        ],
        'illegal' => ['id'],
        'remove' => ['id'],
    ];
}
