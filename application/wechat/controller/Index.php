<?php
/**
 *
 * 微信接口 - 控制器
 *
 * @package   NiPHPCMS
 * @category  wechat\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Index.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\wechat\controller;

use think\Controller;
use think\Url;
use think\Lang;
use think\Config;
use think\Log;
use net\Wechat;
use app\wechat\logic\Api as WechatApi;
use app\wechat\logic\Attention as WechatAttention;
use app\wechat\logic\AutoKey as WechatAutoKey;
use app\index\logic\WechatApi as WechatMember;

class Index extends Controller
{
    protected $api;
    protected $wechat_member;
    protected $auto_key;
    protected $attention;

    /**
     * 初始化
     * @access protected
     * @param
     * @return void
     */
    protected function _initialize()
    {
        // 设置IP为授权Key
        Log::key($this->request->ip(0, true));

        Config::load(CONF_PATH . 'website.php');

        $this->api           = new WechatApi;
        $this->wechat_member = new WechatMember;
        $this->auto_key      = new WechatAutoKey;
        $this->attention     = new WechatAttention;
    }

    public function index()
    {
        switch ($this->api->type) {
            case Wechat::MSGTYPE_TEXT:
                $this->text();
                break;

            case Wechat::MSGTYPE_IMAGE:
                $this->image();
                break;

            case Wechat::MSGTYPE_LOCATION:
                $this->location();
                break;

            case Wechat::MSGTYPE_LINK:
                $this->link();
                break;

            case Wechat::MSGTYPE_VOICE:
                $this->voice();
                break;

            case Wechat::MSGTYPE_VIDEO:
            case Wechat::MSGTYPE_SHORTVIDEO:
                $this->video();
                break;

            case Wechat::MSGTYPE_MUSIC:
                $this->music();
                break;

            case Wechat::MSGTYPE_NEWS:
                $this->news();
                break;

            case Wechat::MSGTYPE_EVENT:
                $this->event();
                break;

            default:
                $this->text();
                break;
        }
    }

    /**
     * 文字信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function text()
    {
        if ($this->api->type != Wechat::MSGTYPE_TEXT) {
            return false;
        }

        // 关键词回复信息
        $data = $this->auto_key->reply($this->api->key['text']);
        return $this->reply($data);

    }

    /**
     * 图片信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function image()
    {
        if ($this->api->type != Wechat::MSGTYPE_IMAGE) {
            return false;
        }
        $this->api->key['image'];
        return $this->api->wechat
        ->image($this->api->key['image']['mediaid'])
        ->reply();
    }

    /**
     * 地址信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function location()
    {
        if ($this->api->type != Wechat::MSGTYPE_LOCATION) {
            return false;
        }
        $this->api->key['location'];
    }

    /**
     * 链接信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function link()
    {
        if ($this->api->type != Wechat::MSGTYPE_LINK) {
            return false;
        }
        $this->api->key['link'];
    }

    /**
     * 音频信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function voice()
    {
        if ($this->api->type != Wechat::MSGTYPE_VOICE) {
            return false;
        }
        $this->api->key['voice'];
    }

    /**
     * 视频信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function video()
    {
        if ($this->api->type != Wechat::MSGTYPE_VIDEO &&
            $this->api->type != Wechat::MSGTYPE_SHORTVIDEO) {
            return false;
        }
        $this->api->key['video'];
    }

    /**
     * 音乐信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function music()
    {
        if ($this->api->type != Wechat::MSGTYPE_MUSIC) {
            return false;
        }
    }

    /**
     * 图文信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function news()
    {
        if ($this->api->type != Wechat::MSGTYPE_NEWS) {
            return false;
        }
    }

    /**
     * 事件推送信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function event()
    {
        if ($this->api->type != Wechat::MSGTYPE_EVENT) {
            return false;
        }

        // 关注事件
        if ($this->api->event['event'] == Wechat::EVENT_SUBSCRIBE) {
            // 获取二维码的场景值
            if ($this->api->key['sceneId']) {

            }

            // 更新微信用户信息
            $this->wechat_member->wechatMemberInfo($this->api->user_data, $this->api->form_user, 1);

            // 关注回复信息
            $data = $this->attention->reply();
            return $this->reply($data);
        }

        // 取消关注事件
        if ($this->api->event['event'] == Wechat::EVENT_UNSUBSCRIBE) {
            // 更新微信用户信息
            $this->wechat_member->wechatMemberInfo($this->api->user_data, $this->api->form_user, 0);
        }

        // 上报地理位置事件
        if ($this->api->event['event'] == Wechat::EVENT_LOCATION) {
            $this->api->key['eventLocation'];
        }

        // 点击菜单跳转链接
        if ($this->api->event['event'] == Wechat::EVENT_MENU_VIEW) {
            # code...
        }

        // 点击菜单拉取消息
        if ($this->api->event['event'] == Wechat::EVENT_MENU_CLICK) {
            # code...
        }
    }

    /**
     * 回复信息
     * @access private
     * @param  array $data
     * @return string
     */
    private function reply($data)
    {
        if (is_string($data)) {
            $text = $data;
        } elseif (is_array($data) && !empty($data['item'])) {
            $news = $data['item'];
        } elseif (is_array($data) && !empty($data[0])) {
            $text = $data[0];
        }

        if (!empty($news)) {
            return $this->api->wechat->news($news)->reply();
        } else {
            return $this->api->wechat->text($text)->reply();
        }
    }
}
