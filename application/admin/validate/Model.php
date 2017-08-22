<?php
/**
 *
 * 模型 - 验证
 *
 * @package   NiPHPCMS
 * @category  admin\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Model.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/31
 */
namespace app\admin\validate;

use think\Validate;

class Model extends Validate
{
    protected $rule = [
        'id'          => ['require', 'number'],
        'name'        => ['require', 'length:4,255', 'unique:model', 'token'],
        'table_name'  => ['require', 'length:4,255', 'alpha'],
        'remark'      => ['max:255'],
        'status'      => ['number'],
        'model_table' => ['require', 'alpha']
    ];

    protected $message = [
        'id.require'          => '{%illegal operation}',
        'id.number'           => '{%illegal operation}',
        'name.require'        => '{%error modelname require}',
        'name.length'         => '{%error modelname length not}',
        'name.unique'         => '{%error modelname unique}',
        'table_name.require'  => '{%error tablename require}',
        'table_name.length'   => '{%error tablename length not}',
        'table_name.unique'   => '{%error tablename unique}',
        'table_name.alpha'    => '{%error tablename alpha}',
        'model_table.require' => '{%error modeltable require}',
        'model_table.alpha'   => '{%error modeltable alpha}',
        'remark.max'          => '{%error remark length not}',
        'status.number'       => '{%error status number}',
    ];

    protected $scene = [
        'added' => [
            'name',
            'tablename',
            'remark',
            'status',
            'modeltable'
        ],
        'editor' => [
            'id',
            'name',
            'remark',
            'status',
        ],
        'illegal' => ['id'],
        'remove' => ['id'],
    ];
}
