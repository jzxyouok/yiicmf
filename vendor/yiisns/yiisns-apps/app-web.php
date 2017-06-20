<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn
 * @copyright 2016-2017 YiiSNS
 * @date 19.02.2017
 * @since 1.0.0
 * @var $config
 */
require (__DIR__ . '/global.php');

require (__DIR__ . '/bootstrap.php');

\Yii::beginProfile('Load config application');

$config = \yii\helpers\ArrayHelper::merge(
    (array) require (__DIR__ . '/tmp-config-extensions.php'),
    (array) require (__DIR__ . '/app-config.php')
);

\Yii::endProfile('Load config application');

//print_r($config);die;

$application = new yii\web\Application($config);
$application->run();