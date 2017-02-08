<?php
/**
 *
 * QQ登陆Api
 *
 * @package   NiPHPCMS
 * @category  net\oauth\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: qq.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/01/03
 */
namespace net\oauth;

use net\oauth\OAuth;
use net\oauth\Http as OAuthHttp;
use think\Cookie;

class qq extends OAuth
{
    protected $AuthorizeURL = 'https://graph.qq.com/oauth2.0/authorize';
    protected $AccessTokenURL = 'https://graph.qq.com/oauth2.0/token';
    protected $ApiBase = 'https://graph.qq.com/';

    public function getAuthorizeURL()
    {
        Cookie::set('A_S', $this->timestamp);
        $this->initConfig();
        //Oauth 标准参数
        $params = [
            'response_type' => $this->config['response_type'],
            'client_id'     => $this->config['app_key'],
            'redirect_uri'  => $this->config['callback'],
            'state'         => $this->timestamp,
            'scope'         => $this->config['scope'],
            'display'       => $this->display
        ];
        return $this->AuthorizeURL . '?' . http_build_query($params);
    }

    public function call($api, $param='', $method='GET')
    {
        /* 调用公共参数 */
        $params = [
            'oauth_consumer_key' => $this->config['app_key'],
            'access_token'       => $this->token['access_token'],
            'openid'             => $this->openid(),
            'format'             => 'json'
        ];

        $data = OAuthHttp::request($this->url($api), $this->param($params, $param), $method);
        return json_decode($data, true);
    }

    public function parseToken($result)
    {
        parse_str($result, $data);
        if (!empty($data['access_token']) && !empty($data['expires_in'])) {
            $this->token    = $data;
            $data['openid'] = $this->openid();
            return $data;
        } else {
            $this->error[] = '获取腾讯QQ ACCESS_TOKEN 出错：' . $result;
            return false;
        }
    }

    public function openid()
    {
        $data = $this->token;
        if (isset($data['openid'])) {
            return $data['openid'];
        } elseif ($data['access_token']) {
            $data = OAuthHttp::get($this->url('oauth2.0/me'), ['access_token' => $data['access_token']]);
            $data = json_decode(trim(substr($data, 9), " );\n"), true);
            if (isset($data['openid'])) {
                return $data['openid'];
            } else {
                $this->error[] = '获取用户 openid 出错：' . $data['error_description'];
                return false;
            }
        } else {
            $this->error[] = '没有获取到 openid！';
            return false;
        }
    }

    public function userinfo()
    {
        $rsp = $this->call('user/get_user_info');
        if (!$rsp || $rsp['ret'] != 0) {
            $this->error[] = '接口访问失败！' . $rsp['msg'];
            return false;
        } else {
            $userinfo = [
                'openid'  => $this->openid(),
                'channel' => 'qq',
                'nick'    => $rsp['nickname']
            ];
            return $userinfo;
        }
    }
}
