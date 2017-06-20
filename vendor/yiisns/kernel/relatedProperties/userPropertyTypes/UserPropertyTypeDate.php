<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.04.2016
 */
namespace yiisns\kernel\relatedProperties\userPropertyTypes;

//use yiisns\kernel\models\ContentElement;
use yiisns\kernel\relatedProperties\PropertyType;

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class UserPropertyTypeDate
 * @package yiisns\kernel\relatedProperties\userPropertyTypes
 */
class UserPropertyTypeDate extends PropertyType
{
    public $code = self::CODE_NUMBER;
    
    public $name = '';

    public $type = \kartik\datecontrol\DateControl::FORMAT_DATETIME;

    public function init()
    {
        parent::init();

        if(!$this->name)
        {
            $this->name = \Yii::t('yiisns/kernel', 'Datetime');
        }

    }

    public static function types()
    {
        return [
            \kartik\datecontrol\DateControl::FORMAT_DATETIME => \Yii::t('yiisns/kernel', 'Datetime'),
            \kartik\datecontrol\DateControl::FORMAT_DATE => \Yii::t('yiisns/kernel', 'Only date'),
            //\kartik\datecontrol\DateControl::FORMAT_TIME => 'Only time',
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),
        [
            'type'  => \Yii::t('yiisns/kernel', 'Type'),
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
        [
            ['type', 'string'],
            ['type', 'in', 'range' => array_keys(self::types())],
        ]);
    }

    /**
     * @return \yii\widgets\ActiveField
     */
    public function renderForActiveForm()
    {
        $field = parent::renderForActiveForm();

        $field->widget(\kartik\datecontrol\DateControl::classname(), [
            'type' => $this->type,
        ]);

        return $field;
    }

    /**
     * @return string
     */
    public function renderConfigForm(ActiveForm $activeForm)
    {
        echo $activeForm->field($this, 'type')->radioList(\yiisns\kernel\relatedProperties\userPropertyTypes\UserPropertyTypeDate::types());
    }
}