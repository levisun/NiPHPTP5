<?php
/**
 *
 * 全局 - 控制器
 *
 * @package   NiPHPCMS
 * @category  admin\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Base.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\controller;
use think\Controller;
use think\Loader;
use think\Url;
use think\Lang;
use think\Config;
use think\View;
use think\Session;
use think\Cache;
use app\admin\logic\CommonUpload as AdminCommonUpload;
use app\admin\logic\CommonAccount as AdminCommonAccount;
class Base extends Controller
{
	// 分支操作方法
	protected $method = '';

	/**
	 * 上传
	 * @access public
	 * @param
	 * @return string
	 */
	public function upload()
	{
		if ($this->request->isPost()) {
			$model = new AdminCommonUpload;
			$result = $model->upload();
			if (is_string($result)) {
				$this->error($result);
			}
			$javascript = upload_to_javasecipt($result);
			echo $javascript;
		}
		return $this->fetch('public/upload');
	}

	/**
	 * 新增方法
	 * @access public
	 * @param  string $model_name    操作模型名
	 * @param  string $validate_name 验证器名
	 * @param  string $log_name      操作日志记录名|为空自动获取记录名
	 * @return void
	 */
	protected function added($model_name, $validate_name='', $log_name='')
	{
		if ($this->request->isPost()) {
			// 数据验证
			$this->illegal($validate_name);

			$result = Loader::model($model_name, 'logic')->added();
			if (true === $result) {
				Cache::clear();
				$this->actionLog($log_name);

				// $url = Url::build($this->request->action());
				$url_param = [];
				if ($this->request->has('cid')) {
					$url_param = ['method' => 'manage', 'cid' => $this->request->param('cid')];
				}
				$url = Url::build($this->request->action(), $url_param);

				$this->success(Lang::get('success added'), $url);
			} else {
				$this->error(Lang::get('error added'));
			}
		}
	}

	/**
	 * 删除方法
	 * @access public
	 * @param  string $model_name    操作模型名
	 * @param  string $validate_name 验证器名
	 * @param  string $log_name      操作日志记录名|为空自动获取记录名
	 * @return void
	 */
	protected function remove($model_name, $validate_name='', $log_name='')
	{
		// 数据验证
		$this->illegal($validate_name);

		$result = Loader::model($model_name, 'logic')->remove();
		if (true === $result) {
			Cache::clear();
			// 获得操作数据ID,后期再做
			$this->actionLog($log_name);

			$url_param = [];
			if ($this->request->has('cid')) {
				$url_param = ['method' => 'manage', 'cid' => $this->request->param('cid')];
			}
			$url = Url::build($this->request->action(), $url_param);

			$this->success(Lang::get('success remove'), $url);
		} else {
			if (false === $result) {
				$this->error(Lang::get('error remove'));
			} else {
				$this->error(Lang::get($result));
			}
		}
	}

	/**
	 * 编辑方法
	 * @access public
	 * @param  string $model_name    操作模型名
	 * @param  string $validate_name 验证器名
	 * @param  string $log_name      操作日志记录名|为空自动获取记录名
	 * @param  string $illegal_      是否自动验证合法信息 默认true
	 * @return array                 编辑数据
	 */
	protected function editor($model_name, $validate_name='', $log_name='', $illegal_=true)
	{
		if ($this->request->isPost()) {
			// 数据验证
			$this->illegal($validate_name);

			$result = Loader::model($model_name, 'logic')->editor();
			if (true === $result) {
				Cache::clear();
				$this->actionLog($log_name);

				$this->success(Lang::get('success editor'));
			} else {
				$this->error(Lang::get('error editor'));
			}
		}

		// 组合验证器名
		if (!empty($validate_name)) {
			$validate_name = explode('.', $validate_name);
			$validate_name = $validate_name[0] . '.illegal';
		} else {
			$validate_name = ucfirst($this->request->action()) . '.illegal';
		}

		$this->illegal($validate_name, $illegal_);

		return Loader::model($model_name, 'logic')->getEditorData();
	}

	/**
	 * 查询方法
	 * @access public
	 * @param  string $model_name 操作模型名
	 * @param  string $log_name   操作日志记录名|为空自动获取记录名
	 * @return array              查询数据
	 */
	protected function select($model_name, $log_name='')
	{
		if ($this->request->isPost()) {
			$result = Loader::model($model_name, 'logic')->listSort();
			if (true === $result) {
				$this->actionLog($log_name);
				$url = Url::build($this->request->action());
				$this->success(Lang::get('success sort'), $url);
			} else {
				$this->error(Lang::get('error sort'));
			}
		}
		return Loader::model($model_name, 'logic')->getListData();
	}

	/**
	 * 数据合法验证
	 * @access protected
	 * @param  string $validate_name 验证器名
	 * @return mexid                 返回true or false or 提示信息
	 */
	protected function illegal($validate_name='', $illegal_=true)
	{
		// 不进行数据合法验证
		if (false === $illegal_) {
			return false;
		}

		// 验证器为空自动获得验证器
		if (empty($validate_name)) {
			$validate_name = ucfirst($this->request->action());
			$validate_name .= '.' . $this->method;
		}

		// 验证数据
		if ($this->request->isPost()) {
			$data = $this->request->post();
		} else {
			$data = ['id' => $this->request->param('id/f')];
		}

		$result = $this->validate($data, $validate_name);
		if (true !== $result) {
			$this->error(Lang::get($result));
		}
	}

	/**
	 * 记录执行日志
	 * @access protected
	 * @param  string $action_name 行为名称
	 * @param  intval $record_id   数据ID
	 * @param  string $remark      备注
	 * @return void
	 */
	protected function actionLog($action_name, $record_id='', $remark='')
	{
		// 行为为空自动获得
		if (empty($action_name)) {
			$action_name = $this->method !== 'list' ? $this->method : 'sort';
			$action_name = $this->request->action() . '_' . $action_name;
		}
		$model = new AdminCommonAccount;
		$model->action_log($action_name, $record_id, $remark);
	}

	/**
	 * 初始化
	 * @access protected
	 * @param
	 * @return void
	 */
	protected function _initialize()
	{
		// 加载语言
		$lang_path = APP_PATH . $this->request->module();
		$lang_path .= DS . 'lang' . DS . Lang::detect() . DS;
		Lang::load($lang_path . Lang::detect() . '.php');
		Lang::load($lang_path . strtolower($this->request->controller()) . '.php');

		// 权限判断
		$account = new AdminCommonAccount;
		$result = $account->accountAuth();
		if (true !== $result) {
			$this->redirect($result);
		}

		$auth_data = $account->getSysData();

		// 重新设置模板
		$this->themeConfig();

		// 注入常用模板变量
		if (!empty($auth_data['auth_menu'])) {
			$this->assign('__ADMIN_DATA__', Session::get('ADMIN_DATA'));
			$this->assign('__MENU__', $auth_data['auth_menu']);
			$this->assign('__SUB_TITLE__', $auth_data['sub_title']);
			$this->assign('__BREADCRUMB__', $auth_data['breadcrumb']);
		}
		$this->assign('__TITLE__', $auth_data['title']);

		$this->assign('submenu', 0);
		$this->assign('submenu_button_added', 0);

		// 分支操作方法
		$this->method = $this->request->param('method', 'list');
	}

	/**
	 * 模板配置
	 * @access protected
	 * @param
	 * @return void
	 */
	protected function themeConfig()
	{
		$template = Config::get('template');
		$template['view_path'] = APP_PATH . $this->request->module() . DS . 'view' . DS;
		$template['view_path'] .= Config::get('default_theme') . DS;
		$this->view->engine($template);

		// 获得域名地址
		$domain = $this->request->root(true);
		$domain_arr = explode('/', $domain);
		array_pop($domain_arr);
		$domain = implode('/', $domain_arr);

		$default_theme = $domain . '/public/static/' . $this->request->module() . '/';
		$default_theme .= Config::get('default_theme') . '/';

		$replace = [
			'__DOMAIN__'  => $domain,
			'__STATIC__'  => $domain . '/public/static/',
			'__LIBRARY__' => $domain . '/public/static/library/',
			'__LAYOUT__'  => $domain . '/public/static/layout/',
			'__THEME__'   => Config::get('default_theme'),
			'__CSS__'     => $default_theme . 'css/',
			'__JS__'      => $default_theme . 'js/',
			'__IMG__'     => $default_theme . 'img/',
		];
		$this->view->replace($replace);
	}
}