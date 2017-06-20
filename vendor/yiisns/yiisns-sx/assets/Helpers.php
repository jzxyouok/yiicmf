<?php
/**
 * Helpers
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 09.11.2016
 * @since 1.0.0
 */
namespace yiisns\sx\assets;
/**
 * Class Helpers
 * @package yiisns\sx\assets
 */
class Helpers extends BaseAsset
{
    public $css = [];
    public $js = [
        'js/helpers/Helpers.js',
    ];
    public $depends = [
        'yiisns\sx\assets\Core',
    ];
}