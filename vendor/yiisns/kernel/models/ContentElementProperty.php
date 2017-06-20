<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 17.05.2016
 */

namespace yiisns\kernel\models;

use yiisns\kernel\relatedProperties\models\RelatedElementPropertyModel;

/**
 * This is the model class for table "{{%content_element_property}}".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $property_id
 * @property integer $element_id
 * @property string $value
 * @property integer $value_enum
 * @property string $value_num
 * @property string $description
 *
 * @property ContentProperty $property
 * @property ContentElement  $element
 *
 * @property ContentElement[]  $valueContentElements
 */
class ContentElementProperty extends RelatedElementPropertyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content_element_property}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(ContentProperty::className(), ['id' => 'property_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElement()
    {
        return $this->hasOne(ContentElement::className(), ['id' => 'element_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueContentElements()
    {
        return $this->hasMany(ContentElement::className(), ['id' => 'value_enum']);
    }
}