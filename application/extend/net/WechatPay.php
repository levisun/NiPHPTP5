<?php
/**
*
*/
namespace net;

class WechatPay
{
    // 支付配置
    protected $config = [];

    protected $params = [
        // 'body'         => '',       // 商品描述 128位
        // 'detail'       => '',       // 商品详情
        // 'attach'       => '',       // 附加数据 127位
        // 'out_trade_no' => 0,        // 商户订单号 32位
        // 'total_fee'    => 1,        // 支付金额 单位分
        // 'goods_tag'    => '',       // 商品标记 32位
        // 'notify_url'   => '',       // 异步通知回调地址,不能携带参数
        // 'trade_type'   => 'JSAPI',  // 交易类型
        // 'product_id'   => '',       // 商品ID 32位
        // 'device_info'  => 'WEB',
    ];

    public function __construct($config)
    {
        $this->config = [
            'appid'        => !empty($config['appid']) ? $config['appid'] : '',
            'appsecret'    => !empty($config['appsecret']) ? $config['appsecret'] : '',
            'mch_id'       => !empty($config['mch_id']) ? $config['mch_id'] : '',
            'key'          => !empty($config['key']) ? $config['key'] : '',
            'sign_type'    => !empty($config['sign_type']) ? $config['sign_type'] : 'md5',
            'sslcert_path' => !empty($config['sslcert_path']) ? $config['sslcert_path'] : '',
        ];
    }

    /**
     * 统一下单
     * @access public
     * @param  array  $params 支付参数
     * @return string JS
     */
    public function getJsApi($params)
    {
        $this->params = $params;

        $this->params['trade_type'] = 'JSAPI';  // 交易类型
        $this->params['device_info'] = 'WEB';

        $result = $this->unifiedOrder();

        // 新请求参数
        $params = [
            'appId'     => $result['appid'],
            'timeStamp' => time(),
            'nonceStr'  => $this->getNonceStr(32),
            'package'   => 'prepay_id=' . $result['prepay_id'],
            'signType'  => strtoupper($this->config['sign_type']),
        ];

        $params['paySign'] = $this->getSign($params);
        $js_api_parameters = json_encode($params);

        return [
            'js_api_parameters' => $js_api_parameters,
            'notify_url' => $this->params['notify_url'],
            'js' => '<script type="text/javascript">function jsApiCall(){WeixinJSBridge.invoke("getBrandWCPayRequest",' . $js_api_parameters . ',function(res){if (res.err_msg == "get_brand_wcpay_request:ok") {window.location.replace("' . $this->params['notify_url'] . '?out_trade_no=' . $this->params['out_trade_no'] . '");} else if (res.err_msg == "get_brand_wcpay_request:cancel") {alert("已取消微信支付!");}});}function callpay(){if (typeof WeixinJSBridge == "undefined"){if( document.addEventListener ){document.addEventListener("WeixinJSBridgeReady", jsApiCall, false);}else if (document.attachEvent){document.attachEvent("WeixinJSBridgeReady", jsApiCall);document.attachEvent("onWeixinJSBridgeReady", jsApiCall);}}else{jsApiCall();}}</script>',
        ];
    }

