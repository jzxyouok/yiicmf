<?php
/**
 * AdminAsset
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.10.2016
 * @since 1.0.0
 */

namespace yiisns\admin\widgets\controllerActions;

use yii\web\AssetBundle;

/**
 * Class AppAsset
 * @package yiisns\kernel\modules\admin
 */
class Asset extends AssetBundle
{
    public $sourcePath = '@yiisns/admin/widgets/controllerActions';

    public $css = [
    ];
    public $js = [
        'js/widget.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yiisns\sx\assets\Custom',
    ];
}