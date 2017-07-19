<?php
/**
 *
 * 微信 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  index\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: WechatApi.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\index\logic;

use think\Model;
use think\Request;
use think\Lang;
use think\Config;
use think\Cookie;
use think\Url;
use think\Cache;
use net\Wechat;
use net\IpLocation;
use app\admin\model\Config as IndexConfig;
use app\admin\model\Member as MemberMember;
use app\admin\model\MemberWechat as IndexMemberWechat;

class WechatApi extends Model
{
    protected $request = null;
    protected $wechat;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();

        $data = $this->getConfig();
        $option = [
            'token'          => $data['wechat_token'],
            'encodingaeskey' => $data['wechat_encodingaeskey'],
            'appid'          => $data['wechat_appid'],
            'appsecret'      => $data['wechat_appsecret']
        ];

        $this->wechat = new Wechat($option);
    }

    /**
     * 微信自动登录
     * @access public
     * @param
     * @return boolean
     */
    public function autoWechatLogin()
    {
        // 是否微信请求
        if (!is_wechat_request()) {
            return false;
        }

        if (Cookie::has('WECHAT_OPENID')) {
            $openid = Cookie::get('WECHAT_OPENID');

            $member_wechat = new IndexMemberWechat;
            $map = ['mw.openid' => $openid];
            $result =
            $member_wechat->field(true)
            ->where($map)
            ->find();

            $result =
            $member_wechat->view('member_wechat mw', 'nickname,openid')
            ->view('member m', 'id,username,email', 'm.id=mw.user_id')
            ->view('level_member lm', 'user_id', 'm.id=lm.user_id')
            ->view('level l', ['id'=>'level_id', 'name'=>'Level_name'], 'l.id=lm.level_id')
            ->where($map)
            ->find();

            $wechat_data = $result ? $result->toArray() : [];

            if ($result['openid']) {
                $result['last_login_ip'] = $this->request->ip(0, true);

                $ip = new IpLocation();
                $area = $ip->getlocation($this->request->ip(0, true));
                $result['last_login_ip_attr'] = $area['country'] . $area['area'];

                $map = ['id' => $result['id']];
                $field = [
                    'last_login_time',
                    'last_login_ip',
                    'last_login_ip_attr'
                ];

                $member = new MemberMember;
                $member->allowField($field)
                ->save($result, $map);

                Cookie::set('USER_DATA', $result);
                Cookie::set(Config::get('USER_AUTH_KEY'), $result['id']);

                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * 获取JsApi使用签名
     * @access public
     * @param
     * @return mixed
     */
    public function getJsSign()
    {
        // 是否微信请求
        if (!is_wechat_request()) {
            return false;
        }

        return $this->wechat->getJsSign($this->request->url(true));
    }

    /**
     * 判断微信访问
     * 如访问查询微信用户信息并生成cookie
     * 不做缓存实时查询
     * @access public
     * @param
     * @return boolean
     */
    public function wechatOpenid()
    {
        // 是否微信请求
        if (!is_wechat_request()) {
            return false;
        }

        // cookie存在
        if (Cookie::has('WECHAT_OPENID')) {
            $openid = Cookie::get('WECHAT_OPENID');

            // 查询微信用户信息是否存在
            $member_wechat = new IndexMemberWechat;
            $map = ['openid' => $openid];
            $result =
            $member_wechat->field(true)
            ->where($map)
            ->find();

            $wechat_data = $result ? $result->toArray() : [];

            if (empty($wechat_data)) {
                return true;
            }

            // 已关联直接登录
            halt('TODO:如果用户已登录绑定微信帐户');
        } else {
            // 网页授权获得用户openid后再获得用户信息
            if ($this->request->has('code', 'param')) {
                $code = $this->request->param('code');
                $state = $this->request->param('state');
                if ($state == 'wechatOauth') {
                    // 通过code获得openid
                    $result = $this->wechat->getOauthAccessToken($code);
                    // 通过openid获得用户信息
                    $reuslt = $this->wechat->getUserInfo($result['openid']);
                    // 录入或更新用户信息
                    $this->wechatMemberInfo($result, $result['openid'], $result['subscribe']);
                    Cookie::set('WECHAT_OPENID', $reuslt['openid']);
                }
            } else {
                // 直接跳转不授权获取code
                $url = $this->request->url(true);
                $url = $this->wechat->getOauthRedirect($url, 'wechatOauth', 'snsapi_base');
                $this->redirect($url);
            }
        }

        return false;
    }

    /**
     * 更新微信用户信息
     * @access public
     * @param  array  $data
     * @param  string $openid
     * @param  int    $subscribe
     * @return void
     */
    public function wechatMemberInfo($data, $openid, $subscribe = 1)
    {
        if (empty($data)) {
            $data = [
                'openid' => $openid,
                'subscribe' => $subscribe
            ];
        } else {
            $data['subscribe'] = $subscribe;
            $data['tagid_list'] = serialize($data['tagid_list']);
        }

        $member_wechat = new IndexMemberWechat;
        $CACHE = check_key($map, __METHOD__);

        $map = ['openid' => $openid];
        $result =
        $member_wechat->field(true)
        ->where($map)
        ->cache($CACHE)
        ->find();

        if (!$result) {
            $member_wechat->allowField(true)
            ->isUpdate(false)
            ->data($data)
            ->save();
        } else {
            $member_wechat->allowField(true)
            ->isUpdate(true)
            ->save($data, $map);
        }
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

        $config = new IndexConfig;
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
