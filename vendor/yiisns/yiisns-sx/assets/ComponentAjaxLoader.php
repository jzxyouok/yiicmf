<?php
/**
 * ComponentAjaxLoader
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 24.01.2016
 * @since 1.0.0
 */
namespace yiisns\sx\assets;
/**
 * Class Helpers
 * @package yiisns\sx\assets
 */
class ComponentAjaxLoader extends BaseAsset
{
    public $css = [
        'js/components/ajax-loader/css/style.css',
    ];
    public $js = [
        'js/components/ajax-loader/AjaxLoader.js',
    ];
    public $depends = [
        'yiisns\sx\assets\Core',
    ];
}