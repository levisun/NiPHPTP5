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
class Index extends Controller
{
    protected $model;

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

        $this->model = new WechatApi;
    }

    public function index()
    {
        $this->text();
        $this->image();
        $this->location();
        $this->link();
        $this->voice();
        $this->video();
        $this->music();
        $this->news();

        $this->event();
    }

    /**
     * 文字信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function text()
    {
        if ($this->model->type != Wechat::MSGTYPE_TEXT) {
            return false;
        }
        // 关键词回复信息
        $model = new WechatAutoKey;
        $data = $model->reply($this->model->key['text']);
        if (isset($data['item'])) {
            return $this->model->wechat->text($data['item'])->reply();
        } else {
            return $this->model->wechat->text($data[0])->reply();
        }

    }

    /**
     * 图片信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function image()
    {
        if ($this->model->type != Wechat::MSGTYPE_IMAGE) {
            return false;
        }
        $this->model->key['image'];
        $this->model->wechat
        ->image($this->model->key['image']['mediaid'])
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
        if ($this->model->type != Wechat::MSGTYPE_LOCATION) {
            return false;
        }
        $this->model->key['location'];
    }

    /**
     * 链接信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function link()
    {
        if ($this->model->type != Wechat::MSGTYPE_LINK) {
            return false;
        }
        $this->model->key['link'];
    }

    /**
     * 音频信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function voice()
    {
        if ($this->model->type != Wechat::MSGTYPE_VOICE) {
            return false;
        }
        $this->model->key['voice'];
    }

    /**
     * 视频信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function video()
    {
        if ($this->model->type != Wechat::MSGTYPE_VIDEO &&
            $this->model->type != Wechat::MSGTYPE_SHORTVIDEO) {
            return false;
        }
        $this->model->key['video'];
    }

    /**
     * 音乐信息
     * @access protected
     * @param
     * @return mixed
     */
    protected function music()
    {
        if ($this->model->type != Wechat::MSGTYPE_MUSIC) {
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
        if ($this->model->type != Wechat::MSGTYPE_NEWS) {
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
        if ($this->model->type != Wechat::MSGTYPE_EVENT) {
            return false;
        }

        // 关注事件
        if ($this->model->event['event'] == Wechat::EVENT_SUBSCRIBE) {
            // 获取二维码的场景值
            if ($this->model->key['sceneId']) {

            }

            // 关注回复信息
            $model = new WechatAttention;
            $data = $model->reply();
            return $this->reply($data);
        }

        // 取消关注事件
        if ($this->model->event['event'] == Wechat::EVENT_UNSUBSCRIBE) {
        }

        // 上报地理位置事件
        if ($this->model->event['event'] == Wechat::EVENT_LOCATION) {
            $this->model->key['eventLocation'];
        }

        // 点击菜单跳转链接
        if ($this->model->event['event'] == Wechat::EVENT_MENU_VIEW) {
            # code...
        }

        // 点击菜单拉取消息
        if ($this->model->event['event'] == Wechat::EVENT_MENU_CLICK) {
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
        if (isset($data['item'])) {
            return $this->model->wechat->news($data['item'])->reply([], true);
        } else {
            return $this->model->wechat->text($data[0])->reply([], true);
        }
    }
}