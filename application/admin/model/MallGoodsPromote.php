<?php
/**
 *
 * 商品促销表 - 商城 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: MallGoodsPromote.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/29
 */
namespace app\admin\model;

use think\Model;

class MallGoodsPromote extends Model
{
    protected $name = 'mall_goods_promote';
    protected $autoWriteTimestamp = false;
    protected $updateTime = false;
    protected $pk = 'id';
    protected $field = [
        'id',
        'goods_id',
        'promote_price',
        'promote_start_time',
        'promote_end_time',
    ];
}
