<?php
/**
 *
 * 数据库配置文件
 *
 * @package   NiPHPCMS
 * @category  config\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: database.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
return [
	// 数据库类型
	'type'     => 'mysql',
	// 服务器地址
	'hostname' => '127.0.0.1',
	// 数据库名
	'database' => 'tp_new',
	// 用户名
	'username' => 'root',
	// 密码
	'password' => '',
	// 端口
	'hostport' => '',
	// 数据库编码默认采用utf8
	'charset'  => 'utf8',
	// 数据库表前缀
	'prefix'   => 'np_',
	// 数据库调试模式
	'debug'    => APP_DEBUG,
];
