<?php
if (version_compare(PHP_VERSION, '5.4.0', '<')) {
	die('require PHP >= 5.4.0 !');
}

define('APP_DEBUG', true);
define('BIND_MODULE', 'admin');
define('APP_PATH', __DIR__ . '/application/');
define('CONF_PATH', APP_PATH . 'config/');
define('EXTEND_PATH', APP_PATH . 'extend/');
require __DIR__ . '/thinkphp/start.php';