<?php
/**
 *
 * 个人设置 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  member\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Setup.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/02/05
 */
namespace app\member\logic;

use think\Model;
use think\Request;
use think\Url;
use think\Config;
use think\Cookie;
use app\admin\model\Member as MemberMember;
use app\admin\model\Region as MemberRegion;

class Setup extends Model
{
    protected $request = null;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 编辑会员基本信息
     * @access public
     * @param
     * @return boolean
     */
    public function editor()
    {
        $map = ['id' => $this->request->post('id/f')];

        $data = [
            'username' => $this->request->post('username'),
            'email'    => $this->request->post('email'),
            'realname' => $this->request->post('realname'),
            'nickname' => $this->request->post('nickname'),
            'portrait' => $this->request->post('portrait', ''),
            'gender'   => $this->request->post('gender/f'),
            'birthday' => $this->request->post('birthday/f', '', 'trim,strtotime'),
            'province' => $this->request->post('province/f'),
            'city'     => $this->request->post('city/f'),
            'area'     => $this->request->post('area/f'),
            'address'  => $this->request->post('address'),
            'phone'    => $this->request->post('phone'),
        ];
        $data['birthday'] = $data['birthday'] <= 0 ? 0 : $data['birthday'];

        $member = new MemberMember;
        $result =
        $member->allowField(true)
        ->isUpdate(true)
        ->save($data, $map);

        return true;
    }

    /**
     * 修改密码
     * @access public
     * @param
     * @return boolean
     */
    public function updatePassword()
    {
        $password         = $this->request->post('password', '', 'trim,md5');
        $data['salt']     = substr(encrypt($password), 0, 6);
        $data['password'] = md5($password . $data['salt']);

        $map = ['id' => $this->request->post('id/f')];

        $member = new MemberMember;
        $result =
        $member->allowField(true)
        ->isUpdate(true)
        ->save($data, $map);

        return true;
    }

    /**
     * 获得用户信息
     * @access public
     * @param
     * @return array
     */
    public function getUserInfo()
    {
        $user_id = Cookie::get(Config::get('USER_AUTH_KEY'));

        $map = [
            'id' => $user_id
        ];

        $field = [
            'id',
            'username',
            // 'password',
            'email',
            'realname',
            'nickname',
            'portrait',
            'gender',
            'birthday',
            'province',
            'city',
            'area',
            'address',
            'phone',
            'status',
            'salt',
            'last_login_ip',
            'last_login_ip_attr',
            'last_login_time',
            // 'create_time',
            // 'update_time',
        ];

        $member = new MemberMember;
        $result =
        $member->view('member m', $field)
        ->view('level_member lm', 'user_id', 'm.id=lm.user_id')
        ->view('level l', ['id'=>'level_id', 'name'=>'Level_name'], 'l.id=lm.level_id')
        ->where($map)
        ->find();

        return !empty($result) ? $result->toArray() : [];
    }

    /**
     * 获得地址
     * @access public
     * @param  intval $parent_id 父级地区ID
     * @return array
     */
    public function getRegion($parent_id=1)
    {
        $field = [
            'id',
            'pid',
            'name'
        ];
        $map = ['pid' => $parent_id];

        $region = new MemberRegion;
        $result =
        $region->field($field)
        ->where($map)
        ->select();

        $data = [];
        foreach ($result as $key => $value) {
            $data[] = $value->toArray();
        }

        return $data;
    }
}