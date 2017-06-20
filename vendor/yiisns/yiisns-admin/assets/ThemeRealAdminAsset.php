<?php
/**
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
class ThemeRealAdminAsset extends AssetBundle
{
    public $sourcePath = '@yiisns/admin/assets';

    public $css = [
        //'themes/real-admin/css/jquery.mmenu.css',
        'themes/real-admin/css/simple-line-icons.css',
        'themes/real-admin/css/font-awesome.min.css',
        'themes/real-admin/css/add-ons.min.css',
        //'themes/real-admin/css/style.min.css',
        'themes/real-admin/css/style-normal.css',
    ];
    public $js = [
        //'themes/real-admin/js/jquery.mmenu.min.js',
    ];
    public $depends = [
    ];
}