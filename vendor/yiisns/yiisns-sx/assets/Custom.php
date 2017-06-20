<?php
/**
 * Custom
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.11.2016
 * @since 1.0.0
 */
namespace yiisns\sx\assets;
/**
 * Class Custom
 * @package yiisns\sx\assets
 */
class Custom extends BaseAsset
{
    public $depends = [
        'yiisns\sx\assets\Core',
        'yiisns\sx\assets\Widget',
        'yiisns\sx\assets\Helpers',
        'yiisns\sx\assets\ComponentWindow',
        'yiisns\sx\assets\ComponentModal',
        'yiisns\sx\assets\ComponentNotifyJgrowl',
        'yiisns\sx\assets\ComponentBlockerJqueryUi',
        'yiisns\sx\assets\ComponentAjaxHandlerStandartResponse',
    ];
}