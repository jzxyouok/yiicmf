<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.06.2016
 */
namespace yiisns\apps\widgets\formInputs\componentSettings;

use Yii;
use yii\web\AssetBundle;

/**
 * Class ComponentSettingsWidgetAsset
 * @package yiisns\kernel\widgets\formInputs\componentSettings
 */
class ComponentSettingsWidgetAsset extends AssetBundle
{
    public $sourcePath = '@yiisns/apps/widgets/formInputs/componentSettings/assets';

    public $css = [];

    public $js =
    [
        'component-settings.js',
    ];

    public $depends = [
        '\yiisns\sx\assets\Core',
    ];
}

