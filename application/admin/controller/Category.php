<?php
/**
 *
 * 栏目 - 控制器
 *
 * @package   NiPHPCMS
 * @category  admin\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Category.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/24
 */
namespace app\admin\controller;
use think\Loader;
use think\Lang;
use app\admin\controller\Common;
class Category extends Common
{

	/**
	 * 栏目
	 * @access public
	 * @param
	 * @return string
	 */
	public function category()
	{
		$this->assign('submenu', 1);
		$this->assign('submenu_button_added', 1);

		// 父级导航信息
		$this->assign('parent', Loader::model('CategoryCategory', 'logic')->getParent());

		// 新增与编辑所需信息
		if (in_array($this->method, ['added', 'editor'])) {
			// 导航类型信息
			$this->assign('type', Loader::model('CategoryCategory', 'logic')->getCategoryType());
			// 导航模型信息
			$this->assign('model', Loader::model('CategoryCategory', 'logic')->getCategoryModel());
			// 访问权限会员组信息
			$this->assign('level', Loader::model('CategoryCategory', 'logic')->getLevel());
		}

		// 新增
		if ($this->method == 'added') {
			parent::added('CategoryCategory');
			return $this->fetch('category_added');
		}

		// 删除
		if ($this->method == 'remove') {
			parent::remove('CategoryCategory');
			return ;
		}

		// 编辑
		if ($this->method == 'editor') {
			$data = parent::editor('CategoryCategory');
			$this->assign('data', $data);
			return $this->fetch('category_editor');
		}

		$data = parent::select('CategoryCategory');
		$this->assign('list', $data);
		return $this->fetch();
	}

	/**
	 * 模型
	 * @access public
	 * @param
	 * @return string
	 */
	public function model()
	{
		$this->assign('submenu', 1);
		$this->assign('submenu_button_added', 1);

		// 新增与编辑所需信息
		if (in_array($this->method, ['added', 'editor'])) {
			$this->assign('model_list', Loader::model('CategoryModel', 'logic')->getModel());
		}

		// 添加
		if ($this->method == 'added') {
			parent::added('CategoryModel');
			return $this->fetch('model_added');
		}

		// 删除
		if ($this->method == 'remove') {
			parent::remove('CategoryModel');
			return ;
		}

		// 编辑
		if ($this->method == 'editor') {
			$data = parent::editor('CategoryModel');
			$this->assign('data', $data);
			return $this->fetch('model_editor');
		}

		$data = parent::select('CategoryModel');
		$this->assign('list', $data['list']);
		$this->assign('page', $data['page']);
		return $this->fetch();
	}

	/**
	 * 字段
	 * @access public
	 * @param
	 * @return string
	 */
	public function fields()
	{
		// AJAX获得子栏目
		if ($this->request->isAjax()) {
			$type = $this->request->post('type/f');
			$type++;
			return Loader::model('CategoryFields', 'logic')->getCategory($type);
		}

		$this->assign('submenu', 1);
		$this->assign('submenu_button_added', 1);

		// 新增与编辑所需信息
		if (in_array($this->method, ['added', 'editor'])) {
			// 主栏目
			$this->assign('category_list', Loader::model('CategoryFields', 'logic')->getCategory());
			// 字段类型
			$this->assign('type_list', Loader::model('CategoryFields', 'logic')->getType());
		}

		// 添加
		if ($this->method == 'added') {
			parent::added('CategoryFields');
			return $this->fetch('fields_added');
		}

		// 删除
		if ($this->method == 'remove') {
			parent::remove('CategoryFields');
			return ;
		}

		// 编辑
		if ($this->method == 'editor') {
			$data = parent::editor('CategoryFields');
			$this->assign('data', $data);
			return $this->fetch('fields_editor');
		}

		$data = parent::select('CategoryFields');
		$this->assign('list', $data['list']);
		$this->assign('page', $data['page']);
		return $this->fetch();
	}

	/**
	 * 分类
	 * @access public
	 * @param
	 * @return string
	 */
	public function type()
	{
		// AJAX获得子栏目
		if ($this->request->isAjax()) {
			$type = $this->request->post('type/f');
			$type++;
			return Loader::model('CategoryType', 'logic')->getCategory($type);
		}

		$this->assign('submenu', 1);
		$this->assign('submenu_button_added', 1);

		// 新增与编辑所需信息
		if (in_array($this->method, ['added', 'editor'])) {
			// 主栏目
			$this->assign('category_list', Loader::model('CategoryType', 'logic')->getCategory());
		}

		// 添加
		if ($this->method == 'added') {
			parent::added('CategoryType');
			return $this->fetch('type_added');
		}

		// 删除
		if ($this->method == 'remove') {
			parent::remove('CategoryType');
			return ;
		}

		// 编辑
		if ($this->method == 'editor') {
			$data = parent::editor('CategoryType');
			$this->assign('data', $data);
			return $this->fetch('type_editor');
		}

		$data = parent::select('CategoryType');
		$this->assign('list', $data['list']);
		$this->assign('page', $data['page']);
		return $this->fetch();
	}
}