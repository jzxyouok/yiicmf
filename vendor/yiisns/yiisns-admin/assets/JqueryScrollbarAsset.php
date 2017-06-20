<?php
/**
 * AppAsset
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 16.10.2016
 * @since 1.0.0
 */
namespace yiisns\admin\assets;

use yiisns\apps\base\AssetBundle;

/**
 * Class AppAsset
 * @package backend\assets
 */
class JqueryScrollbarAsset extends AssetBundle
{
    public $sourcePath = '@yiisns/admin/assets';

    public $css = [
        'plugins/jquery.scrollbar/jquery.scrollbar.css',
    ];
    public $js = [
        'plugins/jquery.scrollbar/jquery.scrollbar.min.js',
    ];
    public $depends = [];
}