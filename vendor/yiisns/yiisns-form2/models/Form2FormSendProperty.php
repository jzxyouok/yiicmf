<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.06.2016
 */
namespace yiisns\form2\models;

use yiisns\kernel\models\Core;
use yiisns\kernel\relatedProperties\models\RelatedElementPropertyModel;
use yiisns\kernel\relatedProperties\models\RelatedPropertyEnumModel;
use yiisns\kernel\relatedProperties\models\RelatedPropertyModel;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%form2_form_send_property}}".
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
 * @property Form2FormProperty $property
 * @property Form2FormSend  $element
 */
class Form2FormSendProperty extends RelatedElementPropertyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%form2_form_send_property}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Form2FormProperty::className(), ['id' => 'property_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElement()
    {
        return $this->hasOne(Form2FormSend::className(), ['id' => 'element_id']);
    }
}