<?php
/**
 *
 * 支付
 *
 * @package   NiPHPCMS
 * @category  net\pay\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: WxJsPay.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/01/03
 */
namespace net\pay;
use net\pay\library\WxPay;
class PayCode
{
	protected $type;
	protected $config;
	protected $param;

	function __construct($type, $config, $param)
	{
		$this->type = $type;
		$this->config = $config;
		$this->param = $param;
	}

	public function getCode()
	{
		if ($this->type == 'wxjspay') {
			return $this->WxJsPay();
		}
	}

	/**
	 * 微信统一支付
	 * @access protected
	 * @param
	 * @return string
	 */
	protected function WxJsPay()
	{
		$this->param['trade_type']  = 'JSAPI';
		$this->param['device_info'] = 'WEB';

		$pay = new WxPay($this->config, $this->param);
		$data = $pay->getJsApi();

		$return = $data['js'];
		$return .= '<button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>';

		return $return;
	}

	/**
	 * 微信二维码支付
	 * @access protected
	 * @param
	 * @return string
	 */
	protected function WxQrcode()
	{
		$this->param['trade_type']  = 'NATIVE';
		$this->param['device_info'] = 'WEB';

		$pay = new WxPay($this->config, $this->$param);
		$data = $pay->qrcode();

		return $data;
	}
}