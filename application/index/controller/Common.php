<?php
/**
 *
 * 全局 - 控制器
 *
 * @package   NiPHPCMS
 * @category  index\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Common.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\index\controller;
use think\Controller;
use think\Loader;
use think\Url;
use think\Lang;
use think\Config;
use think\View;
class Common extends Controller
{
	// 公众业务
	protected $common_model = null;
	// 当前请求表名
	protected $table_name   = null;
	// 网站基本数据
	protected $website_data = [];

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

		// 公众业务
		$this->common_model = Loader::model('Common', 'logic');

		// 当前请求表名
		$this->table_name = $this->common_model->table_name;
		// 网站基本数据
		$this->website_data = $this->common_model->getWetsiteData();

		$this->themeConfig();
	}

	/**
	 * 临时
	 * 模板配置
	 * @access protected
	 * @param
	 * @return void
	 */
	protected function themeConfig()
	{
		$template = Config::get('template');
		$template['taglib_pre_load'] = 'taglib\Label';

		$controller = strtolower($this->request->controller());

		// 判断访问端
		$mobile = $this->request->isMobile() ? 'mobile/' : '';
		$info = $this->request->header();
		if (strpos($info['user-agent'], 'MicroMessenger')) {
			$mobile = 'wechat/';
		}

		// 模板路径
		$template['view_path'] = './theme/' . $controller . '/';
		$template['view_path'] .= $this->website_data[$controller . '_theme'] . '/' . $mobile;

		$this->view->engine($template);

		// 获得域名地址
		$domain = $this->request->root(true);
		$domain = strtr($domain, ['/index.php' => '']);


		Config::set('view_replace_str.__STATIC__', $domain . '/static/');
		Config::set('view_replace_str.__DOMAIN__', $domain);

		$default_theme = $domain . '/theme/' . $controller . '/';
		$default_theme .= $this->website_data[$controller . '_theme'] . '/' . $mobile;

		$replace = [
			'__DOMAIN__'    => $domain,
			'__STATIC__'    => $domain . '/static/',
			'__THEME__'     => $this->website_data[$controller . '_theme'],
			'__CSS__'       => $default_theme . 'css/',
			'__JS__'        => $default_theme . 'js/',
			'__IMG__'       => $default_theme . 'img/',
			'__MESSAGE__'   => $this->website_data['bottom_message'],
			'__COPYRIGHT__' => $this->website_data['copyright'],
			'__SCRIPT__'    => $this->website_data['script'],
		];
		$this->view->replace($replace);
	}

	/**
	 * 数据合法验证
	 * @access protected
	 * @param
	 * @return boolean
	 */
	protected function illegal()
	{
	}
}