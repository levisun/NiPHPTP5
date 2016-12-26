<?php
/**
 *
 * 会员管理 - 用户 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: UserMember.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/07
 */
namespace app\admin\logic;
use think\Model;
use think\Request;
use app\admin\model\Member as AdminMember;
use app\admin\model\LevelMember as AdminLevelMember;
use app\admin\model\Region as AdminRegion;
use app\admin\model\Level as AdminLevel;
class UserMember extends Model
{
	protected $request = null;

	protected function initialize()
	{
		parent::initialize();

		$this->request = Request::instance();
	}

	/**
	 * 列表数据
	 * @access public
	 * @param
	 * @return array
	 */
	public function getListData()
	{
		$map = [];
		if ($key = $this->request->param('key')) {
			$map['m.username'] = ['LIKE', '%' . $key . '%'];
		}

		$member = new AdminMember;
		$result =
		$member->view('member m', 'id,username,realname,nickname,email,phone,status')
		->view('level_member lm', 'user_id', 'lm.user_id=m.id')
		->view('level l', ['name'=>'level_name'], 'l.id=lm.level_id')
		->where($map)
		->order('m.id DESC')
		->paginate();

		$list = [];
		foreach ($result as $value) {
			$list[] = $value->toArray();
		}

		$page = $result->render();

		return ['list' => $list, 'page' => $page];
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

		$region = new AdminRegion;
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

	/**
	 * 获得会员组数据
	 * @access public
	 * @param
	 * @return array
	 */
	public function getLevel()
	{
		$map = ['status' => 1];

		$level = new AdminLevel;
		$result =
		$level->field(true)
		->where($map)
		->order('id DESC')
		->select();

		$data = [];
		foreach ($result as $key => $value) {
			$data[] = $value->toArray();
		}

		return $data;
	}

	/**
	 * 添加数据
	 * @access public
	 * @param
	 * @return boolean
	 */
	public function added()
	{
		$data = [
			'username' => $this->request->post('username'),
			'password' => $this->request->post('password', '', 'trim,md5'),
			'email'    => $this->request->post('email'),
			'realname' => $this->request->post('realname'),
			'nickname' => $this->request->post('nickname'),
			'portrait' => $this->request->post('portrait'),
			'gender'   => $this->request->post('gender/f'),
			'birthday' => $this->request->post('birthday/f', '', 'trim,strtotime'),
			'province' => $this->request->post('province/f'),
			'city'     => $this->request->post('city/f'),
			'area'     => $this->request->post('area/f'),
			'address'  => $this->request->post('address'),
			'phone'    => $this->request->post('phone'),
			'status'   => $this->request->post('status/d'),
		];

		$password         = $this->request->post('password', '', 'trim,md5');
		$data['salt']     = substr(encrypt($password), 0, 6);
		$data['password'] = md5($password . $data['salt']);

		$member = new AdminMember;
		$member->data($data)
		->isUpdate(false)
		->save();

		if (!$member->id) {
			return false;
		}

		// 会员组
		$data = [
			'user_id' => $member->id,
			'level_id' => $this->request->post('level/d')
		];

		$level_member = new AdminLevelMember;
		$level_member->data($data)
		->allowField(true)
		->isUpdate(false)
		->save();

		return true;
	}

	/**
	 * 查询编辑数据
	 * @access public
	 * @param
	 * @return array
	 */
	public function getEditorData()
	{
		$map = [
			'm.id' => $this->request->param('id/f')
		];

		$member = new AdminMember;
		$result =
		$member->view('member m', true)
		->view('level_member lm', 'user_id', 'lm.user_id=m.id')
		->view('level l', ['id'=>'level_id', 'name'=>'level_name'], 'l.id=lm.level_id')
		->where($map)
		->find();

		return !empty($result) ? $result->toArray() : [];
	}

	/**
	 * 编辑数据
	 * @access public
	 * @param
	 * @return boolean
	 */
	public function editor()
	{
		$data = [
			'username' => $this->request->post('username'),
			'password' => $this->request->post('password', '', 'trim,md5'),
			'email'    => $this->request->post('email'),
			'realname' => $this->request->post('realname'),
			'nickname' => $this->request->post('nickname'),
			'portrait' => $this->request->post('portrait'),
			'gender'   => $this->request->post('gender/f'),
			'birthday' => $this->request->post('birthday/f', '', 'trim,strtotime'),
			'province' => $this->request->post('province/f'),
			'city'     => $this->request->post('city/f'),
			'area'     => $this->request->post('area/f'),
			'address'  => $this->request->post('address'),
			'phone'    => $this->request->post('phone'),
			'status'   => $this->request->post('status/d'),
		];

		$password         = $this->request->post('password', '', 'trim,md5');
		$data['salt']     = substr(encrypt($password), 0, 6);
		$data['password'] = md5($password . $data['salt']);

		$map = ['id' => $this->request->post('id/f')];

		$member = new AdminMember;
		$result =
		$member->allowField(true)
		->isUpdate(true)
		->save($data, $map);

		if (!$result) {
			return false;
		}

		// 会员组
		$map = ['user_id' => $this->request->post('id/f')];
		$data = ['level_id' => $this->request->post('level/d')];

		$level_member = new AdminLevelMember;
		$result =
		$level_member->allowField(true)
		->isUpdate(true)
		->save($data, $map);

		return true;
	}

	/**
	 * 删除数据
	 * @access public
	 * @param
	 * @return boolean
	 */
	public function remove()
	{
		$map = ['id' => $this->request->param('id/f')];
		$member = new AdminMember;
		$result =
		$member->where($map)
		->delete();

		// 会员组
		$map = ['user_id' => $this->request->param('id/f')];
		$level_member = new AdminLevelMember;
		$result =
		$level_member->where($map)
		->delete();

		return $result ? true : false;
	}
}