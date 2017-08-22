<?php
if (version_compare(PHP_VERSION, '5.5.0', '<')) {
	die('require PHP >= 5.5.0 !');
}

define('APP_DEBUG', false);
define('APP_PATH', __DIR__ . '/application/');
define('CONF_PATH', APP_PATH . 'config/');
define('EXTEND_PATH', APP_PATH . 'extend/');
define('TEMP_PATH', __DIR__ . '/runtime/temp/home/');
require __DIR__ . '/thinkphp/start.php';
