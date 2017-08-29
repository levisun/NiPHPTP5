<?php
/**
 *
 * 第三方登录 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  member\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: OAuth.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\member\logic;

use think\Request;
use think\Url;
use think\Cookie;
use think\Config;
use net\IpLocation;
use app\admin\model\MemberOauth as ModelMemberOauth;
use app\admin\model\Member as ModelMember;
use app\admin\model\Level as ModelLevel;
use app\admin\model\LevelMember as ModelLevelMember;

class OAuth
{
    protected $request = null;

    public function __construct()
    {
        $this->request = Request::instance();
    }

    /**
     * 第三方等录
     * 回调页面
     * @access private
     * @param
     * @return array
     */
    public function login()
    {
        if ($this->request->has('code')) {
            return $this->callback();
        } else {
            return $this->authorizeURL();
        }
    }

    /**
     * 请求回调
     * @access private
     * @param
     * @return array
     */
    private function callback()
    {
        $type = $this->request->param('type');

        if ($this->request->isMobile()) {
            $display = 'mobile';
        } else {
            $display = 'default';
        }

        $class = '\\net\\oauth\\' . $type;

        $oauth = new $class($this->config(), $display);
        $oauth->getAccessToken();
        $user_info = $oauth->userinfo();
        if (!$user_info) {
            halt($oauth->error);
        }

        $this->createMember($user_info);

        return Url::build('/my');
    }

    /**
     * 创建会员
     * @access private
     * @param  array   $user_info
     * @return boolean
     */
    private function createMember($user_info)
    {
        $ip = new IpLocation();
        $area = $ip->getlocation($this->request->ip(0, true));

        $user_data = [
            'username'           => 'AV' . (time() - 1400000000),
            'nickname'           => $user_info['nick'],
            'salt'               => substr(encrypt(time()), -6),
            'stats'              => 1,
            'last_login_ip'      => $this->request->ip(0, true),
            'last_login_ip_attr' => $area['country'] . $area['area'],
            'last_login_time'    => time(),
        ];

        $member = new ModelMember;
        $member->data($user_data)
        ->isUpdate(false)
        ->save();

        if (!$member->id) {
            return false;
        }

        // 查询会员组ID
        $level = new ModelLevel;
        $level_id =
        $level->field(true)
        ->order('integral ASC, id DESC')
        ->value('id');

        // 会员组
        $data = [
            'user_id'  => $member->id,
            'level_id' => $level_id
        ];

        $level_member = new ModelLevelMember;
        $level_member->data($data)
        ->allowField(true)
        ->isUpdate(false)
        ->save();

        // 第三方关联
        $data = [
            'user_id' => $member->id,
            'openid'  => $user_info['openid'],
            'nick'    => $user_info['nick'],
            'type'    => $user_info['channel']
        ];
        $member_oauth = new ModelMemberOauth;
        $member_oauth->data($data)
        ->allowField(true)
        ->isUpdate(false)
        ->save();

        $user_data['id'] = $member->id;
        Cookie::set('USER_DATA', $user_data);
        Cookie::set(Config::get('USER_AUTH_KEY'), $user_data['id']);

        return true;
    }

    /**
     * 请求Authorize访问地址
     * @access private
     * @param
     * @return array
     */
    private function authorizeURL()
    {
        $type = $this->request->param('type');

        if ($this->request->isMobile()) {
            $display = 'mobile';
        } else {
            $display = 'default';
        }

        $class = '\\net\\oauth\\' . $type;

        $oauth = new $class($this->config(), $display);
        return $oauth->getAuthorizeURL();
    }

    /**
     * 获得OAuth设置
     * @access private
     * @param
     * @return array
     */
    private function config()
    {
        $type = $this->request->param('type');

        $callback = Url::build('/login') . '?type=' . $type;

        $config = [
            'app_key'    => '101246655',
            'app_secret' => '55f8f17f4b83f9b99c3d962f77b2a156',
            'scope'      => 'get_user_info',
            'callback'   => [
                'default' => $callback,
                'mobile'  => $callback,
            ]
        ];

        return $config;
    }
}
