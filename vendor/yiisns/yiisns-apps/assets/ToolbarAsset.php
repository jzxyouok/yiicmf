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
 * Class ToolbarAssets
 * @package yiisns\apps\assets
 */
class ToolbarAsset extends AssetBundle
{
    public $sourcePath = '@yiisns/apps/assets';

    public $css = [
        'toolbar/toolbar.css',
    ];

    public $js =
    [
        'toolbar/classes/window.js',
        'toolbar/classes/dialog.js',
        'toolbar/classes/edit-view-block.js',
        'toolbar/toolbar.js',
    ];

    public $depends = [
        'yiisns\sx\assets\Core',
    ];
}