<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 09.11.2016
 * @since 1.0.0
 */

namespace yiisns\kernel\models;

use yiisns\kernel\relatedProperties\models\RelatedPropertyModel;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%content_property}}".
 *
 * @property integer $content_id
 *
 * @property Content $content
 * @property ContentPropertyEnum[] $enums
 * @property ContentElementProperty[] $elementProperties
 */
class ContentProperty extends RelatedPropertyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content_property}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElementProperties()
    {
        return $this->hasMany(ContentElementProperty::className(), ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnums()
    {
        return $this->hasMany(ContentPropertyEnum::className(), ['property_id' => 'id']);
    }


    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'content_id' => \Yii::t('yiisns/kernel', 'Linked to content'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = ArrayHelper::merge(parent::rules(), [
            [['content_id'], 'integer'],
            [['code', 'content_id'], 'unique', 'targetAttribute' => ['content_id', 'code'], 'message' => \Yii::t('yiisns/kernel', 'For the content of this code is already in use.')],
        ]);

        return $rules;
    }
}