    /**
     * 二维码支付
     * @access public
     * @param
     * @return string 二维码图片地址
     */
    public function qrcode()
    {
        $this->params['trade_type'] = 'NATIVE';  // 交易类型
        $this->params['device_info'] = 'WEB';

        $result = $this->unifiedOrder();
        $code_url = urlencode($result['code_url']);
        return 'http://paysdk.weixin.qq.com/example/qrcode.php?data=' . $code_url;
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
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $result = (array)simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        halt($result);
        if ($result['return_code'] == 'SUCCESS') {
            /*if (!empty($GLOBALS['out_trade_no'])) {
                $result = $this->queryOrder(['out_trade_no' => $GLOBALS['out_trade_no']]);
            }*/


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
    public function refund($params)
    {
        $this->params = $params;

        $this->params['appid'] = $this->config['appid'];
        $this->params['mch_id'] = $this->config['mch_id'];
        $this->params['nonce_str'] = $this->getNonceStr(32);
        $this->params['out_refund_no'] = $this->config['mch_id'] . date('YmdHis');
        $this->params['op_user_id'] = $this->config['mch_id'];

        $this->params['sign'] = $this->getSign($this->params);

        $url = "https://api.mch.weixin.qq.com/pay/orderquery";
        $response = $this->postXmlCurl($this->toXml(), $url, true);
        $result = $this->formXml($response);

        if ($result['return_code'] == 'FAIL') {
            return false;
        }

        if ($result['result_code'] == 'SUCCESS') {
            return true;
        } elseif ($result['err_code'] == 'TRADE_STATE_ERROR') {
            return true;
        } else {
            return false;
        }



        return $result;

        /*if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
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
        return $result;*/
    }

    /**
     * 获得订单信息
     * @access public
     * @param
     * @return void
     */
    public function queryOrder($params)
    {
        $this->params['appid']    = $this->config['appid'];
        $this->params['mch_id']    = $this->config['mch_id'];
        $this->params['nonce_str'] = $this->getNonceStr(32);

        if (!empty($params['transaction_id'])) {
            $this->params['transaction_id'] = $params['transaction_id'];
        }

        if (!empty($params['out_trade_no'])) {
            $this->params['out_trade_no'] = $params['out_trade_no'];
        }

        if (empty($this->params['transaction_id'])) {
            unset($this->params['transaction_id']);
        }

        if (empty($this->params['out_trade_no'])) {
            unset($this->params['out_trade_no']);
        }

        $this->params['sign'] = $this->getSign($this->params);

        $url = "https://api.mch.weixin.qq.com/pay/orderquery";
        $response = $this->postXmlCurl($this->toXml(), $url);
        $result = $this->formXml($response);
        return $result;
    }

    /**
     * 生成支付临时订单
     * @access private
     * @param
     * @return array
     */
    private function unifiedOrder()
    {
        $this->params['appid']            = $this->config['appid'];
        $this->params['mch_id']           = $this->config['mch_id'];
        $this->params['nonce_str']        = $this->getNonceStr(32);
        $this->params['spbill_create_ip'] = request()->ip(0, true);
        $this->params['time_start']       = date('YmdHis');
        $this->params['time_expire']      = date('YmdHis', time() + 600);
        $this->params['openid']           = '';
        $this->params['sign']             = $this->getSign($this->params);

        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $response = $this->postXmlCurl($this->toXml(), $url);
        $result = $this->formXml($response);
        return $result;
    }

    /**
     * 将array转为xml
     * @access private
     * @param
     * @return array
     */
    private function toXml()
    {
        $xml = '<xml>';
        foreach ($this->params as $key => $value) {
            if ($value != '' && !is_array($value)) {
                $xml .= '<' . $key . '>' . $value . '</' . $key . '>';
            }
        }
        $xml .= '</xml>';

        return $xml;
    }

    /**
     * 将xml转为array
     * @access private
     * @param  string $xml
     * @return array
     */
    private function formXml($xml)
    {
        libxml_disable_entity_loader(true);
        $data = (array)simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        return $data;
    }

    /**
     * 以post方式提交xml到对应的接口url
     * @access private
     * @param  string  $xml    需要post的xml数据
     * @param  string  $url    url
     * @param  intval  $second url执行超时时间，默认30s
     * @return mixed
     */
    private function postXmlCurl($xml, $url, $useCert = false, $second = 30)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_TIMEOUT, $second);        //设置超时
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);        //严格校验
        curl_setopt($curl, CURLOPT_HEADER, false);            //设置header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);    //要求结果为字符串且输出到屏幕上
        if($useCert == true){
            //设置证书 使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch,CURLOPT_SSLCERTTYPE, 'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT, $this->config['SSLCERT_PATH']);
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY, $this->config['SSLKEY_PATH']);
        }
        curl_setopt($curl, CURLOPT_POST, true);                //post提交方式
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);        //post传输数据
        $data = curl_exec($curl);                            //运行curl

        if($data){
            curl_close($curl);
            //返回结果
            return $data;
        } else {
            $error = curl_errno($curl);
            curl_close($curl);
            return 'curl出错，错误码:' . $error;
        }
    }

    /**
     * 生成签名
     * @access private
     * @param  array $params
     * @return 加密签名
     */
    private function getSign($params)
    {
        ksort($params);

        $sign = '';
        foreach ($params as $key => $value) {
            if (!in_array($key, ['sign', 'sslcert_path', '']) && !is_array($value)) {
                $sign .= $key . '=' . $value . '&';
            }
        }
        $sign .= 'key=' . $this->config['key'];
        $sign = trim($sign, '&');
        $sign = $this->config['sign_type']($sign);

        return strtoupper($sign);
    }

    /**
     * 产生随机字符串，不长于32位
     * @access private
     * @param  intval $length
     * @return 产生的随机字符串
     */
    private function getNonceStr($length = 32)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $string = '';
        for ($i=0; $i < $length; $i++) {
            $string .= substr($chars, mt_rand(0, strlen($chars) -1), 1);
        }
        return $string;
    }
}
