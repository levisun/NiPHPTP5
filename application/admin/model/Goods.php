<?php
/**
 *
 * 商品 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Goods.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/02
 */
namespace app\admin\model;

use think\Model;

class Goods extends Model
{
    protected $name = 'goods';
    protected $autoWriteTimestamp = true;
    protected $updateTime = 'update_time';
    protected $deleteTime = 'delete_time';
    protected $pk = 'id';
    protected $field = [
        'id',
        'category_id',
        'brand_id',
        'title',
        'content',
        'thumb',
        'price',
        'market_price',
        'promote_price',
        'number',
        'is_pass',
        'is_com',
        'is_top',
        'is_hot',
        'is_promote',
        'sort',
        'hits',
        'comment_count',
        'promote_start_time',
        'promote_ent_time',
        'create_time',
        'update_time',
        'delete_time',
        'lang'
    ];
}
