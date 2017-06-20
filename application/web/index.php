<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.02.2016
 * @since 1.0.0
 */
// define('YII_ENV', 'dev');
// define('YII_DEBUG', true); 
// define('GETENV_POSSIBLE_NAMES', 'env, environment');
// define('CONFIG_CACHE', true);
// define("COMMON_DIR", ROOT_DIR . '/common');
// define("COMMON_CONFIG_DIR", COMMON_DIR . '/config');
// define("COMMON_RUNTIME_DIR", COMMON_DIR . '/runtime');
// define("VENDOR_DIR", ROOT_DIR . '/vendor');

// error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);

ini_set('display_errors', 'On');

define("APP_DIR", __DIR__);
define("APP_CONFIG_DIR", realpath(__DIR__ . '/../config'));
define("APP_RUNTIME_DIR", realpath(__DIR__ . '/../runtime'));
define("ROOT_DIR", dirname(dirname(__DIR__)));

$yiisnsFile = ROOT_DIR . '/vendor/yiisns/yiisns-apps/app-web.php';

if (! file_exists($yiisnsFile)) {
    die("The project is not complete, not installed vendors.");
}

include $yiisnsFile;