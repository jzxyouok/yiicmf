<?php
/**
 * Widget
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 09.11.2016
 * @since 1.0.0
 */
namespace yiisns\sx\assets;
/**
 * Class Widget
 * @package yiisns\sx\assets
 */
class Widget extends BaseAsset
{
    public $css = [];
    public $js = [
        'js/Widget.js',
    ];
    public $depends = [
        'yiisns\sx\assets\Core',
    ];
}