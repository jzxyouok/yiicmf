<?php
/**
 * Asset
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.10.2016
 * @since 1.0.0
 */
namespace yiisns\sx\assets;

use yiisns\apps\helpers\FileHelper;
use yiisns\sx\File;

/**
 * Class Core
 * @package yiisns\sx\assets
 */
class Core extends BaseAsset
{
    /**
     * Registers this asset bundle with a view.
     * @param View $view the view to be registered with
     * @return static the registered asset bundle instance
     */
    public function registerAssetFiles($view)
    {
        parent::registerAssetFiles($view);

        $view->registerJs(<<<JS
        (function(sx, $, _)
        {
            sx.init({});
        })(sx, sx.$, sx._);
JS
);
    }

    public $css = [];

    /**
     * @see http://closure-compiler.appspot.com/home
     * @var array
     */
    public $js = [
        'distr/1.2/skeeks-core.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yiisns\sx\assets\Undescore',
    ];
}