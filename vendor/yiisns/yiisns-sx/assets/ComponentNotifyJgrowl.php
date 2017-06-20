<?php
/**
 * ComponentNotifyJgrowl
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.01.2016
 * @since 1.0.0
 */
namespace yiisns\sx\assets;
use yii\helpers\Json;

/**
 * Class ComponentNotify
 * @package yiisns\sx\assets
 */
class ComponentNotifyJgrowl extends ComponentNotify
{
    public $css = [];
    public $js = [
        'js/components/notify/NotifyJgrowl.js',
    ];
    public $depends = [
        'yiisns\sx\assets\JqueryJgrowl',
        'yiisns\sx\assets\ComponentNotify'
    ];
}