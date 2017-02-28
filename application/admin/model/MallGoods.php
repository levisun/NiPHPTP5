<?php
/**
 *
 * 商品表 - 商城 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: MallGoods.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/29
 */
namespace app\admin\model;

use think\Model;

class MallGoods extends Model
{
    protected $name = 'mall_goods';
    protected $autoWriteTimestamp = true;
    protected $updateTime = 'update_time';
    protected $pk = 'id';
    protected $field = [
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
        'sort',
        'hits',
        'comment_count',
        'create_time',
        'update_time',
        'delete_time',
        'lang'
    ];
}
