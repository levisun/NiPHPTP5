<?php
/**
 *
 * 应用（公共）配置文件
 *
 * @package   NiPHPCMS
 * @category  config\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: config.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
return [
	'sys_version' => '1.0.5',

	// 应用调试模式
	'app_debug'        => APP_DEBUG,
	// 应用Trace
	'app_trace'        => APP_DEBUG,
	// 默认时区
	'default_timezone' => 'PRC',
	// URL设置
	'url_route_on'     => true,
	'url_html_suffix'  => 'shtml',
	// 过滤方法
	'default_filter'   => 'trim,strip_tags,escape_xss',
	'content_filter'   => 'trim,escape_xss,htmlspecialchars',
	// 语言
	'lang_switch_on'   => true,
	'default_lang'     => 'zh-cn',
	'lang_list'        => [
		'zh-cn',
		'zh-tw',
		'en-us'
	],
	// 扩展配置文件
	'extra_config_list' => [
		'database'
	],
	// 禁止访问模块
	'deny_module_list' => ['common'],
	// 模板设置
	'template' => [
		'view_path'   => '',
		'layout_on'   => true,
		'layout_name' => 'layout',
		'layout_item' => '{__CONTENT__}'
	],
	// Trace设置
	'trace' => [
		'type' => 'Console',
	],
	// 日志设置
	'log' => [
		'apart_level' => [
			// 'log',
			'error',
			'notice',
			'sql',
			// 'debug',
			// 'info'
		],
	],
	// 缓存设置
	'cache' => [
		'type'   => 'File',
		'prefix' => '',
		'expire' => 10800,
    ],
	// 验证码设置
	'captcha' => [
		'length'   => 4,
		'fontttf'  => '4.ttf',
		'fontSize' => 30,
	],
	//分页配置
	'paginate' => [
		'type'      => 'bootstrap',
		'var_page'  => 'page',
		'list_rows' => 10,
	],
];
