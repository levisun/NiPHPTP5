<?php
/**
 * 微信重构类
 *
 * @package   NiPHPCMS
 * @category  Wechat\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Wechat.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/08/14
 */
namespace app\wechat\logic;

use think\Cache;
use think\Request;
use think\Cookie;
use net\Wechat as NetWechat;
use util\File as UtilFile;
use app\admin\model\Config as ModelConfig;


class Wechat extends NetWechat
{
    protected $request = null;

    public function __construct()
    {
        $this->request = Request::instance();

        $data = $this->getConfig();
        $option = [
            'token'          => $data['wechat_token'],
            'encodingaeskey' => $data['wechat_encodingaeskey'],
            'appid'          => $data['wechat_appid'],
            'appsecret'      => $data['wechat_appsecret']
        ];

        parent::__construct($option);
    }

    /**
     * 查询微信用户openid
     * 生成openid cookie
     * @access public
     * @param
     * @return boolean
     */
    public function getOpenId()
    {
        if (Cookie::has('WECHAT_OPENID')) {
            return true;
        }

        // 网页授权获得用户openid后再获得用户信息
        if ($this->request->has('code', 'param')) {
            $code = $this->request->param('code');
            $state = $this->request->param('state');
            if ($state == 'wechatOauth') {
                // 通过code获得openid
                $result = $this->getOauthAccessToken($code);
                Cookie::forever('WECHAT_OPENID', $result['openid']);
            }
        } else {
            // 直接跳转不授权获取code
            $url = $this->request->url(true);
            $url = $this->getOauthRedirect($url, 'wechatOauth', 'snsapi_base');
            redirect($url);
        }
    }

    /**
     * 获取JsApi使用签名
     * @access public
     * @param
     * @return mixed
     */
    public function jsSign($debug = 'false')
    {
        $result = parent::getJsSign($this->request->url(true));

        return [
            'wechat_js_sign' => $result,
            'wecaht_js_code' => 'wx.config({debug: '. $debug . ',appId: "' . $result['appId'] . '",timestamp: ' . $result['timestamp'] . ',nonceStr: "' . $result['nonceStr'] . '",signature: "' . $result['signature'] . '",jsApiList: ["checkJsApi","onMenuShareTimeline","onMenuShareAppMessage","onMenuShareQQ","onMenuShareWeibo","onMenuShareQZone","hideMenuItems","showMenuItems","hideAllNonBaseMenuItem","showAllNonBaseMenuItem","translateVoice","startRecord","stopRecord","onVoiceRecordEnd","playVoice","onVoicePlayEnd","pauseVoice","stopVoice","uploadVoice","downloadVoice","chooseImage","previewImage","uploadImage","downloadImage","getNetworkType","openLocation","getLocation","hideOptionMenu","showOptionMenu","closeWindow","scanQRCode","chooseWXPay","openProductSpecificView","addCard","chooseCard","openCard"]});wx.error(function (res) {alert(res.errMsg);});'
        ];
    }

    /**
     * AIP请求
     * @access public
     * @param
     * @return void
     */
    public function apiRequest()
    {
        $this->valid();

        $result = [
            'type'     => $this->getRev()->getRevType(),
            'event'    => $this->getRevEvent(),
            'formUser' => $this->getRevFrom(),
            'userData' => $this->getUserInfo($this->getRevFrom()),
            'key'      => [
                'sceneId'       => escape_xss($this->getRevSceneId()),      // 扫公众号二维码返回值
                'eventLocation' => escape_xss($this->getRevEventGeo()),     // 获得的地理信息
                'text'          => escape_xss($this->getRevContent()),      // 文字信息
                'image'         => escape_xss($this->getRevPic()),          // 图片信息
                'location'      => escape_xss($this->getRevGeo()),          // 地理信息
                'link'          => escape_xss($this->getRevLink()),         // 链接信息
                'voice'         => escape_xss($this->getRevVoice()),        // 音频信息
                'video'         => escape_xss($this->getRevVideo()),        // 视频信息
                'result'        => escape_xss($this->getRevResult())        // 群发或模板信息回复内容
            ],
        ];

        return $result;
    }

    /**
     * 设置缓存，按需重载
     * @param  string  $cachename
     * @param  mixed   $value
     * @param  int     $expired
     * @return boolean
     */
    protected function setCache($cachename, $value, $expired)
    {
        $expired = $expired ? $expired : 7100;
        $time = time() + $expired;
        $file = CACHE_PATH . $cachename . '.php';

        $data = array(
            'value' => $value,
            'time' => $time,
            );

        UtilFile::create($file, '<?php $wat=' . var_export($data, true) . ';?>', true);
        return false;
    }

    /**
     * 获取缓存，按需重载
     * @param string $cachename
     * @return mixed
     */
    protected function getCache($cachename)
    {
        $file = CACHE_PATH . $cachename . '.php';
        if (is_file($file)) {
            include $file;
            if (!empty($wat) && $wat['time'] >= time()) {
                return $wat['value'];
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * 清除缓存，按需重载
     * @param string $cachename
     * @return boolean
     */
    protected function removeCache($cachename)
    {
        $file = CACHE_PATH . $cachename . '.php';
        unlink($file);
        return false;
    }

    /**
     * 获得微信接口配置
     * @access private
     * @param
     * @return array
     */
    private function getConfig()
    {
        $map = [
            'name' => [
                'in',
                'wechat_token,wechat_encodingaeskey,wechat_appid,wechat_appsecret'
            ],
            'lang' => 'niphp'
        ];

        $config = new ModelConfig;

        $result =
        $config->field(true)
        ->where($map)
        ->cache(!APP_DEBUG, 0)
        ->select();

        $data = [];
        foreach ($result as $value) {
            $value = $value->toArray();
            $data[$value['name']] = $value['value'];
        }

        return $data;
    }
}