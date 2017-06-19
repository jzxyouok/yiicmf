<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.06.2016
 */
namespace yii\ckeditor;

use yii\web\AssetBundle;

/**
 * Class CKEditorAsset
 * @package yii\ckeditor
 */
class CKEditorAsset extends AssetBundle
{
	public $sourcePath = '@vendor/yiisoft/yii2-ckeditor/assets';

	public $js = [
		'ckeditor/ckeditor.js',
	];

	public $depends = [
        'yii\web\YiiAsset',
		'yii\web\JqueryAsset'
	];
} 