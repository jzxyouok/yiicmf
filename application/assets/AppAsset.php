<?php
/**
 * AppAsset
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.10.2016
 * @since 1.0.0
 */
namespace application\assets;

/**
 * Class AppAsset
 */
class AppAsset extends \yiisns\apps\base\AssetBundle
{
    public $basePath = '@webroot';

    public $baseUrl = '@web';

    public $css = [
        'css/phone.css',
        'css/app.css'
    ];

    public $js = [
        'js/app.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yiisns\sx\assets\Custom',
        'yiisns\apps\assets\FancyboxAssets',
        'application\assets\BoomerangThemeAsset'
    ];
}