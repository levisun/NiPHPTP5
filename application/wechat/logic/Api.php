<?php
/**
 *
 * 微信接口 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  wechat\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Api.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\wechat\logic;

use think\Model;
use think\Request;
use think\Cache;
use think\Cookie;
use net\Wechat as NetWechat;
use app\admin\model\Config as ModelConfig;
use app\member\logic\Account as MemberLogicAccount;

class Api extends Model
{
    protected $request = null;

    public $wechat;
    public $type;           // 消息类型
    public $event = [];     // 事件类型
    public $formUser;      // 请求用户ID
    public $userData = []; // 请求用户信息
    public $key = [];       // 请求内容

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();

        $data = $this->getConfig();
        $option = [
            'token'          => $data['wechat_token'],
            'encodingaeskey' => $data['wechat_encodingaeskey'],
            'appid'          => $data['wechat_appid'],
            'appsecret'      => $data['wechat_appsecret']
        ];

        $this->wechat = new NetWechat($option);
    }

    /**
     * 服务器
     * @access public
     * @param
     * @return void
     */
    public function server()
    {
        $this->wechat->valid();

        $this->type                 = $this->wechat->getRev()->getRevType();
        $this->event                = $this->wechat->getRevEvent();
        $this->formUser             = $this->wechat->getRevFrom();
        $this->userData             = $this->wechat->getUserInfo($this->formUser);
        $this->key['sceneId']       = escape_xss($this->wechat->getRevSceneId());   // 扫公众号二维码返回值
        $this->key['eventLocation'] = escape_xss($this->wechat->getRevEventGeo());  // 获得的地理信息
        $this->key['text']          = escape_xss($this->wechat->getRevContent());   // 文字信息
        $this->key['image']         = escape_xss($this->wechat->getRevPic());       // 图片信息
        $this->key['location']      = escape_xss($this->wechat->getRevGeo());       // 地理信息
        $this->key['link']          = escape_xss($this->wechat->getRevLink());      // 链接信息
        $this->key['voice']         = escape_xss($this->wechat->getRevVoice());     // 音频信息
        $this->key['video']         = escape_xss($this->wechat->getRevVideo());     // 视频信息
        $this->key['result']        = escape_xss($this->wechat->getRevResult());    // 群发或模板信息回复内容

    }

    /**
     * 查询微信用户openid
     * 生成openid cookie
     * 新增或编辑微信用户
     * @access public
     * @param
     * @return boolean
     */
    public function openid()
    {
        // 是否微信请求
        if (!is_wechat_request()) {
            return false;
        }

        if (Cookie::has('WECHAT_OPENID')) {
            return true;
        }

        // 网页授权获得用户openid后再获得用户信息
        if ($this->request->has('code', 'param')) {
            $code = $this->request->param('code');
            $state = $this->request->param('state');
            if ($state == 'wechatOauth') {
                // 通过code获得openid
                $result = $this->wechat->getOauthAccessToken($code);
                // 通过openid获得用户信息
                $reuslt = $this->wechat->getUserInfo($result['openid']);
                // 增或编辑用户信息
                $member_account = new MemberLogicAccount;
                if (!$member_account->hasWecahtMember($result)) {
                    $member_account->AUWecahtMember($result);
                }
                Cookie::set('WECHAT_OPENID', $reuslt['openid']);
            }
        } else {
            // 直接跳转不授权获取code
            $url = $this->request->url(true);
            $url = $this->wechat->getOauthRedirect($url, 'wechatOauth', 'snsapi_base');
            redirect($url);
        }
    }

    /**
     * 获取JsApi使用签名
     * @access public
     * @param
     * @return mixed
     */
    public function jsSign()
    {
        // 是否微信请求
        if (!is_wechat_request()) {
            return false;
        }

        $result = $this->wechat->getJsSign($this->request->url(true));

        return [
            'wechat_js_sign' => $result,
            'wecaht_js_code' => '<script type="text/javascript">wx.config({debug: false,appId: "' . $result['appId'] . '",timestamp: ' . $result['timestamp'] . ',nonceStr: "' . $result['nonceStr'] . '",signature: "' . $result['signature'] . '",jsApiList: ["checkJsApi","onMenuShareTimeline","onMenuShareAppMessage","onMenuShareQQ","onMenuShareWeibo","onMenuShareQZone","hideMenuItems","showMenuItems","hideAllNonBaseMenuItem","showAllNonBaseMenuItem","translateVoice","startRecord","stopRecord","onVoiceRecordEnd","playVoice","onVoicePlayEnd","pauseVoice","stopVoice","uploadVoice","downloadVoice","chooseImage","previewImage","uploadImage","downloadImage","getNetworkType","openLocation","getLocation","hideOptionMenu","showOptionMenu","closeWindow","scanQRCode","chooseWXPay","openProductSpecificView","addCard","chooseCard","openCard"]});</script>'
        ];
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
        $CACHE = check_key($map, __METHOD__);

        $result =
        $config->field(true)
        ->where($map)
        ->cache($CACHE)
        ->select();

        $data = [];
        foreach ($result as $value) {
            $value = $value->toArray();
            $data[$value['name']] = $value['value'];
        }

        return $data;
    }
}
