<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.04.2016
 */
namespace yiisns\kernel\relatedProperties\propertyTypes;

use yiisns\kernel\relatedProperties\models\RelatedPropertiesModel;
use yiisns\kernel\relatedProperties\PropertyType;

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class PropertyTypeNumber
 * 
 * @package yiisns\kernel\relatedProperties\propertyTypes
 */
class PropertyTypeNumber extends PropertyType
{
    public $code = self::CODE_NUMBER;

    public $name = '';

    public $default_value = null;

    public function init()
    {
        parent::init();
        
        if (! $this->name) {
            $this->name = \Yii::t('yiisns/kernel', 'Number');
        }
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'default_value' => \Yii::t('yiisns/kernel', 'Default Value')
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                'default_value',
                'number'
            ]
        ]);
    }

    /**
     *
     * @return string
     */
    public function renderConfigForm(ActiveForm $activeForm)
    {
        echo $activeForm->field($this, 'default_value');
    }

    /**
     *
     * @return \yii\widgets\ActiveField
     */
    public function renderForActiveForm()
    {
        $field = parent::renderForActiveForm();
        
        $field->textInput();
        
        return $field;
    }

    /**
     *   
     * @return $this
     */
    public function addRules()
    {
        $this->property->relatedPropertiesModel->addRule($this->property->code, 'number');
        
        return $this;
    }

    /**
     *  
     * @return null
     */
    public function getDefaultValue()
    {
        if ($this->default_value !== null) {
            return $this->default_value;
        }
        return;
    }
}