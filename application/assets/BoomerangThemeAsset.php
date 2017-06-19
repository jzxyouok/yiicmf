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

use yii\template\boomerang\BoomerangAsset;

/**
 * 
 * @package application\assets
 */
class BoomerangThemeAsset extends BoomerangAsset
{
    public $css = [
        'font-awesome/css/font-awesome.min.css',
        'css/global-style.css',
        'assets/layerslider/css/layerslider.css'
    ];

    public $js = [
        'assets/layerslider/js/greensock.js',
        'assets/layerslider/js/layerslider.transitions.js',
        'assets/layerslider/js/layerslider.kreaturamedia.jquery.js'
    ];
}