<?php
/**
 *
 * 微信支付
 *
 * @package   NiPHPCMS
 * @category  net\pay\library\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: WxPay.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/01/03
 */
namespace net\pay\library;

use net\pay\library\Pay;

class WxPay extends Pay
{

    /**
     * 构造方法
     * @access public
     * @param  array $config 支付配置数据
     * @param  array $param  支付参数
     * @return void
     */
    function __construct($config=[], $param=[])
    {
        $this->config['appid']     = !empty($config['appid'])     ? $config['appid']     : '';
        $this->config['appsecret'] = !empty($config['appsecret']) ? $config['appsecret'] : '';
        $this->config['mch_id']    = !empty($config['mch_id'])    ? $config['mch_id']    : '';
        $this->config['key']       = !empty($config['key'])       ? $config['key']       : '';

        $this->param = $param;
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
        parent::saveLog($data);

        if ($data['return_code'] == 'SUCCESS') {
            // 订单处理业务
            return true;
        } else {
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
            'appid'          => $this->config['appid'],
            'mch_id'         => $this->config['mch_id'],
            'nonce_str'      => $this->getNonceStr(32),
            'transaction_id' => $this->param['transaction_id'],
            'total_fee'      => $this->param['total_fee'],                  // 订单总金额
            'refund_fee'     => $this->param['refund_fee'],                 // 退款总金额
            'out_refund_no'  => $this->config['mch_id'] . date('YmdHis'),
            'op_user_id'     => $this->config['mch_id'],                    // 商户号
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
                return '此订单已退款，请勿重复操作';
            }
            return '退款失败';
        }
        return $result;
    }

    /**
     * 统一下单
     * @access public
     * @param  string $ret_url 回调地址
     * @return string JS
     */
    public function getJsApi($ret_url='')
    {
        $ret_url = !empty($ret_url) ? $ret_url : $this->param['notify_url'];

        $data = $this->unifiedOrder();
        $time = time();
        // 新请求参数
        $param = array(
            'appId'     => $data['appid'],
            'timeStamp' => "$time",
            'nonceStr'  => $this->getNonceStr(32),
            'package'   => 'prepay_id=' . $data['prepay_id'],
            'signType'  => strtoupper($this->config['sign_type']),
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
                        window.location.replace("' . $ret_url . '")
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
        $this->param['appid']            = $this->config['appid'];
        $this->param['mch_id']           = $this->config['mch_id'];
        $this->param['nonce_str']        = $this->getNonceStr(32);
        $this->param['spbill_create_ip'] = $this->getClientIp();
        $this->param['time_start']       = date('YmdHis');
        $this->param['time_expire']      = date('YmdHis', time() + 600);
        $this->param['openid']           = !empty($_SESSION['xaphp_sopenid']) ? $_SESSION['xaphp_sopenid'] : '';
        $this->param['sign']             = $this->getSign($this->param);

        $xml = '<xml>';
        foreach ($this->param as $key => $value) {
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
     * @param  array  $param 请求参数
     * @return string
     */
    protected function getSign($param=array())
    {
        ksort($param);
        $sign = parent::getSign($param);
        return strtoupper($sign);
    }
}
