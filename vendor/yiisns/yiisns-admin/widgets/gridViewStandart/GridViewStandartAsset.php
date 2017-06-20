<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 26.07.2016
 */
namespace yiisns\admin\widgets\gridViewStandart;

use yii\web\AssetBundle;

/**
 * Class GridViewStandartAsset
 * @package yiisns\kernel\modules\admin\widgets\gridViewStandart
 */
class GridViewStandartAsset extends AssetBundle
{
    public $sourcePath = '@yiisns/admin/widgets/gridViewStandart';

    public $css = [
    ];
    public $js = [
        'js/gridViewStandart.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yiisns\sx\assets\Custom',
    ];
}