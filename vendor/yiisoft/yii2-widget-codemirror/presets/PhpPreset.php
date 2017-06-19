<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 05.06.2016
 */
use yii\widget\codemirror\CodemirrorAsset;

use yii\web\JsExpression;
return [
	'assets'=>[
		CodemirrorAsset::MODE_CLIKE,
		CodemirrorAsset::MODE_PHP,
		CodemirrorAsset::ADDON_COMMENT,
		CodemirrorAsset::ADDON_DISPLAY_FULLSCREEN,
		CodemirrorAsset::THEME_ECLIPSE,
	],
    
	'settings' => [
		'lineNumbers' => true,
		'matchBrackets' => true,
		'mode' => 'application/x-httpd-php-open',
		'indentUnit' => 4,
		'indentWithTabs' => true,
		'extraKeys' => [
			'F11' => new JsExpression("function(cm){cm.setOption('fullScreen', !cm.getOption('fullScreen'));}"),
			'Esc' => new JsExpression("function(cm){if(cm.getOption('fullScreen')) cm.setOption('fullScreen', false);}"),
		],
	],
];