<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
 
namespace yii\widget\chosen;

use yii\web\AssetBundle;

/**
 * Class ChosenAsset
 * @package yii\widget\chosen
 */
class ChosenBootstrapAsset extends AssetBundle
{
    public $sourcePath = '@vendor/yiisoft/yii2-widget-chosen/src/chosen-bootstrap-1.1.0';

    public $css = [
        'chosen.bootstrap.min.css',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\widget\chosen\ChosenAsset',
    ];
}