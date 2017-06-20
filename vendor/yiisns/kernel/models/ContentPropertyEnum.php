<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 29.07.2016
 */
namespace yiisns\kernel\models;

use yiisns\kernel\relatedProperties\models\RelatedPropertyEnumModel;

/**
 * This is the model class for table "{{%content_property_enum}}".
 *
 * @property ContentProperty $property
 */
class ContentPropertyEnum extends RelatedPropertyEnumModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content_property_enum}}';
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
        return $this->hasOne(ContentProperty::className(), ['id' => 'property_id']);
    }
}