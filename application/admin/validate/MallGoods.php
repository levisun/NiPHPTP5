<?php
/**
 *
 * 商品 商城 - 验证
 *
 * @package   NiPHPCMS
 * @category  admin\validate\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: MallGoods.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/28
 */
namespace app\admin\validate;

use think\Validate;

class MallGoods extends Validate
{
    protected $rule = [
        'id'           => ['require', 'number'],
        'type_id'      => ['require', 'number'],
        'brand_id'     => ['number'],
        'name'         => ['require', 'length:2,255', 'unique:mall_goods', 'token'],
        'content'      => ['require'],
        'thumb'        => ['max:255'],
        'price'        => ['require', 'float'],
        'market_price' => ['require', 'float'],
        'number'       => ['number'],
        'is_pass'      => ['number'],
        'is_show'      => ['number'],
        'is_com'       => ['number'],
        'is_top'       => ['number'],
        'is_hot'       => ['number'],
        'sort'         => ['number'],
    ];

    protected $message = [
        'id.require'           => 'illegal operation',
        'id.number'            => 'illegal operation',
        'type_id.require'      => 'error mall type_id require',
        'type_id.number'       => 'error mall type_id number',
        'brand_id.number'      => 'error mall brand_id number',
        'name.require'         => 'error goods name require',
        'name.length'          => 'error goods name length',
        'name.unique'          => 'error goods name unique',
        'content.require'      => 'error goods content require',
        'thumb.max'            => 'error goods thumb max',
        'price.require'        => 'error goods price require',
        'price.float'          => 'error goods price float',
        'market_price.require' => 'error goods market_price require',
        'market_price.float'   => 'error goods market_price float',
        'number.number'        => 'error mall number number',
        'is_pass.number'       => 'error mall is_pass number',
        'is_show.number'       => 'error mall is_show number',
        'is_com.number'        => 'error mall is_com number',
        'is_top.number'        => 'error mall is_top number',
        'is_hot.number'        => 'error mall is_hot number',
        'sort.number'          => 'error mall sort number',

    ];

    protected $scene = [
        'added' => [
            'type_id',
            'brand_id',
            'name',
            'content',
            'thumb',
            'price',
            'market_price',
            'number',
            'is_pass',
            'is_show',
            'is_com',
            'is_top',
            'is_hot',
        ],
        'editor' => [
            'id',
            'type_id',
            'brand_id',
            'name',
            'content',
            'thumb',
            'price',
            'market_price',
            'number',
            'is_pass',
            'is_show',
            'is_com',
            'is_top',
            'is_hot',
        ],
        'illegal' => ['id'],
        'remove' => ['id'],
    ];
}
