<?php
/**
 * JqueryJgrowl
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.01.2016
 * @since 1.0.0
 */
namespace yiisns\sx\assets;
/**
 * Class JquryTmpl
 * @package yiisns\sx\assets
 */
class JqueryJgrowl extends BaseAsset
{
    public $css = [
        'libs/jquery-plugins/jquery-jgrowl/jquery.jgrowl.min.css',
    ];
    public $js = [
        'libs/jquery-plugins/jquery-jgrowl/jquery.jgrowl.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}