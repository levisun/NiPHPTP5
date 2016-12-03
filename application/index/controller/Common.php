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
	protected $common_model = null;
	protected $table_name   = null;
	protected $website_data = [];

	/**
	 * 初始化
	 * @access protected
	 * @param
	 * @return void
	 */
	protected function _initialize()
	{
		$this->common_model = Loader::model('Common', 'logic');

		$this->table_name = $this->common_model->table_name;
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
		Config::set('template.taglib_pre_load', 'taglib\Label');

		// 判断访问端
		$mobile = $this->request->isMobile() ? 'mobile/' : '';
		$info = $this->request->header();
		if (strpos($info['user-agent'], 'MicroMessenger')) {
			$mobile = 'wechat/';
		}

		// 模板路径
		$view_path = './theme/' . $this->request->module() . '/';
		$view_path .= $this->website_data[$this->request->module() . '_theme'] . '/' . $mobile;
		Config::set('template.view_path', $view_path);

		// 获得域名地址
		$domain = $this->request->root(true);
		$domain = strtr($domain, ['/index.php' => '']);
		Config::set('view_replace_str.__STATIC__', $domain . '/static/');
		Config::set('view_replace_str.__DOMAIN__', $domain);

		$default_theme = $domain . '/theme/' . $this->request->module() . '/';
		$default_theme .= $this->website_data[$this->request->module() . '_theme'] . '/' . $mobile;

		Config::set('view_replace_str.__THEME__', $this->website_data[$this->request->module() . '_theme']);
		Config::set('view_replace_str.__CSS__', $default_theme . 'css/');
		Config::set('view_replace_str.__JS__', $default_theme . 'js/');
		Config::set('view_replace_str.__IMG__', $default_theme . 'img/');

		Config::set('view_replace_str.__MESSAGE__', $this->website_data['bottom_message']);
		Config::set('view_replace_str.__COPYRIGHT__', $this->website_data['copyright']);
		Config::set('view_replace_str.__SCRIPT__', $this->website_data['script']);

		$template = Config::get('template');
		$view_replace_str = Config::get('view_replace_str');
		$this->view = new View($template, $view_replace_str);
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