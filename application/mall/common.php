<?php
/**
 *
 * 模块公共（函数）文件
 *
 * @package   NiPHPCMS
 * @category  mall\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: common.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/12/27
 */

/**
 * 数字转钱
 * @param  intval $money
 * @return string
 */
function money_formats($money)
{
    return number_format((float) $money / 100, 2);
}
/**
 * 生成订单号
 * @param  string $other
 * @return string
 */
function order_no($other = '')
{
    list($micro, $time) = explode(' ', microtime());
    $micro = str_pad($micro * 1000000, 6, 0, STR_PAD_LEFT);

    return date('ymdHis') . $micro . mt_rand(111, 999) . $other;
}
