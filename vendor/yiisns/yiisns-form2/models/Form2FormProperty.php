<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.06.2016
 */
namespace yiisns\form2\models;

use yiisns\kernel\models\Core;
use yiisns\kernel\relatedProperties\models\RelatedPropertyModel;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%form2_form_property}}".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name
 * @property string $code
 * @property string $active
 * @property integer $priority
 * @property string $property_type
 * @property string $list_type
 * @property string $multiple
 * @property integer $multiple_cnt
 * @property string $with_description
 * @property string $searchable
 * @property string $filtrable
 * @property string $is_required
 * @property integer $version
 * @property string $component
 * @property string $component_settings
 * @property string $hint
 * @property string $smart_filtrable
 * @property integer $form_id
 *
 * @property Form2Form $form
 * @property Form2FormPropertyEnum[] $form2FormPropertyEnums
 * @property Form2FormSendProperty[] $form2FormSendProperties
 *
 * @property Form2FormPropertyEnum[] $enums
 * @property Form2FormSendProperty[] $elementProperties
 */
class Form2FormProperty extends RelatedPropertyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%form2_form_property}}';
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'form_id' => \Yii::t('yiisns/form2', 'Contact form'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['form_id'], 'integer'],
            [['code', 'form_id'], 'unique', 'targetAttribute' => ['code', 'form_id'], 'message' => \Yii::t('yiisns/form2', 'User Ids')]
        ]);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(Form2Form::className(), ['id' => 'form_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm2FormPropertyEnums()
    {
        return $this->hasMany(Form2FormPropertyEnum::className(), ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm2FormSendProperties()
    {
        return $this->hasMany(Form2FormSendProperty::className(), ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElementProperties()
    {
        return $this->hasMany(Form2FormSendProperty::className(), ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnums()
    {
        return $this->hasMany(Form2FormPropertyEnum::className(), ['property_id' => 'id']);
    }
}