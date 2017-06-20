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
 * Class PropertyTypeTextarea
 * 
 * @package yiisns\kernel\relatedProperties\propertyTypes
 */
class PropertyTypeText extends PropertyType
{
    public $code = self::CODE_STRING;

    public $name = '';

    public $default_value = null;

    /*
     * static public $fieldElements =
     * [
     * 'textarea' => 'the text field(textarea)',
     * 'textInput' => 'a small line of text (input)',
     * ];
     */
    public $fieldElement = 'textInput';

    public $rows = 5;

    static public function fieldElements()
    {
        return [
            'textarea' => \Yii::t('yiisns/kernel', 'Text field') . ' (textarea)',
            'textInput' => \Yii::t('yiisns/kernel', 'Text string') . ' (input)',
            'hiddenInput' => \Yii::t('yiisns/kernel', 'The hidden field') . ' (hiddenInput)',
            'default_value' => \Yii::t('yiisns/kernel', 'Default Value')
        ];
    }

    public function init()
    {
        parent::init();
        
        if (! $this->name) {
            $this->name = \Yii::t('yiisns/kernel', 'Text');
        }
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'fieldElement' => \Yii::t('yiisns/kernel', 'Element form'),
            'rows' => \Yii::t('yiisns/kernel', 'The number of lines of the text field'),
            'default_value' => \Yii::t('yiisns/kernel', 'Default Value')
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                'fieldElement',
                'string'
            ],
            [
                'rows',
                'integer',
                'min' => 1,
                'max' => 50
            ],
            [
                'default_value',
                'string'
            ]
        ]);
    }

    /**
     *
     * @return string
     */
    public function renderConfigForm(ActiveForm $activeForm)
    {
        echo $activeForm->fieldSelect($this, 'fieldElement', \yiisns\kernel\relatedProperties\propertyTypes\PropertyTypeText::fieldElements());
        echo $activeForm->fieldInputInt($this, 'rows');
        echo $activeForm->field($this, 'default_value');
    }

    /**
     *
     * @return \yii\widgets\ActiveField
     */
    public function renderForActiveForm()
    {
        $field = parent::renderForActiveForm();
        
        if (in_array($this->fieldElement, array_keys(self::fieldElements()))) {
            $fieldElement = $this->fieldElement;
            $field->$fieldElement([
                'rows' => $this->rows
            ]);
            
            if ($this->fieldElement == 'hiddenInput') {
                $field->label(false);
            }
        } else {
            $field->textInput([]);
        }
        
        return $field;
    }

    /**
     *
     * @return $this
     */
    public function addRules()
    {
        $this->property->relatedPropertiesModel->addRule($this->property->code, 'string');
        
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