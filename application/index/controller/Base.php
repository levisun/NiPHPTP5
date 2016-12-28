<?php
/**
 *
 * 网站全局 - 控制器
 *
 * @package   NiPHPCMS
 * @category  index\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Base.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\index\controller;
use think\Controller;
use think\Lang;
use think\Config;
use app\index\logic\Visit as IndexVisit;
use app\index\logic\Common as IndexCommon;
class Base extends Controller
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
		Config::load(CONF_PATH . 'website.php');

		// 访问与搜索日志
		$visit = new IndexVisit;
		$visit->searchengine();
		$visit->visit();

		// 公众业务
		$this->common_model = new IndexCommon;

		// 当前请求表名
		$this->table_name = $this->common_model->table_name;
		// 网站基本数据
		$this->website_data = $this->common_model->getWetsiteData();

		$this->themeConfig();
	}

	/**
	 * 首页 列表页 网站标题等数据
	 * @access protected
	 * @param
	 * @return void
	 */
	protected function first()
	{
		if ($this->request->has('cid', 'param')) {
			$web_info = $this->getCatWebInfo();
		} else {
			$web_info = [
				'title' => $this->website_data['website_name'],
				'keywords' => $this->website_data['website_keywords'],
				'description' => $this->website_data['website_description']
			];
		}
		$replace = [
			'__TITLE__' => $web_info['title'],
			'__KEYWORDS__' => $web_info['keywords'],
			'__DESCRIPTION__' => $web_info['description'],
		];
		$this->view->replace($replace);
	}

	/**
	 * 安栏目获得网站标题、关键词、描述
	 * @access protected
	 * @param
	 * @return arrays
	 */
	protected function getCatWebInfo()
	{
		$web_title = $web_keywords = $web_description = '';
		if ($this->request->has('cid', 'param')) {
			$data = $this->common_model->getCategoryData();

			$this->assign('__SUB_TITLE__', $data[0]['name']);

			foreach ($data as $value) {
				$web_title .= $value['seo_title'] ? $value['seo_title'] : $value['name'] . ' - ';
			}

			$web_keywords = $data[0]['seo_keywords'];
			$web_description = $data[0]['seo_description'];

			$web_keywords = $web_keywords ? $web_keywords : $this->website_data['website_keywords'];
			$web_description = $web_description ? $web_description : $this->website_data['website_description'];
		}

		$web_title .= $this->website_data['website_name'];

		return [
			'title' => $web_title,
			'keywords' => $web_keywords,
			'description' => $web_description
		];
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
		$template['view_path'] = './theme/' . $module . '/';
		$template['view_path'] .= $this->website_data[$module . '_theme'] . '/' . $mobile;

		$this->view->engine($template);

		// 获得域名地址
		$domain = $this->request->root(true);
		$domain = strtr($domain, ['/index.php' => '']);

		$default_theme = $domain . '/theme/' . $module . '/';
		$default_theme .= $this->website_data[$module . '_theme'] . '/' . $mobile;

		$replace = [
			'__DOMAIN__'    => $domain,
			'__LIBRARY__'   => $domain . '/static/library/',
			'__THEME__'     => $this->website_data[$module . '_theme'],
			'__CSS__'       => $default_theme . 'css/',
			'__JS__'        => $default_theme . 'js/',
			'__IMG__'       => $default_theme . 'img/',
			'__MESSAGE__'   => $this->website_data['bottom_message'],
			'__COPYRIGHT__' => $this->website_data['copyright'],
			'__SCRIPT__'    => $this->website_data['script'],
		];
		$this->view->replace($replace);
	}
}