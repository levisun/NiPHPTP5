<?php
/**
 *
 * 内容 - 控制器
 *
 * @package   NiPHPCMS
 * @category  admin\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Content.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/12
 */
namespace app\admin\controller;
use think\Lang;
use think\Url;
use app\admin\controller\Common;
use app\admin\logic\ContentContent as AdminContentContent;
use app\admin\logic\CategoryCategory as AdminCategoryCategory;
use app\admin\logic\ContentRecycle as AdminContentRecycle;
use app\admin\logic\ContentCache as AdminContentCache;
class Content extends Common
{

	/**
	 * 内容
	 * @access public
	 * @param
	 * @return string
	 */
	public function content()
	{
		$this->assign('sort', 0);
		$theme = 'content/content/';

		// 获得模型表名
		$model = new AdminContentContent;
		$this->assign('model_name', $model->table_name);

		if (in_array($this->method, ['page', 'added', 'editor'])) {
			// 分类
			$this->assign('type', $model->type_data);
			// 权限
			$this->assign('level', $model->level_data);

			// 自定义字段
			$data['field_data'] = $model->data_model->getAddedFieldsData();
			$this->assign('data', $data);

			// 是否审核
			$this->assign('is_pass', $model->data_model->isPass());
		}

		// 单页
		if ($this->method == 'page') {
			// 添加
			if ($this->request->isPost() && !$this->request->has('id', 'post')) {
				parent::added('ContentContent', 'Content.page_added');
			}

			// 编辑数据
			$data = parent::editor('ContentContent', 'Content.page_editor', '', false);

			// 编辑数据不存在 获得添加字段数据
			if (!$data) {
				$data['field_data'] = $model->data_model->getAddedFieldsData($model->table_name);
			}

			$this->assign('data', $data);
			$model->table_name .= !empty($data['id'])? '_editor' : '_added';
			return $this->fetch($theme . 'model/' . $model->table_name);
		}

		// 添加
		if ($this->method == 'added') {
			parent::added('ContentContent');
			return $this->fetch($theme . 'model/' . $model->table_name . '_added');
		}

		// 删除
		if ($this->method == 'remove') {
			parent::remove('ContentContent');
		}

		// 编辑
		if ($this->method == 'editor') {
			$data = parent::editor('ContentContent');
			$this->assign('data', $data);
			return $this->fetch($theme . 'model/' . $model->table_name . '_editor');
		}

		// 列表
		if ($this->method == 'manage') {
			$this->assign('submenu', 1);
			if (!in_array($model->table_name, ['message', 'feedback'])) {
				$this->assign('submenu_button_added', 1);
			}

			$data = $model->getListData();
			$this->assign('list', $data['list']);
			$this->assign('page', $data['page']);
			return $this->fetch($theme . 'list');
		}

		// 栏目
		$model = new AdminCategoryCategory;
		$category = $model->getListData();
		foreach ($category as $key => $value) {
			if ($value['model_name'] == 'external') {
				unset($category[$key]);
			}
		}
		$this->assign('category', $category);
		return $this->fetch($theme . 'category');
	}

	/**
	 * 回收站
	 * @access public
	 * @param
	 * @return string
	 */
	public function recycle()
	{
		$this->assign('sort', 0);
		$theme = 'content/content/';

		// 获得模型表名
		$model = new AdminContentRecycle;
		$this->assign('model_name', $model->table_name);

		if (in_array($this->method, ['page', 'added', 'editor'])) {
			// 分类
			$this->assign('type', $model->type_data);
			// 权限
			$this->assign('level', $model->level_data);

			// 自定义字段
			$data['field_data'] = $model->data_model->getAddedFieldsData($model->table_name);
			$this->assign('data', $data);

			// 是否审核
			$this->assign('is_pass', $model->data_model->isPass());
		}

		// 删除
		if ($this->method == 'remove') {
			parent::remove('ContentRecycle');
		}

		// 编辑
		if ($this->method == 'editor') {
			$this->assign('data', $model->getEditorData());
			return $this->fetch($theme . 'recycle/' . $model->table_name . '_editor');
		}

		// 列表
		if ($this->method == 'manage') {
			$this->assign('submenu', 1);
			/*if (!in_array($model->table_name, ['message', 'feedback'])) {
				$this->assign('submenu_button_added', 1);
			}*/

			$data = $model->getListData();
			$this->assign('list', $data['list']);
			$this->assign('page', $data['page']);
			return $this->fetch($theme . 'list');
		}

		// 栏目
		$model = new AdminCategoryCategory;
		$category = $model->getListData();
		foreach ($category as $key => $value) {
			if (in_array($value['model_name'], ['page', 'external'])) {
				unset($category[$key]);
			}
		}
		$this->assign('category', $category);
		return $this->fetch($theme . 'category');
	}

	/**
	 * Banner
	 * @access public
	 * @param
	 * @return string
	 */
	public function banner()
	{
		$this->assign('submenu', 1);
		$this->assign('submenu_button_added', 1);

		if (in_array($this->method, ['added', 'editor'])) {
			if ($this->request->param('pid/f')) {
				$validate = 'Banner.' . $this->method;
			} else {
				$validate = 'Banner.' . $this->method . '_main';
			}
		}

		// 新增
		if ($this->method == 'added') {
			parent::added('ContentBanner', $validate);
			return $this->fetch('banner_added');
		}

		// 删除
		if ($this->method == 'remove') {
			parent::remove('ContentBanner');
			return ;
		}

		// 编辑
		if ($this->method == 'editor') {
			$data = parent::editor('ContentBanner', $validate);
			$this->assign('data', $data);
			return $this->fetch('banner_editor');
		}

		$data = parent::select('ContentBanner');
		$this->assign('list', $data['list']);
		$this->assign('page', $data['page']);
		return $this->fetch();
	}

	/**
	 * 广告管理
	 * @access public
	 * @param
	 * @return mixed
	 */
	public function ads()
	{
		$this->assign('submenu', 1);
		$this->assign('submenu_button_added', 1);

		// 新增
		if ($this->method == 'added') {
			parent::added('ContentAds');
			return $this->fetch('ads_added');
		}

		// 删除
		if ($this->method == 'remove') {
			parent::remove('ContentAds');
			return ;
		}

		// 编辑
		if ($this->method == 'editor') {
			$data = parent::editor('ContentAds');
			$this->assign('data', $data);
			return $this->fetch('ads_editor');
		}

		$data = parent::select('ContentAds');
		$this->assign('list', $data['list']);
		$this->assign('page', $data['page']);
		return $this->fetch();
	}

	/**
	 * 评论管理
	 * @access public
	 * @param
	 * @return mixed
	 */
	public function comment()
	{
		$this->assign('submenu', 1);

		// 删除
		if ($this->method == 'remove') {
			parent::remove('ContentComment');
			return ;
		}

		// 编辑
		if ($this->method == 'editor') {
			$data = parent::editor('ContentComment');
			$this->assign('data', $data);
			return $this->fetch('comment_editor');
		}

		$data = parent::select('ContentComment');
		$this->assign('list', $data['list']);
		$this->assign('page', $data['page']);
		return $this->fetch();
	}

	/**
	 * 更新缓存
	 * @access public
	 * @param
	 * @return mixed
	 */
	public function cache()
	{
		if ($this->method == 'remove') {
			$model = new AdminContentCache;
			$result = $model->remove();

			$url = Url::build($this->request->action());

			if ($result == 'cache') {
				$this->success(lang('success cache'), $url);
			}

			if ($result == 'compile') {
				$this->success(lang('success compile'), $url);
			}
		}
		return $this->fetch();
	}
}