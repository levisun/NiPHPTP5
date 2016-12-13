<?php
/**
 *
 * 用户 - 控制器
 *
 * @package   NiPHPCMS
 * @category  admin\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: User.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\logic\UserMember as AdminUserMember;
use app\admin\logic\UserAdmin as AdminUserAdmin;
use app\admin\logic\UserRole as AdminUserRole;
use app\admin\logic\UserNode as AdminUserNode;
class User extends Common
{

	/**
	 * 会员
	 * @access public
	 * @param
	 * @return string
	 */
	public function member()
	{
		$model = new AdminUserMember;

		// AJAX获得地区
		if ($this->request->isAjax()) {
			$id = $this->request->post('id/f');
			$data = $model->getRegion($id);

			$option = '';
			foreach ($data as $key => $value) {
				$option .= '<option class="op" value="' . $value['id'] . '">';
				$option .= $value['name'];
				$option .= '</option>';
			}
			return $option;
		}

		$this->assign('submenu', 1);
		$this->assign('submenu_button_added', 1);

		if (in_array($this->method, ['added', 'editor'])) {
			$this->assign('region', $model->getRegion(1));
			$this->assign('level', $model->getLevel());
		}

		// 新增
		if ($this->method == 'added') {
			parent::added('UserMember');
			return $this->fetch('member_added');
		}

		// 删除
		if ($this->method == 'remove') {
			parent::remove('UserMember');
			return ;
		}

		// 编辑
		if ($this->method == 'editor') {
			$data = parent::editor('UserMember');
			$this->assign('city', $model->getRegion($data['province']));
			$this->assign('area', $model->getRegion($data['city']));
			$this->assign('data', $data);
			return $this->fetch('member_editor');
		}

		$data = parent::select('UserMember');
		$this->assign('list', $data['list']);
		$this->assign('page', $data['page']);
		return $this->fetch();
	}

	/**
	 * 会员组
	 * @access public
	 * @param
	 * @return string
	 */
	public function level()
	{
		$this->assign('submenu', 1);
		$this->assign('submenu_button_added', 1);

		// 新增
		if ($this->method == 'added') {
			parent::added('UserLevel');
			return $this->fetch('level_added');
		}

		// 删除
		if ($this->method == 'remove') {
			parent::remove('UserLevel');
			return ;
		}

		// 编辑
		if ($this->method == 'editor') {
			$data = parent::editor('UserLevel');
			$this->assign('data', $data);
			return $this->fetch('level_editor');
		}

		$data = parent::select('UserLevel');
		$this->assign('list', $data['list']);
		$this->assign('page', $data['page']);
		return $this->fetch();
	}

	/**
	 * 管理员
	 * @access public
	 * @param
	 * @return string
	 */
	public function admin()
	{
		$this->assign('submenu', 1);
		$this->assign('submenu_button_added', 1);

		if (in_array($this->method, ['added', 'editor'])) {
			$model = new AdminUserAdmin;
			$this->assign('role', $model->getRole());
		}

		// 新增
		if ($this->method == 'added') {
			parent::added('UserAdmin');
			return $this->fetch('admin_added');
		}

		// 删除
		if ($this->method == 'remove') {
			parent::remove('UserAdmin');
			return ;
		}

		// 编辑
		if ($this->method == 'editor') {
			$data = parent::editor('UserAdmin');
			$this->assign('data', $data);
			return $this->fetch('admin_editor');
		}

		$data = parent::select('UserAdmin');
		$this->assign('list', $data['list']);
		$this->assign('page', $data['page']);
		return $this->fetch();
	}

	/**
	 * 管理员组
	 * @access public
	 * @param
	 * @return string
	 */
	public function role()
	{
		$this->assign('submenu', 1);
		$this->assign('submenu_button_added', 1);

		if (in_array($this->method, ['added', 'editor'])) {
			$model = new AdminUserRole;
			$this->assign('node', $model->getNode());
		}

		// 新增
		if ($this->method == 'added') {
			parent::added('UserRole');
			return $this->fetch('role_added');
		}

		// 删除
		if ($this->method == 'remove') {
			parent::remove('UserRole');
			return ;
		}

		// 编辑
		if ($this->method == 'editor') {
			$data = parent::editor('UserRole');
			$this->assign('data', $data);
			return $this->fetch('role_editor');
		}

		$data = parent::select('UserRole');
		$this->assign('list', $data['list']);
		$this->assign('page', $data['page']);
		return $this->fetch();
	}

	/**
	 * 节点
	 * @access public
	 * @param
	 * @return string
	 */
	public function node()
	{
		$this->assign('submenu', 1);
		$this->assign('submenu_button_added', 1);

		if (in_array($this->method, ['added', 'editor'])) {
			$model = new AdminUserNode;
			$this->assign('node', $model->getListData());
		}

		// 新增
		if ($this->method == 'added') {
			parent::added('UserNode');
			return $this->fetch('node_added');
		}

		// 删除
		if ($this->method == 'remove') {
			parent::remove('UserNode');
			return ;
		}

		// 编辑
		if ($this->method == 'editor') {
			$data = parent::editor('UserNode');
			$this->assign('data', $data);
			return $this->fetch('node_editor');
		}

		$data = parent::select('UserNode');
		$this->assign('list', $data);
		return $this->fetch();
	}
}