<?php
/**
 * index
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.02.2016
 * @since 1.0.0
 */
?>

<?
echo \mihaildev\elfinder\ElFinder::widget([
    'language'         => 'zh-cn',
    'controller'       => 'apps/elfinder-user-files',
    //'filter'           => 'image',   
    'callbackFunction' => new \yii\web\JsExpression('function(file, id){}'),
    'frameOptions' => [
        'style' => 'width: 100%; height: 800px;'
    ]
]);
?>