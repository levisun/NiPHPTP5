<?php
/**
 *
 * 网站全局 - 控制器
 *
 * @package   NiPHPCMS
 * @category  member\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Base.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\member\controller;
use think\Controller;
use think\Lang;
use think\Config;
use app\index\logic\Visit as IndexVisit;
use app\member\logic\Common as MemberCommon;
class Base extends Controller
{
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
		Config::load(CONF_PATH . 'website.php');

		// 访问与搜索日志
		$visit = new IndexVisit;
		$visit->visit();

		$common_model = new MemberCommon;

		// 权限
		$result = $common_model->accountAuth();
		if (true !== $result) {
			$this->redirect($result);
		}

		// 网站基本数据
		$this->website_data = $common_model->getWetsiteData();

		$this->themeConfig();
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
		$template['taglib_pre_load'] = 'taglib\Label';

		$module = strtolower($this->request->module());

		// 判断访问端
		$mobile = $this->request->isMobile() ? 'mobile/' : '';
		$info = $this->request->header();
		if (strpos($info['user-agent'], 'MicroMessenger')) {
			$mobile = 'wechat/';
		}

		// 模板路径
		$template['view_path'] = ROOT_PATH . 'public' . DS . 'theme' . DS . $module . DS;
		$template['view_path'] .= $this->website_data[$module . '_theme'] . DS . $mobile;

		$this->view->engine($template);

		// 获得域名地址
		$domain = $this->request->root(true);
		$domain = strtr($domain, ['/index.php' => '']);

		$default_theme = $domain . '/public/theme/' . $module . '/';
		$default_theme .= $this->website_data[$module . '_theme'] . '/' . $mobile;

		$replace = [
			'__DOMAIN__'      => $domain,
			'__STATIC__'      => $domain . '/public/static/',
			'__LIBRARY__'     => $domain . '/public/static/library/',
			'__LAYOUT__'      => $domain . '/public/static/layout/',
			'__THEME__'       => $this->website_data[$module . '_theme'],
			'__CSS__'         => $default_theme . 'css/',
			'__JS__'          => $default_theme . 'js/',
			'__IMG__'         => $default_theme . 'img/',
			'__MESSAGE__'     => $this->website_data['bottom_message'],
			'__COPYRIGHT__'   => $this->website_data['copyright'],
			'__SCRIPT__'      => $this->website_data['script'],

			'__TITLE__'       => $this->website_data['website_name'],
			'__KEYWORDS__'    => $this->website_data['website_keywords'],
			'__DESCRIPTION__' => $this->website_data['website_description'],
		];
		$this->view->replace($replace);
	}
}