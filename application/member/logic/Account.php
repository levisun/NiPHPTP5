<?php
/**
 *
 * 帐户登录|注册|找回|信息 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  member\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Account.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\member\logic;

use think\Model;
use think\Request;
use think\Config;
use think\Cookie;
use net\IpLocation;
use app\admin\model\Member as ModelMember;
use app\admin\model\MemberWechat as ModelMemberWechat;

class Account extends Model
{
    protected $request = null;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 登录验证
     * @access public
     * @param
     * @return mixed
     */
    public function checkLogin()
    {
        $map = ['m.username' => $this->request->post('username')];
        $member = new ModelMember;
        $result =
        $member->view('member m', 'id,username,password,email,salt')
        ->view('level_member lm', 'user_id', 'm.id=lm.user_id')
        ->view('level l', ['id'=>'level_id', 'name'=>'Level_name'], 'l.id=lm.level_id')
        ->where($map)
        ->find();

        $user_data = !empty($result) ? $result->toArray() : [];

        $password = $this->request->post('password', '', 'trim,md5');
        if (empty($user_data) || $user_data['password'] !== md5($password . $user_data['salt'])) {
            return 'error username or password';
        }
        unset($user_data['password']);

        $user_data['last_login_ip'] = $this->request->ip(0, true);

        $ip = new IpLocation();
        $area = $ip->getlocation($this->request->ip(0, true));
        $user_data['last_login_ip_attr'] = $area['country'] . $area['area'];

        $map = ['id' => $user_data['id']];
        $field = [
            'last_login_time',
            'last_login_ip',
            'last_login_ip_attr'
        ];

        $member->allowField($field)
        ->save($user_data, $map);

        Cookie::set('USER_DATA', $user_data);
        Cookie::set(Config::get('USER_AUTH_KEY'), $user_data['id']);

        return true;
    }

    /**
     * 注销
     * @access public
     * @param
     * @return boolean
     */
    public function logout()
    {
        Cookie::delete('USER_DATA');
        Cookie::delete(Config::get('USER_AUTH_KEY'));
        return true;
    }

    /**
     * 注册
     * @access public
     * @param
     * @return string
     */
    public function reg()
    {
        # code...
    }



    /**
     * 找回密码
     * @access public
     * @param
     * @return string
     */
    public function forget()
    {
        # code...
    }

    /**
     * 微信自动登录
     * @access public
     * @param
     * @return boolean
     */
    public function autoLogin()
    {
        // 是否微信请求
        if (!is_wechat_request()) {
            return false;
        }

        if (!Cookie::has('WECHAT_OPENID')) {
            return false;
        }

        $member_wechat = new ModelMemberWechat;
        $map = ['mw.openid' => Cookie::get('WECHAT_OPENID')];

        $result =
        $member_wechat->view('member_wechat mw', 'nickname,openid')
        ->view('member m', 'id,username,email', 'm.id=mw.user_id')
        ->view('level_member lm', 'user_id', 'm.id=lm.user_id')
        ->view('level l', ['id'=>'level_id', 'name'=>'Level_name'], 'l.id=lm.level_id')
        ->where($map)
        ->find();

        $wechat_data = $result ? $result->toArray() : [];

        // 用户已经绑定
        if (!empty($wechat_data['openid'])) {
            $wechat_data['last_login_ip'] = $this->request->ip(0, true);

            $ip = new IpLocation();
            $area = $ip->getlocation($this->request->ip(0, true));
            $wechat_data['last_login_ip_attr'] = $area['country'] . $area['area'];

            $map = ['id' => $wechat_data['id']];
            $field = [
                'last_login_time',
                'last_login_ip',
                'last_login_ip_attr'
            ];

            // 更新用户登录信息
            $member = new ModelMember;
            $member->allowField($field)
            ->save($wechat_data, $map);

            Cookie::set('USER_DATA', $wechat_data);
            Cookie::set(Config::get('USER_AUTH_KEY'), $wechat_data['id']);
        }
    }

    /**
     * 新增微信用户
     * 编辑微信用户
     * @access public
     * @param  array  $data
     * @param  string $openid
     * @param  int    $subscribe
     * @return void
     */
    public function AEMember($data)
    {
        $data['tagid_list'] = !empty($data['tagid_list']) ? serialize($data['tagid_list']) : '';

        $map = ['openid' => $data['openid']];

        $member_wechat = new ModelMemberWechat;

        // 查询微信用户是否存在
        $result =
        $member_wechat->field(true)
        ->where($map)
        ->cache($CACHE)
        ->find();

        if (!$result) {
            // 新增微信用户
            $member_wechat->allowField(true)
            ->isUpdate(false)
            ->data($data)
            ->save();
        } else {
            // 编辑微信用户
            $member_wechat->allowField(true)
            ->isUpdate(true)
            ->save($data, $map);
        }
    }
}
