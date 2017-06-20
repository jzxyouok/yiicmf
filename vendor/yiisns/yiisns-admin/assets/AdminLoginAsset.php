<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 02.07.2016
 */
namespace yiisns\admin\assets;

use yiisns\apps\assets\FancyboxAssets;
use yiisns\apps\base\AssetBundle;
use yii\helpers\Json;

/**
 * Class AdminLoginAsset
 * @package yiisns\admin\assets
 */
class AdminLoginAsset extends AdminAsset
{
    public $css = [
        'css/login.css',
    ];

    public $js = [
        'js/login.js',
    ];
    public $depends = [
        '\yiisns\admin\assets\AdminCanvasBg',
    ];
}