<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 09.11.2016
 * @since 1.0.0
 */

namespace yiisns\kernel\models;

use yiisns\apps\base\Widget;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\behaviors\TimestampPublishedBehavior;
use yiisns\kernel\relatedProperties\models\RelatedPropertyModel;

use yii\db\BaseActiveRecord;
use yii\widgets\ActiveForm;

/**
 * This is the model class for table "{{%user_universal_property}}".
 *
 * @property UserUniversalPropertyEnum[]         $enums
 * @property UserProperty[]                      $elementProperties
 */
class UserUniversalProperty extends RelatedPropertyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_universal_property}}';
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['code'], 'unique'],
        ]);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElementProperties()
    {
        return $this->hasMany(UserProperty::className(), ['property_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnums()
    {
        return $this->hasMany(UserUniversalPropertyEnum::className(), ['property_id' => 'id']);
    }   
}