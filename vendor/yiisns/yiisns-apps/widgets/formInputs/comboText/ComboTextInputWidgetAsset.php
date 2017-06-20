<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.06.2016
 */
namespace yiisns\apps\widgets\formInputs\comboText;

use Yii;
use yii\web\AssetBundle;

/**
 * Class ComboTextInputWidgetAsset
 * @package yiisns\kernel\widgets\formInputs\comboText
 */
class ComboTextInputWidgetAsset extends AssetBundle
{
    public $sourcePath = '@yiisns/apps/widgets/formInputs/comboText/assets';

    public $css = [];

    public $js =
    [
        'combo-widget.js',
    ];

    public $depends = [
        '\yiisns\sx\assets\Core',
    ];
}