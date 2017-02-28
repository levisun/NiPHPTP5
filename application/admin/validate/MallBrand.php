<?php
/**
 *
 * 品牌 商城 - 验证
 *
 * @package   NiPHPCMS
 * @category  admin\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: MallBrand.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/28
 */
namespace app\admin\validate;

use think\Validate;

class MallBrand extends Validate
{
    protected $rule = [
        'id'        => ['require', 'number'],
        'name'      => ['require', 'length:2,255', 'unique:mall_brand', 'token'],
        'image'     => ['max:255'],
    ];

    protected $message = [
        'id.require'        => 'illegal operation',
        'id.number'         => 'illegal operation',
        'name.require'      => 'error type name require',
        'name.length'       => 'error type name length not',
        'name.unique'       => 'error type name unique',
        'image.max'         => 'error image'
    ];

    protected $scene = [
        'added' => [
            'name',
            'image',
        ],
        'editor' => [
            'id',
            'name',
            'image',
        ],
        'illegal' => ['id'],
        'remove' => ['id'],
    ];
}
