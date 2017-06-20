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
 * Class ToolbarAsset
 * @package yiisns\apps\assets
 */
class ToolbarFancyboxAsset extends ToolbarAsset
{
    public $css = [];

    public $js =
    [
        'toolbar/classes/window-fancybox.js',
    ];

    public $depends = [
        'yiisns\apps\assets\FancyboxAssets',
        'yiisns\apps\assets\ToolbarAsset',
    ];
}