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
use yiisns\kernel\relatedProperties\models\RelatedPropertyEnumModel;

use yii\db\BaseActiveRecord;

/**
 * This is the model class for table "{{%user_universal_property_enum}}".
 *
 * @property UserUniversalProperty $property
 */
class UserUniversalPropertyEnum extends RelatedPropertyEnumModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_universal_property_enum}}';
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
        return $this->hasOne(UserUniversalProperty::className(), ['id' => 'property_id']);
    }
}