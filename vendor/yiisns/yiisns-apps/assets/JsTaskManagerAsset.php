<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.03.2016
 */
namespace yiisns\apps\assets;

use yiisns\apps\base\AssetBundle;

/**
 * Class JsTaskManagerAsset
 * @package yiisns\apps\assets
 */
class JsTaskManagerAsset extends AssetBundle
{
    public $sourcePath = '@yiisns/apps/assets';

    public $css = [
    ];

    public $js =
    [
        'classes/tasks/Task.js',
        'classes/tasks/AjaxTask.js',
        'classes/tasks/ProgressBar.js',
        'classes/tasks/Manager.js',
    ];

    public $depends = [
        'yiisns\sx\assets\Core',
    ];
}