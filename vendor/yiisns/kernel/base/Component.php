<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 26.03.2016
 */
namespace yiisns\kernel\base;

use yiisns\kernel\traits\HasComponentDbSettingsTrait;
use yiisns\kernel\traits\HasComponentDescriptorTrait;

use yii\base\Model;
use yii\widgets\ActiveForm;

/**
 * Class Component
 * @package yiisns\kernel\base
 */
abstract class Component extends Model implements ConfigFormInterface
{
    use HasComponentDescriptorTrait;
    use HasComponentDbSettingsTrait;

    public $img = ['\yiisns\admin\assets\AdminAsset', 'images/icons/settings-big.png'];
    
    public $defaultAttributes = [];

    public function init()
    {
        $this->defaultAttributes = $this->attributes;

        \Yii::beginProfile('Init: ' . $this->className());
        
        $this->initSettings();
        
        \Yii::endProfile('Init: ' . $this->className());
    }

    public function renderConfigForm(ActiveForm $form) { }
}