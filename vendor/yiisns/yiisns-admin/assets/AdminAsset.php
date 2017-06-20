<?php
/**
 * AdminAsset
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.10.2016
 * @since 1.0.0
 */

namespace yiisns\admin\assets;

use yiisns\apps\assets\FancyboxAssets;
use yiisns\apps\base\AssetBundle;

use yii\helpers\Json;

/**
 * Class AppAsset
 * @package yiisns\admin\assets
 */
class AdminAsset extends AssetBundle
{

    public $sourcePath = '@yiisns/admin/assets';

    public $css = [
        'css/panel.css',
        'css/sidebar.css',
        'css/app.css',
    ];
    public $js = [
        'js/classes/Blocker.js',
        'js/classes/OldNav.js',
        'js/classes/Menu.js',
        'js/classes/Iframe.js',
        'js/classes/Window.js',
        'js/classes/modal/Dialog.js',
        'js/classes/Fullscreen.js',
        'js/classes/UserLastActivity.js',
        'js/Admin.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        '\yiisns\sx\assets\Custom',
        '\yiisns\sx\assets\ComponentAjaxLoader',
        '\yiisns\admin\assets\JqueryScrollbarAsset',
        '\yiisns\admin\assets\ThemeRealAdminAsset',
        '\yiisns\apps\assets\FancyboxAssets',
    ];

    /**
     * Registers this asset bundle with a view.
     * @param View $view the view to be registered with
     * @return static the registered asset bundle instance
     */
    public function registerAssetFiles($view)
    {
        if (\Yii::$app->request->isPjax)
        {
            return parent::registerAssetFiles($view);
        }

        parent::registerAssetFiles($view);
    }
}