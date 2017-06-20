<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.03.2016
 */
namespace yiisns\apps\assets;

use yiisns\apps\base\AssetBundle;

/**
 * Class AppAsset
 * @package yiisns\apps\assets
 */
class FancyboxAssets extends AssetBundle
{
    public $sourcePath = '@bower/fancybox/source';

    public $js = [
        'jquery.fancybox.js',
    ];

    public $css = [
        'jquery.fancybox.css',
    ];
}