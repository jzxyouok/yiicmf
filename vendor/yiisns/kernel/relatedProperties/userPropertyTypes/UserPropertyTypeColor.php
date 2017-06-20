<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.04.2016
 */
namespace yiisns\kernel\relatedProperties\userPropertyTypes;

use yiisns\kernel\base\AppCore;
//use yiisns\kernel\models\ContentElement;
use yiisns\kernel\relatedProperties\models\RelatedPropertiesModel;
use yiisns\kernel\relatedProperties\PropertyType;
use yiisns\apps\widgets\ColorInput;

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class UserPropertyTypeColor
 * @package yiisns\kernel\relatedProperties\userPropertyTypes
 */
class UserPropertyTypeColor extends PropertyType
{
    public $code = self::CODE_STRING;
    public $name = '';
    public $showDefaultPalette  = AppCore::BOOL_Y;
    public $saveValueAs         = AppCore::BOOL_Y;
    public $useNative           = AppCore::BOOL_N;
    public $showAlpha           = AppCore::BOOL_Y;
    public $showInput           = AppCore::BOOL_Y;
    public $showPalette         = AppCore::BOOL_Y;

    public function init()
    {
        parent::init();

        if(!$this->name)
        {
            $this->name = \Yii::t('yiisns/kernel', 'Choice of color');
        }
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),
        [
            'showDefaultPalette'    => \Yii::t('yiisns/kernel', 'Show extended palette of colors'),
            'saveValueAs'           => \Yii::t('yiisns/kernel', 'Format conservation values'),
            'useNative'             => \Yii::t('yiisns/kernel', 'Use the native color selection'),
            'showAlpha'             => \Yii::t('yiisns/kernel', 'Management transparency'),
            'showInput'             => \Yii::t('yiisns/kernel', 'Show input field values'),
            'showPalette'           => \Yii::t('yiisns/kernel', 'Generally show the palette'),
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
        [
            ['showDefaultPalette', 'string'],
            ['useNative', 'string'],
            ['showAlpha', 'string'],
            ['showInput', 'string'],
            ['showPalette', 'string'],
            [['showDefaultPalette', 'useNative', 'showAlpha', 'showInput', 'showPalette'], 'in', 'range' => array_keys(\Yii::$app->appCore->booleanFormat())],

            ['saveValueAs', 'string'],
            ['saveValueAs', 'in', 'range' => array_keys(ColorInput::$possibleSaveAs)],
        ]);
    }

    /**
     * @return \yii\widgets\ActiveField
     */
    public function renderForActiveForm()
    {
        $field = parent::renderForActiveForm();

        $pluginOptions = [
            'showAlpha' => (bool) ($this->showAlpha === AppCore::BOOL_Y),
            'showInput' => (bool) ($this->showInput === AppCore::BOOL_Y),
            'showPalette' => (bool) ($this->showPalette === AppCore::BOOL_Y),
        ];

        $field->widget(ColorInput::className(), [
            'showDefaultPalette'    => (bool) ($this->showDefaultPalette === AppCore::BOOL_Y),
            'useNative'             => (bool) ($this->useNative === AppCore::BOOL_Y),
            'saveValueAs'           => (string) $this->saveValueAs,
            'pluginOptions'         => $pluginOptions,
        ]);

        return $field;
    }


    /**
     * @return string
     */
    public function renderConfigForm(ActiveForm $activeForm)
    {
        echo $activeForm->fieldRadioListBoolean($this, 'showDefaultPalette');
        echo $activeForm->fieldRadioListBoolean($this, 'useNative');
        echo $activeForm->fieldRadioListBoolean($this, 'showInput')->hint(\Yii::t('yiisns/kernel', 'This INPUT to opened the palette'));
        echo $activeForm->fieldRadioListBoolean($this, 'showAlpha');
        echo $activeForm->fieldRadioListBoolean($this, 'showPalette');
        echo $activeForm->field($this, 'saveValueAs')->radioList(\yiisns\apps\widgets\ColorInput::$possibleSaveAs);
    }

    /**
     * @return $this
     */
    public function addRules()
    {
        $this->property->relatedPropertiesModel->addRule($this->property->code, 'string');

        return $this;
    }
}