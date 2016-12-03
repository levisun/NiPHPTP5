<?php
/**
 *
 * 全局 - 控制器
 *
 * @package   NiPHPCMS
 * @category  admin\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Common.php v1.0.1 $
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
class Common extends Controller
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
			$result = Loader::model('CommonUpload', 'logic')->upload();
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
	 * @param  string $model_    操作模型名
	 * @param  string $validate_ 验证器名
	 * @param  string $log_      操作日志记录名|为空不做日志记录
	 * @return void
	 */
	protected function added($model_, $validate_='', $log_='')
	{
		if ($this->request->isPost()) {
			// 数据验证
			$this->illegal($validate_);

			$result = Loader::model($model_, 'logic')->added();
			if (true === $result) {
				$this->actionLog($log_);
				$url = Url::build($this->request->action());
				$this->success(Lang::get('success added'), $url);
			} else {
				$this->error(Lang::get('error added'));
			}
		}
	}

	/**
	 * 删除方法
	 * @access public
	 * @param  string $model_    操作模型名
	 * @param  string $log_      操作日志记录名|为空不做日志记录
	 * @return void
	 */
	protected function remove($model_, $validate_='', $log_='')
	{
		// 数据验证
		$this->illegal($validate_);

		$result = Loader::model($model_, 'logic')->remove();
		if (true === $result) {
			// 获得操作数据ID,后期再做
			$this->actionLog($log_);
			$url = Url::build($this->request->action());
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
	 * @param  string $model_    操作模型名
	 * @param  string $validate_ 验证器名
	 * @param  string $log_      操作日志记录名|为空不做日志记录
	 * @param  string $illegal_  是否自动验证合法信息 默认true
	 * @return array
	 */
	protected function editor($model_, $validate_='', $log_='', $illegal_=true)
	{
		if ($this->request->isPost()) {
			// 数据验证
			$this->illegal($validate_);

			$result = Loader::model($model_, 'logic')->editor();
			if (true === $result) {
				$this->actionLog($log_);
				$url = Url::build($this->request->action());
				$this->success(Lang::get('success editor'));
			} else {
				$this->error(Lang::get('error editor'));
			}
		}

		if (!empty($validate_)) {
			$validate_ = explode('.', $validate_);
			$validate_ = $validate_[0] . '.illegal';
		} else {
			$validate_ = ucfirst($this->request->action()) . '.illegal';
		}


		$this->illegal($validate_, $illegal_);

		return Loader::model($model_, 'logic')->getEditorData();
	}

	/**
	 * 查询方法
	 * @access public
	 * @param  string $model_ 操作模型名
	 * @param  string $log_   操作日志记录名|为空不做日志记录
	 * @return array
	 */
	protected function select($model_, $log_='')
	{
		if ($this->request->isPost()) {
			$result = Loader::model($model_, 'logic')->listSort();
			if (true === $result) {
				$this->actionLog($log_);
				$url = Url::build($this->request->action());
				$this->success(Lang::get('success sort'), $url);
			} else {
				$this->error(Lang::get('error sort'));
			}
		}
		return Loader::model($model_, 'logic')->getListData();
	}

	/**
	 * 数据合法验证
	 * @access protected
	 * @param  string $validate_ 验证器名
	 * @return boolean
	 */
	protected function illegal($validate_='', $illegal_=true)
	{
		// 不进行数据合法验证
		if (false === $illegal_) {
			return false;
		}

		// 验证器为空自动获得验证器
		if (empty($validate_)) {
			$validate_ = ucfirst($this->request->action());
			$validate_ .= '.' . $this->method;
		}

		// 验证数据
		if ($this->request->isPost()) {
			$data = $this->request->post();
		} else {
			$data = ['id' => $this->request->param('id/f')];
		}

		$result = $this->validate($data, $validate_);
		if (true !== $result) {
			$this->error(Lang::get($result));
		}
	}

	/**
	 * 执行日志
	 * @access protected
	 * @param  string $action_   行为名称
	 * @param  intval $recordId_ 数据ID
	 * @param  string $remark_   备注
	 * @return void
	 */
	protected function actionLog($action_, $record_id_='', $remark_='')
	{
		// 行为为空自动获得
		if (empty($action_)) {
			$action_ = $this->method !== 'list' ? $this->method : 'sort';
			$action_ = $this->request->action() . '_' . $action_;
		}
		Loader::model('CommonAccount', 'logic')->action_log($action_, $record_id_, $remark_);
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
		$lang_path .= '\lang\\' . Lang::detect() . '\\';
		Lang::load($lang_path . Lang::detect() . '.php');
		Lang::load($lang_path . strtolower($this->request->controller()) . '.php');

		// 权限判断
		$account = Loader::model('CommonAccount', 'logic');
		$result = $account->accountAuth();
		if (true !== $result) {
			$this->redirect($result);
		}

		$auth_data = $account->getSysData();

		// 重新设置模板
		$this->themeConfig();

		// 注入常用模板变量
		if (!empty($auth_data['auth_menu'])) {
			$this->assign('__ADMIN_DATA__', \think\Session::get('ADMIN_DATA'));
			$this->assign('__MENU__', $auth_data['auth_menu']);
			$this->assign('__SUB_TITLE__', $auth_data['sub_title']);
			$this->assign('__BREADCRUMB__', $auth_data['breadcrumb']);
		}
		$this->assign('__TITLE__', $auth_data['title']);

		$this->assign('module_name', $this->request->module());
		$this->assign('controller_name', $this->request->controller());
		$this->assign('action_name', $this->request->action());

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
		$view_path = '../application/' . $this->request->module() . '/view/';
		$view_path .= Config::get('default_theme') . '/';
		Config::set('template.view_path', $view_path);

		// 获得域名地址
		$domain = $this->request->root(true);
		$domain_arr = explode('/', $domain);
		array_pop($domain_arr);
		$domain = implode('/', $domain_arr);
		// $domain = strtr($domain, ['/index.php' => '', '/admin.php' => '']);
		Config::set('view_replace_str.__STATIC__', $domain . '/static/');
		Config::set('view_replace_str.__DOMAIN__', $domain);

		$default_theme = $domain . '/static/' . $this->request->module() . '/';
		$default_theme .= Config::get('default_theme') . '/';

		Config::set('view_replace_str.__THEME__', Config::get('default_theme'));
		Config::set('view_replace_str.__CSS__', $default_theme . 'css/');
		Config::set('view_replace_str.__JS__', $default_theme . 'js/');
		Config::set('view_replace_str.__IMG__', $default_theme . 'img/');

		$template = Config::get('template');
		$view_replace_str = Config::get('view_replace_str');
		$this->view = new View($template, $view_replace_str);
	}
}