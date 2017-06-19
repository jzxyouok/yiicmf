<?php
/**
 * index-test
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.02.2016
 * @since 1.0.0
 */
// NOTE: Make sure this file is not accessible when deployed to production
if (! in_array(@$_SERVER['REMOTE_ADDR'], [
    '192.168.1.100',
    '::1'
])) {
    die('You are not allowed to access this file.');
}

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

require (__DIR__ . '/../../vendor/autoload.php');
require (__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require (__DIR__ . '/../../common/config/bootstrap.php');
require (__DIR__ . '/../config/bootstrap.php');

$config = require (__DIR__ . '/../../tests/codeception/config/application/acceptance.php');

(new yii\web\Application($config))->run();
