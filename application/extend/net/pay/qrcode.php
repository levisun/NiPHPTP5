<?php
/**
 *
 * 微信二维码支付
 *
 * @package   NiPHPCMS
 * @category  net\pay\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: WxQrcode.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/01/03
 */
namespace net\pay;
use net\pay\library\WxPay;
class WxQrcode
{

    function payCode($config=[], $param=[])
    {
        $param['trade_type']  = 'NATIVE';
        $param['device_info'] = 'WEB';

        $pay = new WxPay($config, $param);
        $data = $pay->qrcode();

        return '<img src="' . $data . '" alt="">';
    }
}

/*// 微信扫码支付
include('Pay.class.php');
include('WxPay.class.php');

$config = array(
    'appid' => '',
    'appsecret' => '',
    'mch_id' => '',
    'key' => ''
    );
$param = array(
    'body' => 'test',                    // 商品描述 128位
    'detail' => '',                        // 商品详情
    'attach' => '',                        // 附加数据 127位
    'out_trade_no' => date('YmdHis'),    // 商户订单号 32位
    'total_fee' => 1,
    'goods_tag' => '',                    // 商品标记 32位
    'notify_url' => 'http://www.youtuiyou.com/m/test/notify.php',                    // 异步通知回调地址,不能携带参数
    'trade_type' => 'NATIVE',            // 交易类型
    'product_id' => '',                    // 商品ID 32位
    'device_info' => 'WEB',
    );

$pay = new WxPay($config, $param);
$data = $pay->qrcode();
echo '<img src="' . $data . '" alt="">';*/