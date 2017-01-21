<?php
/**
 *
 * 支付
 *
 * @package   NiPHPCMS
 * @category  net\pay\library\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Pay.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/01/03
 */
namespace net\pay\library;
class Pay
{
    // 支付配置
    protected $config = [
        'sign_type' => 'md5'
    ];

    // 请求参数
    protected $param = [];

    /**
     * 回调操作
     * 子类重新定义
     * @access protected
     * @param
     * @return mixed
     */
    protected function notify()
    {}

    /**
     * 退款操作
     * 子类重新定义
     * @access protected
     * @param
     * @return mixed
     */
    protected function refund()
    {}

    /**
     * 以post方式提交xml到对应的接口url
     * @access protected
     * @param  string  $xml    需要post的xml数据
     * @param  string  $url    url
     * @param  intval  $second url执行超时时间，默认30s
     * @return mixed
     */
    protected function postXmlCurl($xml, $url, $useCert=false, $second=30)
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
     * 将xml转为array
     * @access protected
     * @param  string $xml
     * @return array
     */
    protected function formXml($xml)
    {
        libxml_disable_entity_loader(true);
        $data = (array)simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        return $data;
    }

    /**
     * 生成签名
     * @access protected
     * @param  array $param
     * @return 加密签名
     */
    protected function getSign($param=array())
    {
        $sign = '';
        foreach ($param as $key => $value) {
            if($key != 'sign' && $value != '' && !is_array($value)){
                $sign .= $key . '=' . $value . '&';
            }
        }
        $sign .= 'key=' . $this->config['key'];
        $sign = trim($sign, '&');
        return $this->config['sign_type']($sign);
    }

    /**
     * 产生随机字符串，不长于32位
     * @access protected
     * @param  intval $length
     * @return 产生的随机字符串
     */
    protected function getNonceStr($length=32)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $string = '';
        for ($i=0; $i < $length; $i++) {
            $string .= substr($chars, mt_rand(0, strlen($chars) -1), 1);
        }
        return $string;
    }

    /**
     * 获取客户端IP地址
     * @access protected
     * @param  integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param  boolean $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    protected function getClientIp($type=0, $adv=true) {
        $type = $type ? 1 : 0;
        static $ip = NULL;
        if ($ip !== NULL) return $ip[$type];
        if ($adv) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown',$arr);
                if(false !== $pos) unset($arr[$pos]);
                $ip = trim($arr[0]);
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }

    /**
     * 保存日志
     * @access protected
     * @param  mixed $data
     * @return mixed
     */
    protected function saveLog($data)
    {
        if (is_array($data)) {
            $data = var_export($data, true);
        }

        $saveFile = LOG_PATH . 'pay' . DS . date('Ymd') . '.log';
        file_put_contents($saveFile, $data, FILE_APPEND);
    }
}