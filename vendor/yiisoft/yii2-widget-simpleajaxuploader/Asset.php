<?php
/**
 * Asset
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 21.10.2016
 * @since 1.0.0
 */
namespace yii\widget\simpleajaxuploader;

use yii\web\AssetBundle;

/**
 * Class Core
 * @package yii\widget\simpleajaxloader
 */
class Asset extends AssetBundle
{
    public $sourcePath = '@vendor/yiisoft/yii2-widget-simpleajaxuploader/assets';
    public $css = [];
    public $js = [
        'SimpleAjaxUploader.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}