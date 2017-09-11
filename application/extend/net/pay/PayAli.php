<?php
/**
 *
 */


/*
$param = array(
    'body'         => '商品描述 128位',
    'subject'      => '商品详情 256位',,
    'out_trade_no' => '商户订单号 64位 数字',
    'total_amount' => '1.00 单位元',
    'product_code' => 'QUICK_WAP_WAY',
    'notify_url'   => '异步通知回调地址,不能携带参数',
    'return_url'   => '同步通知回调地址,不能携带参数',
);
*/
namespace net\pay;

class PayAli
{
    protected $gatewayUrl = 'https://openapi.alipay.com/gateway.do';

    // 支付配置
    protected $config = [];

    protected $params = [];

    function __construct($config)
    {
        $this->config = [
            'app_id'      => !empty($config['app_id']) ? $config['app_id'] : '',
            'method'      => !empty($config['method']) ? $config['method'] : '',
            'format'      => !empty($config['format']) ? $config['format'] : 'JSON',
            'charset'     => !empty($config['charset']) ? $config['charset'] : 'UTF-8',
            'sign_type'   => !empty($config['sign_type']) ? $config['sign_type'] : 'RSA2',
            'version'     => !empty($config['version']) ? $config['version'] : '1.0',
            'biz_content' => !empty($config['biz_content']) ? $config['biz_content'] : '',
        ];
    }

    public function wapPay($params)
    {
        $this->params = $params;
        $this->params['method']       = 'alipay.trade.wap.pay';
        $this->params['product_code'] = 'QUICK_WAP_WAY';
        $this->params['timestamp']    = date('Y-m-d H:i:s');
        $this->params['app_id']       = $this->config['app_id'];
        $this->params['format']       = $this->config['format'];
        $this->params['charset']      = $this->config['charset'];
        $this->params['sign_type']    = $this->config['sign_type'];
        $this->params['version']      = $this->config['version'];
        $this->params['biz_content']  = $this->config['biz_content'];
        $this->params['sign']         = $this->getSign($this->params);

        return $this->buildRequestForm();
    }

    /**
     * 建立请求，以表单HTML形式构造（默认）
     * @access private
     * @param
     * @return 提交表单HTML文本
     */
    protected function buildRequestForm()
    {
        $form = '<form id="alipaysubmit" name="alipaysubmit" action="' . $this->gatewayUrl . '?charset=' . $this->config['charset'] . '" method="POST">';
        foreach ($this->params as $key => $value) {
            if (!empty($value)) {
                $form .= '<input type="hidden" name="' . $key . '" value="' . str_replace('\'', '&apos;', $value) . '">';
            }
        }
        $form .= '<input type="submit" value="ok" style="display:none;">';
        $form .= '</form>';
        $form .= '<script>document.forms["alipaysubmit"].submit();</script>'
        return $form;
    }

    /**
     * 将array转为json
     * @access private
     * @param
     * @return array
     */
    private function toJSON()
    {
        $json = '';
        foreach ($this->params as $key => $value) {
            if ($value != '' && !is_array($value)) {
                $json .= $key . '=' . urlencode($value) . '&';;
            }
        }
        $json = trim($json, '&');

        return $json;
    }

    /**
     * 以post方式提交xml到对应的接口url
     * @access private
     * @param  string  $json   需要post的json数据
     * @param  string  $url    url
     * @return mixed
     */
    private function postXmlCurl($json, $url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        $headers = ['content-type: application/x-www-form-urlencoded;charset=' . $this->config['charset']];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $data = curl_exec($curl);

        if ($data) {
            /*$http_status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if (200 !== $http_status_code) {
                return $data, $http_status_code;
            }*/
            curl_close($curl);
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

        $to_be_signed = '';
        foreach ($params as $key => $value) {
            if (!in_array($key, ['sign', 'sign_type']) && !is_array($value) && $value != '') {
                $to_be_signed .= $key . '=' . $value . '&';
            }
        }
        $to_be_signed = trim($to_be_signed, '&');

        $pri_key = file_get_contents($this->config['rsa_file_path']);
        $res = openssl_get_privatekey($pri_key);

        if (!$res) {
            halt('您使用的私钥格式错误，请检查RSA私钥配置');
        }

        if ($this->config['sign_type'] == 'RSA2') {
            openssl_sign($to_be_signed, $sign, $res, OPENSSL_ALGO_SHA256);
        } else {
            openssl_sign($to_be_signed, $sign, $res);
        }

        openssl_free_key($res);

        return base64_encode($sign);
    }
}
