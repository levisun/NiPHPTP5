<?php
/**
 *
 * 会员组 - 验证
 *
 * @package   NiPHPCMS
 * @category  admin\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: UserLevel.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/28
 */
namespace app\admin\validate;

use think\Validate;

class UserLevel extends Validate
{
    protected $rule = [
        'id'       => ['require', 'number'],
        'name'     => ['require', 'length:4,20', 'unique:level', 'token'],
        'integral' => ['require', 'number'],
        'status'   => ['require', 'number'],
        'remark'   => ['max:250'],
    ];

    protected $message = [
        'id.require'       => '{%illegal operation}',
        'id.number'        => '{%illegal operation}',
        'name.require'     => '{%error levelname require}',
        'name.length'      => '{%error levelname length not}',
        'name.unique'      => '{%error levelname unique}',
        'integral.require' => '{%error integral require}',
        'integral.number'  => '{%error integral number}',
        'status.require'   => '{%error status require}',
        'status.number'    => '{%error status number}',
        'remark.max'       => '{%error remark length not}',
    ];

    protected $scene = [
        'added' => [
            'name',
            'integral',
            'status',
            'remark'
        ],
        'editor' => [
            'id',
            'name',
            'integral',
            'status',
            'remark'
        ],
        'illegal' => ['id'],
        'remove' => ['id'],
    ];
}
