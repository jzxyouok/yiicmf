<?php
/**
 * JqueryBlockUi
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 29.01.2016
 * @since 1.0.0
 */
namespace yiisns\sx\assets;
/**
 * Class JquryTmpl
 * @package yiisns\sx\assets
 */
class JqueryBlockUi extends BaseAsset
{
    public $css = [];
    public $js = [
        'libs/jquery-plugins/block-ui/jquery.blockUI.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}