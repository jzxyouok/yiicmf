<?php
/**
 * Модель связанного свойства.
 *
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
 * @property integer $element_id
 * @property string $value
 * @property integer $value_enum
 * @property string $value_num
 * @property string $description
 *
 * @property RelatedPropertyModel $property
 * @property RelatedElementModel  $element
 */
abstract class RelatedElementPropertyModel extends Core
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
            'element_id' => \Yii::t('yiisns/kernel', 'Element ID'),
            'value' => \Yii::t('yiisns/kernel', 'Value'),
            'value_enum' => \Yii::t('yiisns/kernel', 'Value Enum'),
            'value_num' => \Yii::t('yiisns/kernel', 'Value Num'),
            'description' => \Yii::t('yiisns/kernel', 'Description'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'property_id', 'element_id'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['value'], 'string'],

            ['value_enum', 'filter', 'filter' => function ($value) {
                $value = (int) $value;
                $filter_options = [
                    'options' => [
                        'default' => 0,
                        'min_range' => -2147483648,
                        'max_range' => 2147483647
                    ]
                ];
                return filter_var($value, FILTER_VALIDATE_INT, $filter_options);
            }],
            ['value_enum', 'integer'],

            ['value_num', 'filter', 'filter' => function ($value) {
                $value = (float) $value;
                $min_range = -1.0E+14;
                $max_range = 1.0E+14;
                if($value <= $min_range || $value >= $max_range )
                {
                    return 0.0;
                }
                return $value;
            }],
            ['value_num', 'number'],

        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    abstract public function getProperty();
    /*{
        return $this->hasOne(ContentProperty::className(), ['id' => 'property_id']);
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    abstract public function getElement();
    /*{
        return $this->hasOne(ContentElement::className(), ['id' => 'element_id']);
    }*/
}