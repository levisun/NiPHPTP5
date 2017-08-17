<?php
/**
 *
 */
namespace net\pay;

class PayAli
{
    // 支付配置
    protected $config = [];

    protected $params = [];

    function __construct($config)
    {
        $this->config = [
            'partner'       => !empty($config['partner']) ? $config['partner'] : '',
            'seller_email'  => !empty($config['seller_email']) ? $config['seller_email'] : '',
            'key'           => !empty($config['key']) ? $config['key'] : '',
            'sign_type'     => !empty($config['sign_type']) ? $config['sign_type'] : 'md5',
            'input_charset' => !empty($config['input_charset']) ? $config['input_charset'] : 'utf-8',

            'cacert'        => !empty($config['cacert']) ? $config['cacert'] : '',
            'transport'     => !empty($config['transport']) ? $config['transport'] : 'http',
        ];
    }

    public function formPay($params)
    {
        $this->params = $params;

        $this->params['service']        = 'create_direct_pay_by_user';
        $this->params['partner']        = $this->config['partner'];
        $this->params['seller_email']   = $this->config['seller_email'];
        $this->params['payment_type']   = 1;
        $this->params['_input_charset'] = $this->config['input_charset'];

        $this->params['sign']           = $this->getSign($this->params);
        $this->params['sign_type']      = strtoupper($this->config['sign_type']);

        $input = '';
        foreach ($this->params as $key => $value) {
            $input .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />',
        }

        return [
            'action_url' => 'https://mapi.alipay.com/gateway.do?_input_charset=' . $this->config['input_charset'],
            'input'      => $input,
        ];
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
        reset($params);

        $sign = '';
        foreach ($params as $key => $value) {
            if (!in_array($key, ['sign', 'sign_type']) && !is_array($value) && $value != '') {
                $sign .= $key . '=' . $value . '&';
            }
        }
        $sign = trim($sign, '&') . $this->config['key'];
        return $this->config['sign_type']($sign);
    }
}
