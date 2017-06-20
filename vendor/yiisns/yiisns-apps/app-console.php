<?php
/**
 * Запуск console приложения
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.02.2016
 * @since 1.0.0
 */
// fcgi doesn't have STDIN and STDOUT defined by default
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));

//Determination of uncertainty must be constants
require(__DIR__ . '/global.php');
//Standard loader
require(__DIR__ . '/bootstrap.php');

//Result config
$config = \yii\helpers\ArrayHelper::merge(
    (array) require(__DIR__ . '/tmp-config-console-extensions.php'),
    (array) require(__DIR__ . '/app-config.php')
);
$application = new yii\console\Application($config);
$exitCode = $application->run();
exit($exitCode);