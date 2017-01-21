<?php
/**
 *
 * 节点 - 验证
 *
 * @package   NiPHPCMS
 * @category  admin\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Node.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/10
 */
namespace app\admin\validate;
use think\Validate;
class Node extends Validate
{
    protected $rule = [
        'id'     => ['require', 'number'],
        'name'   => ['require', 'length:2,20', 'alpha', 'unique:node', 'token'],
        'title'  => ['require', 'length:2,50', 'unique:node'],
        'status' => ['require', 'number'],
        'remark' => ['max:250'],
        'pid'    => ['require', 'number'],
        'level'  => ['require', 'number'],
    ];

    protected $message = [
        'id.require'     => 'illegal operation',
        'id.number'      => 'illegal operation',
        'name.require'   => 'error nodename require',
        'name.length'    => 'error nodename length not',
        'name.alpha'     => 'error nodename alpha not',
        'name.unique'    => 'error nodename unique',

        'title.require'  => 'error nodetitle require',
        'title.length'   => 'error nodetitle length not',
        'title.unique'   => 'error nodetitle unique',

        'status.require' => 'error status require',
        'status.number'  => 'error status number',
        'remark.max'     => 'error remark length not',
        'pid.require'    => 'error pid require',
        'pid.number'     => 'error pid number',
        'level.require'  => 'error level require',
        'level.number'   => 'error level number',
    ];

    protected $scene = [
        'added' => [
            'name',
            'title',
            'status',
            'remark',
            'pid',
            'level'
        ],
        'editor' => [
            'id',
            'name',
            'title',
            'status',
            'remark',
            'pid',
        ],
        'illegal' => ['id'],
        'remove' => ['id'],
    ];
}