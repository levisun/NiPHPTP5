<?php
/**
 *
 * 微信支付
 *
 * @category   Common\Library
 * @package    NiPHPCMS
 * @author     失眠小枕头 [levisun.mail@gmail.com]
 * @copyright  Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version    CVS: $Id: Wxpay.class.php 2016-09 $
 * @link       http://www.NiPHP.com
 * @since      File available since Release 0.1
 */
class WxPay extends Pay
{

	/**
	 * 构造方法
	 * @access public
	 * @param  array $config_ 支付配置数据
	 * @param  array $param_  支付参数
	 * @return void
	 */
	function __construct($config_=array(), $param_=array())
	{
		$this->_config['appid'] = !empty($config_['appid']) ? $config_['appid'] : '';
		$this->_config['appsecret'] = !empty($config_['appsecret']) ? $config_['appsecret'] : '';
		$this->_config['mch_id'] = !empty($config_['mch_id']) ? $config_['mch_id'] : '';
		$this->_config['key'] = !empty($config_['key']) ? $config_['key'] : '';

		$this->_param = $param_;
	}

	/**
	 * 回调
	 * @access public
	 * @param
	 * @return void
	 */
	public function notify()
	{
		if (empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
			return false;
		}
		$xml_ = $GLOBALS['HTTP_RAW_POST_DATA'];
		$data = (array)simplexml_load_string($xml_, 'SimpleXMLElement', LIBXML_NOCDATA);
		if ($data['return_code'] == 'SUCCESS') {
			parent::saveLog($data);
			// 订单处理业务
			return true;
		} else {
			parent::saveLog($data);
			return false;
		}
	}

	/**
	 * 退款操作
	 * @access public
	 * @param
	 * @return mixed
	 */
	public function refund()
	{
		$param = array(
			'appid' => $this->_config['appid'],
			'mch_id' => $this->_config['mch_id'],
			'nonce_str' => $this->getNonceStr(32),
			'transaction_id' => $this->_param['transaction_id'],
			'total_fee' => $this->_param['total_fee'],						// 订单总金额
			'refund_fee' => $this->_param['refund_fee'],					// 退款总金额
			'out_refund_no' => $this->_config['mch_id'] . date('YmdHis'),
			'op_user_id' => $this->_config['mch_id'],						// 商户号
			);
		$param['sign'] = $this->getSign($param);

		$xml = '<xml>';
		foreach ($param as $key => $value) {
			if ($value != '' && !is_array($value)) {
				$xml .= '<' . $key . '>' . $value . '</' . $key . '>';
			}
		}
		$xml .= '</xml>';

		$url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
		$response = parent::postXmlCurl($xml, $url, true);
		$result = parent::formXml($response);
		if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
			// 退款成功
			// 订单处理业务
			return true;
		}
		if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'FAIL') {
			if ($result['err_code'] == 'TRADE_STATE_ERROR') {
				return '此订单已退达款，请勿重复操作';
			}
			return '退款失败';
		}
		return $result;
	}

	/**
	 * 统一下单
	 * @access public
	 * @param  string $retUrl_ 回调地址
	 * @return string JS
	 */
	public function getJsApi($retUrl_='')
	{
		$retUrl_ = !empty($retUrl_) ? $retUrl_ : $this->_param['notify_url'];

		$data = $this->unifiedOrder();
		$time = time();
		// 新请求参数
		$param = array(
			'appId' => $data['appid'],
			'timeStamp' => "$time",
			'nonceStr' => $this->getNonceStr(32),
			'package' => 'prepay_id=' . $data['prepay_id'],
			'signType' => strtoupper($this->_config['sign_type']),
			);
		$param['paySign'] = $this->getSign($param);
		$jsApiParameters = json_encode($param);
		$data['jsApiParameters'] = $jsApiParameters;
		$data['js'] = '<script type="text/javascript">
		function jsApiCall()
		{
			WeixinJSBridge.invoke(
				"getBrandWCPayRequest",' . $jsApiParameters . ',
				function(res){
					// WeixinJSBridge.log(res.err_msg);
					// alert(res.err_code+res.err_desc+res.err_msg);
					if (res.err_msg == "get_brand_wcpay_request:ok") {
						alert("支付成功！");
						window.location.replace("' . $retUrl_ . '")
					} else if (res.err_msg == "get_brand_wcpay_request:cancel") {
						alert("已取消微信支付!");
					}
				}
			);
		}

		function callpay()
		{
			if (typeof WeixinJSBridge == "undefined"){
				if( document.addEventListener ){
					document.addEventListener("WeixinJSBridgeReady", jsApiCall, false);
				}else if (document.attachEvent){
					document.attachEvent("WeixinJSBridgeReady", jsApiCall);
					document.attachEvent("onWeixinJSBridgeReady", jsApiCall);
				}
			}else{
				jsApiCall();
			}
		}
		</script>';
		return $data;
	}

	/**
	 * 二维码支付
	 * @access public
	 * @param
	 * @return string 二维码图片地址
	 */
	public function qrcode()
	{
		$data = $this->unifiedOrder();
		$code_url = urlencode($data['code_url']);
		return 'http://paysdk.weixin.qq.com/example/qrcode.php?data=' . $code_url;
	}

	/**
	 * 生成支付临时订单
	 * @access protected
	 * @param
	 * @return array
	 */
	protected function unifiedOrder()
	{
		$this->_param['appid'] = $this->_config['appid'];
		$this->_param['mch_id'] = $this->_config['mch_id'];
		$this->_param['nonce_str'] = $this->getNonceStr(32);
		$this->_param['spbill_create_ip'] = $this->getClientIp();
		$this->_param['time_start'] = date('YmdHis');
		$this->_param['time_expire'] = date('YmdHis', time() + 600);
		$this->_param['openid'] = !empty($_SESSION['xaphp_sopenid']) ? $_SESSION['xaphp_sopenid'] : '';
		$this->_param['sign'] = $this->getSign($this->_param);

		$xml = '<xml>';
		foreach ($this->_param as $key => $value) {
			if ($value != '' && !is_array($value)) {
				$xml .= '<' . $key . '>' . $value . '</' . $key . '>';
			}
		}
		$xml .= '</xml>';

		$url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
		$response = parent::postXmlCurl($xml, $url);
		$result = parent::formXml($response);
		return $result;
	}

	/**
	 * 生成签名
	 * @access protected
	 * @param  array  $param_ 请求参数
	 * @return string
	 */
	protected function getSign($param_=array())
	{
		ksort($param_);
		$sign = parent::getSign($param_);
		return strtoupper($sign);
	}
}










