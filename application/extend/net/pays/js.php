<meta charset="UTF-8">
<?php
// 微信统一下单
// 微信端网页支付
include('Pay.class.php');
include('WxPay.class.php');

$config = array(
	'appid' => 'wx9b2b0724c11c788b',
	'appsecret' => 'c2d5a77cfc5b71117d3dcd5cf569cbad',
	'mch_id' => '1303680001',
	'key' => '0af4769d381ece7b4fddd59dcf048da6');
$param = array(
	'body' => 'test',					// 商品描述 128位
	'detail' => '',						// 商品详情
	'attach' => '',						// 附加数据 127位
	'out_trade_no' => date('YmdHis'),	// 商户订单号 32位
	'total_fee' => 1,
	'goods_tag' => '',					// 商品标记 32位
	'notify_url' => 'http://www.youtuiyou.com/m/test/notify.php',					// 异步通知回调地址,不能携带参数
	'trade_type' => 'JSAPI',			// 交易类型
	'product_id' => '',					// 商品ID 32位
	'device_info' => 'WEB',
	);

$pay = new WxPay($config, $param);
$data = $pay->getJsApi();
echo $data['js'];
?>
<button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>