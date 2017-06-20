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
class FancyboxThumbsAssets extends FancyboxAssets
{
    public $js = [
        'helpers/jquery.fancybox-thumbs.js',
    ];

    public $css = [
        'helpers/jquery.fancybox-thumbs.css',
    ];

    public $depends = [
        'yiisns\apps\assets\FancyboxAssets',
    ];
}