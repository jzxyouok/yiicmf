<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 18.05.2016
 */
namespace yiisns\kernel\relatedProperties\models;

use yiisns\kernel\models\Core;

use yii\db\BaseActiveRecord;
use yii\widgets\ActiveForm;

/**
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $property_id
 * @property string $value
 * @property string $def
 * @property string $code
 * @property integer $priority
 *
 * @property RelatedPropertyModel $property
 */
abstract class RelatedPropertyEnumModel extends Core
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => \Yii::t('yiisns/kernel', 'ID'),
            'created_by' => \Yii::t('yiisns/kernel', 'Created By'),
            'updated_by' => \Yii::t('yiisns/kernel', 'Updated By'),
            'created_at' => \Yii::t('yiisns/kernel', 'Created At'),
            'updated_at' => \Yii::t('yiisns/kernel', 'Updated At'),
            'property_id' => \Yii::t('yiisns/kernel', 'Property ID'),
            'value' => \Yii::t('yiisns/kernel', 'Value'),
            'def' => \Yii::t('yiisns/kernel', 'Def'),
            'code' => \Yii::t('yiisns/kernel', 'Code'),
            'priority' => \Yii::t('yiisns/kernel', 'Priority'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'property_id', 'priority'], 'integer'],
            [['value'], 'required'],
            [['value'], 'string', 'max' => 255],
            [['def'], 'string', 'max' => 1],
            [['code'], 'string', 'max' => 32],
            ['code', 'default', 'value' => function($model, $attribute)
            {
                return md5(rand(1, 10) . time());
            }],
            ['priority', 'default', 'value' => function($model, $attribute)
            {
                return 500;
            }],
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    abstract public function getProperty();
    /*{
        return $this->hasOne(ContentProperty::className(), ['id' => 'property_id']);
    }*/
}