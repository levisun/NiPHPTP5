<?php
/**
 *
 * 新浪微博登陆Api
 *
 * @package   NiPHPCMS
 * @category  net\oauth\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: weibo.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/01/03
 */
namespace net\oauth;

use net\oauth\OAuth;
use net\oauth\Http as OAuthHttp;
use think\Cookie;

class weibo extends OAuth
{
    protected $AuthorizeURL = 'https://api.weibo.com/oauth2/authorize';
    protected $AccessTokenURL = 'https://api.weibo.com/oauth2/access_token';
    protected $ApiBase = 'https://api.weibo.com/2/';

    public function getAuthorizeURL()
    {
        Cookie::set('A_S', $this->timestamp);
        $this->initConfig();
        //Oauth 标准参数
        $params = [
            'client_id'    => $this->config['app_key'],
            'redirect_uri' => $this->config['callback'],
            'state'        => $this->timestamp,
            'scope'        => $this->config['scope'],
            'display'      => $this->display
        ];
        return $this->AuthorizeURL . '?' . http_build_query($params);
    }

    protected function initConfig()
    {
        parent::initConfig();
        if ($this->display == 'mobile') {
            $this->AuthorizeURL = 'https://open.weibo.cn/oauth2/authorize';
        }
    }

    public function call($api, $param='', $method='GET')
    {
        /* 调用公共参数 */
        $params = [
            'access_token' => $this->token['access_token'],
        ];

        $data = OAuthHttp::request($this->url($api, '.json'), $this->param($params, $param), $method);
        return json_decode($data, true);
    }

    public function parseToken($result)
    {
        $data = json_decode($result, true);
        if ($data['access_token'] && $data['expires_in'] && $data['remind_in'] && $data['uid']) {
            $data['openid'] = $data['uid'];
            unset($data['uid']);
            return $data;
        } else {
            $this->error[] = '获取新浪微博 ACCESS_TOKEN 出错：' . $result;
            return false;
        }
    }

    public function openid()
    {
        $data = $this->token;
        if (isset($data['openid'])) {
            return $data['openid'];
        } else {
            $this->error[] = '没有获取到 openid！';
            return false;
        }
    }

    public function userinfo()
    {
        $rsp = $this->call('users/show', 'uid=' . $this->openid());
        if (isset($rsp['error_code'])) {
            $this->error[] = '接口访问失败！' . $rsp['error'];
            return false;
        } else {
            $userinfo = [
                'openid'  => $this->openid(),
                'channel' => 'weibo',
                'nick'    => $rsp['screen_name'],
                'gender'  => $rsp['gender']
            ];
            return $userinfo;
        }
    }
}
