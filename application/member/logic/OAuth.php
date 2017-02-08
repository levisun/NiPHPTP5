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

use think\Model;
use think\Request;
use think\Url;
use app\admin\model\MemberOauth as MemberMemberOauth;

class OAuth extends Model
{
    protected $request = null;

    protected function initialize()
    {
        parent::initialize();

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

        $member_oauth = new MemberMemberOauth;

        halt($user_info);
        return Url::build('/member');
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

        // 获得域名地址
        $domain = $this->request->root(true);
        $domain = strtr($domain, ['/index.php' => '']);
        $callback = $domain . Url::build('/member/login') . '?type=' . $type;

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
