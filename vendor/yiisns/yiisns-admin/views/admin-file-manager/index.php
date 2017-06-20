<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.07.2016
 */
?>
<?
echo \mihaildev\elfinder\ElFinder::widget([
    'controller'       => 'apps/elfinder-full',
    'callbackFunction' => new \yii\web\JsExpression('function(file, id){}'),
    'frameOptions' => [
        'style' => 'width: 100%; height: 800px;'
    ]
]);
?>