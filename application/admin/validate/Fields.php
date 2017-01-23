<?php
/**
 *
 * 自定义字段 - 验证
 *
 * @package   NiPHPCMS
 * @category  admin\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Fields.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/28
 */
namespace app\admin\validate;

use think\Validate;

class Fields extends Validate
{
    protected $rule = [
        'id'          => ['require', 'number'],
        'category_id' => ['require', 'array', 'checkArray'],
        'type_id'     => ['require', 'number'],
        'name'        => ['require', 'length:2,255', 'token'],
        'description' => ['max:500'],
        'is_require'  => ['require', 'number'],
    ];

    protected $message = [
        'id.require'             => 'illegal operation',
        'id.number'              => 'illegal operation',
        'category_id.require'    => 'error fieldscategory require array',
        'category_id.array'      => 'error fieldscategory require array',
        'category_id.checkArray' => 'error fieldscategory require array',
        'type_id.require'        => 'error fieldstype require number',
        'type_id.number'         => 'error fieldstype require number',
        'name.require'           => 'error fieldsname require',
        'name.length'            => 'error catname length not',
        'description.max'        => 'error aliases length not',
        'is_require.require'     => 'error isrequire require number',
        'is_require.number'      => 'error isrequire require number',
    ];

    protected $scene = [
        'added' => [
            'category_id',
            'type_id',
            'name',
            'description',
            'is_require',
        ],
        'editor' => [
            'id',
            'name',
            'description',
            'is_require',
        ],
        'illegal' => ['id'],
        'remove' => ['id'],
    ];

    /**
     * 验证数组是否为空
     */
    protected function checkArray($value, $rule, $data)
    {
        foreach ($data['category_id'] as $key => $value) {
            if (empty($value)) {
                return false;
            }
        }
        return true;
    }
}
