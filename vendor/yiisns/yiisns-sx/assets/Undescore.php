<?php
/**
 * UndescoreAsset
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.10.2016
 * @since 1.0.0
 */
namespace yiisns\sx\assets;

use yiisns\apps\base\AssetBundle;
/**
 * Class UndescoreAsset
 * @package yiisns\sx\assets
 */
class Undescore extends AssetBundle
{
    public $sourcePath = '@bower/underscore';
    public $js = [
        'underscore-min.js',
    ];
}