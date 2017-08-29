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

use think\Request;
use think\Cookie;
use app\wechat\logic\Wechat as LogicWechat;
use app\member\logic\Account as MemberLogicAccount;

class Api
{
    protected $request = null;

    public $wechat;
    public $type;           // 消息类型
    public $event = [];     // 事件类型
    public $formUser;      // 请求用户ID
    public $userData = []; // 请求用户信息
    public $key = [];       // 请求内容

    public function __construct()
    {
        $this->request = Request::instance();

        $this->wechat = new LogicWechat();
    }

    /**
     * 获取Js分享
     * $param = ['title', 'link', 'desc', 'img', success', 'cancel', 'type', 'data_url'];
     * @access public
     * @param  array  $param
     * @return mixed
     */
    public function jsShare($param)
    {
        // 是否微信请求
        if (!is_wechat_request()) {
            return false;
        }

        if (empty($param['title']) || empty($param['link']) || empty($param['desc']) || empty($param['img'])) {
            return false;
        }

        $share_param = [
            'title'    => $param['title'],  // 分享标题
            'link'     => $param['link'],   // 分享链接
            'desc'     => $param['desc'],   // 分享描述
            'img'      => $param['img'],    // 分享图标
            'success'  => !empty($param['success']) ? $param['success'] : '',   // 用户确认分享后执行的回调函数
            'cancel'   => !empty($param['cancel']) ? $param['cancel'] : '',     // 用户取消分享后执行的回调函数

            // 分享类型,music、video或link，不填默认为link
            'type'     => !empty($param['type']) ? 'type: "' . $param['type'] . '",' : 'link',
            // 如果type是music或video，则要提供数据链接，默认为空
            'data_url' => !empty($param['data_url']) ? 'dataUrl: "' . $param['data_url'] . '",' : '',
        ];

        return 'wx.ready(function(){wx.onMenuShareTimeline({title:"' . $share_param['title'] . '",link:"' . $share_param['link'] . '",imgUrl:"' . $share_param['img'] . '",success:function(){' . $share_param['success'] . '},cancel:function(){' . $share_param['cancel'] . '}});wx.onMenuShareQQ({title:"' . $share_param['title'] . '",desc:"' . $share_param['desc'] . '",link:"' . $share_param['link'] . '",imgUrl:"' . $share_param['img'] . '",success:function(){' . $share_param['success'] . '},cancel:function(){' . $share_param['cancel'] . '}});wx.onMenuShareWeibo({title:"' . $share_param['title'] . '",desc:"' . $share_param['desc'] . '",link:"' . $share_param['link'] . '",imgUrl:"' . $share_param['img'] . '",success:function(){' . $share_param['success'] . '},cancel:function(){' . $share_param['cancel'] . '}});wx.onMenuShareQZone({title:"' . $share_param['title'] . '",desc:"' . $share_param['desc'] . '",link:"' . $share_param['link'] . '",imgUrl:"' . $share_param['img'] . '",success:function(){' . $share_param['success'] . '},cancel:function(){' . $share_param['cancel'] . '}});wx.onMenuShareAppMessage({title:"' . $share_param['title'] . '",desc:"' . $share_param['desc'] . '",link:"' . $share_param['link'] . '",imgUrl:"' . $share_param['img'] . '",type:"' . $share_param['type'] . '",dataUrl:"' . $share_param['data_url'] . '",success:function(){' . $share_param['success'] . '},cancel:function(){' . $share_param['cancel'] . '}});});';
    }

    /**
     * 查询微信用户是否存在
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

        $this->wechat->getOpenId();

        if (Cookie::has('WECHAT_OPENID')) {
            $member_account = new MemberLogicAccount;
            // 判断用户是否存在
            if (!$member_account->hasWecahtMember(Cookie::get('WECHAT_OPENID'))) {
                // 通过openid获得用户信息
                $result = $this->wechat->getUserInfo(Cookie::get('WECHAT_OPENID'));
                // 添加用户
                $member_account->AUWecahtMember($result);
            }
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
        // 是否微信请求
        if (!is_wechat_request()) {
            return false;
        }

        return $this->wechat->jsSign($debug);
    }

    /**
     * 服务器
     * @access public
     * @param
     * @return void
     */
    public function server()
    {
        $result = $this->wechat->apiRequest();

        $this->type     = $result['type'];
        $this->event    = $result['event'];
        $this->formUser = $result['formUser'];
        $this->userData = $result['userData'];
        $this->key      = $result['key'];
    }
}
