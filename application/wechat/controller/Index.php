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
use net\Wechat as NetWechat;
use app\wechat\logic\Api as LogicApi;
use app\wechat\logic\Attention as LogicAttention;
use app\wechat\logic\AutoKey as LogicAutoKey;
use app\member\logic\Account as MemberLogicAccount;

class Index extends Controller
{
    protected $apiLogic;
    protected $wechatMemberLogic;
    protected $autoKeyLogic;
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
        // Log::key($this->request->ip(0, true));

        Config::load(CONF_PATH . 'website.php');

        $this->apiLogic          = new LogicApi;
        $this->autoKeyLogic      = new LogicAutoKey;
        $this->attentionLogic    = new LogicAttention;
        $this->wechatMemberLogic = new MemberLogicAccount;
        $this->apiLogic->server();
    }

    public function index()
    {
        switch ($this->apiLogic->type) {
            case NetWechat::MSGTYPE_TEXT:
                $this->text();
                break;

            case NetWechat::MSGTYPE_IMAGE:
                $this->image();
                break;

            case NetWechat::MSGTYPE_LOCATION:
                $this->location();
                break;

            case NetWechat::MSGTYPE_LINK:
                $this->link();
                break;

            case NetWechat::MSGTYPE_VOICE:
                $this->voice();
                break;

            case NetWechat::MSGTYPE_VIDEO:
            case NetWechat::MSGTYPE_SHORTVIDEO:
                $this->video();
                break;

            case NetWechat::MSGTYPE_MUSIC:
                $this->music();
                break;

            case NetWechat::MSGTYPE_NEWS:
                $this->news();
                break;

            case NetWechat::MSGTYPE_EVENT:
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
        if ($this->apiLogic->type != NetWechat::MSGTYPE_TEXT) {
            return false;
        }

        // 关键词回复信息
        $data = $this->autoKeyLogic->reply($this->apiLogic->key['text']);
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
        if ($this->apiLogic->type != NetWechat::MSGTYPE_IMAGE) {
            return false;
        }
        $this->apiLogic->key['image'];
        return $this->apiLogic->wechat
        ->image($this->apiLogic->key['image']['mediaid'])
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
        if ($this->apiLogic->type != NetWechat::MSGTYPE_LOCATION) {
            return false;
        }
        $this->apiLogic->key['location'];
    }

    /**
     * 链接信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function link()
    {
        if ($this->apiLogic->type != NetWechat::MSGTYPE_LINK) {
            return false;
        }
        $this->apiLogic->key['link'];
    }

    /**
     * 音频信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function voice()
    {
        if ($this->apiLogic->type != NetWechat::MSGTYPE_VOICE) {
            return false;
        }
        $this->apiLogic->key['voice'];
    }

    /**
     * 视频信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function video()
    {
        if ($this->apiLogic->type != NetWechat::MSGTYPE_VIDEO &&
            $this->apiLogic->type != NetWechat::MSGTYPE_SHORTVIDEO) {
            return false;
        }
        $this->apiLogic->key['video'];
    }

    /**
     * 音乐信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function music()
    {
        if ($this->apiLogic->type != NetWechat::MSGTYPE_MUSIC) {
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
        if ($this->apiLogic->type != NetWechat::MSGTYPE_NEWS) {
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
        if ($this->apiLogic->type != NetWechat::MSGTYPE_EVENT) {
            return false;
        }

        // 关注事件
        if ($this->apiLogic->event['event'] == NetWechat::EVENT_SUBSCRIBE) {
            // 获取二维码的场景值
            if ($this->apiLogic->key['sceneId']) {

            }

            // 更新微信用户信息
            $this->wechatMemberLogic->AEMember($this->apiLogic->userData, $this->apiLogic->formUser, 1);

            // 关注回复信息
            $data = $this->attentionLogic->reply();
            return $this->reply($data);
        }

        // 取消关注事件
        if ($this->apiLogic->event['event'] == NetWechat::EVENT_UNSUBSCRIBE) {
            // 更新微信用户信息
            $this->wechatMemberLogic->AEMember($this->apiLogic->userData, $this->apiLogic->formUser, 0);
        }

        // 上报地理位置事件
        if ($this->apiLogic->event['event'] == NetWechat::EVENT_LOCATION) {
            $this->apiLogic->key['eventLocation'];
        }

        // 点击菜单跳转链接
        if ($this->apiLogic->event['event'] == NetWechat::EVENT_MENU_VIEW) {
            # code...
        }

        // 点击菜单拉取消息
        if ($this->apiLogic->event['event'] == NetWechat::EVENT_MENU_CLICK) {
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
            return $this->apiLogic->wechat->news($news)->reply();
        } else {
            return $this->apiLogic->wechat->text($text)->reply();
        }
    }
}
