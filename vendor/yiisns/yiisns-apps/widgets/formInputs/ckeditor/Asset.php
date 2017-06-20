<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 16.10.2016
 * @since 1.0.0
 */
namespace yiisns\apps\widgets\formInputs\ckeditor;

use yii\web\AssetBundle;

/**
 * Class AppAsset
 * @package yiisns\apps\assets
 */
class Asset extends AssetBundle
{
    public $sourcePath = '@yiisns/apps/widgets/formInputs/ckeditor/assets';
    public $css = [];
    public $js = [
        'imageselect.png'
    ];
    public $depends = [];
}