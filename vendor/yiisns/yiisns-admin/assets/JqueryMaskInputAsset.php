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
class JqueryMaskInputAsset extends AssetBundle
{
    public $sourcePath = '@yiisns/admin/assets/plugins/jquery.maskedinput';

    public $css = [];

    public $js = [
        'dist/jquery.maskedinput.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}