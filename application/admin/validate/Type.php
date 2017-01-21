<?php
/**
 *
 * 类别 - 验证
 *
 * @package   NiPHPCMS
 * @category  admin\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Type.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/04
 */
namespace app\admin\validate;
use think\Validate;
class Type extends Validate
{
    protected $rule = [
        'id'          => ['require', 'number'],
        'name'        => ['require', 'length:2,255', 'token'],
        'category_id' => ['require', 'number'],
        'description' => ['max:500'],
    ];

    protected $message = [
        'id.require'          => 'illegal operation',
        'id.number'           => 'illegal operation',
        'name.require'        => 'error typename require',
        'name.length'         => 'error typename length not',
        'category_id.require' => 'error category_id require',
        'category_id.number'  => 'error category_id number',
        'description.max'     => 'error description length not',
    ];

    protected $scene = [
        'added' => [
            'name',
            'category_id',
            'description'
        ],
        'editor' => [
            'id',
            'name',
            'description'
        ],
        'illegal' => ['id'],
        'remove' => ['id'],
    ];
}