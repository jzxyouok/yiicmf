<?php
/**
 * ComponentBlocker
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 29.01.2016
 * @since 1.0.0
 */
namespace yiisns\sx\assets;
/**
 * Class ComponentBlocker
 * @package yiisns\sx\assets
 */
class ComponentBlocker extends BaseAsset
{
    public $css = [];
    public $js = [
        'js/components/blocker/Blocker.js',
    ];
    public $depends = [
        'yiisns\sx\assets\Core',
    ];
}