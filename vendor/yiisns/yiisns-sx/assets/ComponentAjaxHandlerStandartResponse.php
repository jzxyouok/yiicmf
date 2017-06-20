<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 04.04.2016
 */
namespace yiisns\sx\assets;
/**
 * Class ComponentAjaxHandlerStandartResponse
 * @package yiisns\sx\assets
 */
class ComponentAjaxHandlerStandartResponse extends BaseAsset
{
    public $css = [];

    public $js = [
        'js/components/ajax-handlers/AjaxHandlerStandartRespose.js',
    ];

    public $depends = [
        'yiisns\sx\assets\Core',
        'yiisns\sx\assets\ComponentNotify',
    ];
}