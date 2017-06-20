<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 17.05.2016
 */

namespace yiisns\kernel\models;

use yiisns\apps\base\Widget;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\behaviors\TimestampPublishedBehavior;
use yiisns\kernel\relatedProperties\models\RelatedElementPropertyModel;

/**
 * This is the model class for table "{{%user_property}}".
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
 */
class UserProperty extends RelatedElementPropertyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_property}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(UserUniversalProperty::className(), ['id' => 'property_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElement()
    {
        return $this->hasOne(User::className(), ['id' => 'element_id']);
    }
}