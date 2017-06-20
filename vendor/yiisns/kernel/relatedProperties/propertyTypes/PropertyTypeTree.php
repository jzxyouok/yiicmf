<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.04.2016
 */
namespace yiisns\kernel\relatedProperties\propertyTypes;

use yiisns\kernel\relatedProperties\PropertyType;

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class PropertyTypeTree
 * 
 * @package yiisns\kernel\relatedProperties\propertyTypes
 */
class PropertyTypeTree extends PropertyType
{
    public $code = self::CODE_TREE;

    public $name = '';

    public $is_multiple = false;
    
    public function init()
    {
        parent::init();
    
        if (! $this->name) {
            $this->name = \Yii::t('yiisns/kernel', 'Tree');
        }
    }

    /**
     * @var a file format settings, the default is in the same directory where the component.
     *
     * @return string
     */
    public function renderConfigForm(ActiveForm $activeForm)
    {
        echo $activeForm->field($this, 'is_multiple')->checkbox(\Yii::$app->formatter->booleanFormat);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'is_multiple' => \Yii::t('yiisns/kernel', 'Multiple choice')
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                'is_multiple',
                'boolean'
            ]
        ]);
    }

    /**
     *
     * @return bool
     */
    public function getIsMultiple()
    {
        return $this->is_multiple;
    }

    /**
     *
     * @return \yii\widgets\ActiveField
     */
    public function renderForActiveForm()
    {
        $field = parent::renderForActiveForm();
        
        $field->widget(\yiisns\apps\widgets\formInputs\selectTree\SelectTree::className(), [
            'mode' => $this->isMultiple ? \yiisns\apps\widgets\formInputs\selectTree\SelectTree::MOD_MULTI : \yiisns\apps\widgets\formInputs\selectTree\SelectTree::MOD_SINGLE,
            'attributeSingle' => $this->property->code,
            'attributeMulti' => $this->property->code
        ]);
        
        return $field;
    }
}