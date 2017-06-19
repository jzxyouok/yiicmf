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
 * Class CKEditorWidgetAsset
 * @package yiisns\widget\ckeditor
 */
class CKEditorWidgetAsset extends CKEditorAsset
{
	public $depends = [
		'yii\ckeditor\CKEditorAsset'
	];

	public $js = [
		'js/skeeks-ckeditor.widget.js'
	];
}