<?php
/**
 * ComponentBlockerJqueryUi
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 29.01.2016
 * @since 1.0.0
 */
namespace yiisns\sx\assets;

/**
 * Class ComponentNotify
 * @package yiisns\sx\assets
 */
class ComponentBlockerJqueryUi extends ComponentBlocker
{
    public $css = [];
    public $js = [
        'js/components/blocker/BlockerJqueryUi.js'
    ];
    public $depends = [
        'yiisns\sx\assets\JqueryBlockUi',
        'yiisns\sx\assets\ComponentBlocker'
    ];
}