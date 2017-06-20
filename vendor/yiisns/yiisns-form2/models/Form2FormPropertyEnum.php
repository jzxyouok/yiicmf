<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.06.2016
 */
namespace yiisns\form2\models;

use yiisns\kernel\models\Core;
use yiisns\kernel\relatedProperties\models\RelatedPropertyEnumModel;
use yiisns\kernel\relatedProperties\models\RelatedPropertyModel;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%content_property_enum}}".
 *
 * @property Form2FormProperty $property
 */
class Form2FormPropertyEnum extends RelatedPropertyEnumModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%form2_form_property_enum}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), []);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Form2FormProperty::className(), ['id' => 'property_id']);
    }
}