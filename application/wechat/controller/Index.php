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
// use net\Wechat as netWechat;
use util\File as UtilFile;
use app\wechat\logic\Wechat as LogicWechat;
use app\wechat\logic\Api as LogicApi;
use app\wechat\logic\Attention as LogicAttention;
use app\wechat\logic\AutoKey as LogicAutoKey;
use app\member\logic\Account as MemberLogicAccount;

class Index extends Controller
{
    protected $logicApi;
    protected $logicAutoKey;
    protected $logicAttention;

    protected $logicWechatMember;

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

        $this->logicApi          = new LogicApi;
        $this->logicAutoKey      = new LogicAutoKey;
        $this->logicAttention    = new LogicAttention;
        $this->logicWechatMember = new MemberLogicAccount;
        $this->logicApi->server();
    }

    public function index()
    {
        switch ($this->logicApi->type) {
            case LogicWechat::MSGTYPE_TEXT:
                $this->text();
                break;

            case LogicWechat::MSGTYPE_IMAGE:
                $this->image();
                break;

            case LogicWechat::MSGTYPE_LOCATION:
                $this->location();
                break;

            case LogicWechat::MSGTYPE_LINK:
                $this->link();
                break;

            case LogicWechat::MSGTYPE_VOICE:
                $this->voice();
                break;

            case LogicWechat::MSGTYPE_VIDEO:
            case LogicWechat::MSGTYPE_SHORTVIDEO:
                $this->video();
                break;

            case LogicWechat::MSGTYPE_MUSIC:
                $this->music();
                break;

            case LogicWechat::MSGTYPE_NEWS:
                $this->news();
                break;

            case LogicWechat::MSGTYPE_EVENT:
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
        if ($this->logicApi->type != LogicWechat::MSGTYPE_TEXT) {
            return false;
        }

        // 关键词回复信息
        $data = $this->logicAutoKey->reply($this->logicApi->key['text']);
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
        if ($this->logicApi->type != LogicWechat::MSGTYPE_IMAGE) {
            return false;
        }
        $this->logicApi->key['image'];
        return $this->logicApi->wechat
        ->image($this->logicApi->key['image']['mediaid'])
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
        if ($this->logicApi->type != LogicWechat::MSGTYPE_LOCATION) {
            return false;
        }
        $this->logicApi->key['location'];
    }

    /**
     * 链接信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function link()
    {
        if ($this->logicApi->type != LogicWechat::MSGTYPE_LINK) {
            return false;
        }
        $this->logicApi->key['link'];
    }

    /**
     * 音频信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function voice()
    {
        if ($this->logicApi->type != LogicWechat::MSGTYPE_VOICE) {
            return false;
        }
        $this->logicApi->key['voice'];
    }

    /**
     * 视频信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function video()
    {
        if ($this->logicApi->type != LogicWechat::MSGTYPE_VIDEO &&
            $this->logicApi->type != LogicWechat::MSGTYPE_SHORTVIDEO) {
            return false;
        }
        $this->logicApi->key['video'];
    }

    /**
     * 音乐信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function music()
    {
        if ($this->logicApi->type != LogicWechat::MSGTYPE_MUSIC) {
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
        if ($this->logicApi->type != LogicWechat::MSGTYPE_NEWS) {
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
        if ($this->logicApi->type != LogicWechat::MSGTYPE_EVENT) {
            return false;
        }

        // 关注事件
        if ($this->logicApi->event['event'] == LogicWechat::EVENT_SUBSCRIBE) {
            // 获取二维码的场景值
            if ($this->logicApi->key['sceneId']) {

            }

            // 更新微信用户信息
            $this->logicWechatMember->AUWecahtMember($this->logicApi->userData);

            // 关注回复信息
            $data = $this->logicAttention->reply();
            return $this->reply($data);
        }

        // 取消关注事件
        if ($this->logicApi->event['event'] == LogicWechat::EVENT_UNSUBSCRIBE) {
            // 更新微信用户信息
            $this->logicWechatMember->AUWecahtMember($this->logicApi->userData);
        }

        // 上报地理位置事件
        if ($this->logicApi->event['event'] == LogicWechat::EVENT_LOCATION) {
            $this->logicApi->key['eventLocation'];
        }

        // 点击菜单跳转链接
        if ($this->logicApi->event['event'] == LogicWechat::EVENT_MENU_VIEW) {
            # code...
        }

        // 点击菜单拉取消息
        if ($this->logicApi->event['event'] == LogicWechat::EVENT_MENU_CLICK) {
            # code...
        }

        // 模板消息发送结果
        if ($this->logicApi->event['event'] == LogicWechat::EVENT_SEND_TEMPLATE ||
            $this->logicApi->event['event'] == LogicWechat::EVENT_SEND_MASS) {
            $result = $this->logicApi->key['result'];
            if ($result !== false) {
                // UtilFile::create();
            }
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
            return $this->logicApi->wechat->news($news)->reply();
        } else {
            return $this->logicApi->wechat->text($text)->reply();
        }
    }
}
