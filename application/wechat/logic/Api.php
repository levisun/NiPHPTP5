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
use think\Cache;
use net\Wechat;
use app\admin\model\Config as WechatConfig;

class Api extends Model
{
    public $wechat;
    public $type;           // 消息类型
    public $event = [];     // 事件类型
    public $form_user;      // 请求用户ID
    public $user_data = []; // 请求用户信息
    public $key = [];       // 请求内容

    protected function initialize()
    {
        parent::initialize();

        $data = $this->getConfig();
        $option = [
            'token'          => $data['wechat_token'],
            'encodingaeskey' => $data['wechat_encodingaeskey'],
            'appid'          => $data['wechat_appid'],
            'appsecret'      => $data['wechat_appsecret']
        ];

        $this->wechat = new Wechat($option);
        $this->wechat->valid();

        $this->type                 = $this->wechat->getRev()->getRevType();
        $this->event                = $this->wechat->getRevEvent();
        $this->form_user            = $this->wechat->getRevFrom();
        $this->user_data            = $this->wechat->getUserInfo($this->form_user);
        $this->key['sceneId']       = escape_xss($this->wechat->getRevSceneId());   // 扫公众号二维码返回值
        $this->key['eventLocation'] = escape_xss($this->wechat->getRevEventGeo());  // 获得的地理信息
        $this->key['text']          = escape_xss($this->wechat->getRevContent());   // 文字信息
        $this->key['image']         = escape_xss($this->wechat->getRevPic());       // 图片信息
        $this->key['location']      = escape_xss($this->wechat->getRevGeo());       // 地理信息
        $this->key['link']          = escape_xss($this->wechat->getRevLink());      // 链接信息
        $this->key['voice']         = escape_xss($this->wechat->getRevVoice());     // 音频信息
        $this->key['video']         = escape_xss($this->wechat->getRevVideo());     // 视频信息

        defined('OPENID') or define('OPENID', $this->form_user);
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

        $config = new WechatConfig;
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
