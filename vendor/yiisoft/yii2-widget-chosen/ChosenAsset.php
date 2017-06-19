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
class ChosenAsset extends AssetBundle
{
    public $sourcePath = '@vendor/yiisoft/yii2-widget-chosen/src/chosen_v1.6.2';

    public $js = [
        'chosen.jquery.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}