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

/**
 * This is the model class for table "{{%content_property}}".
 *
 * @property integer $tree_type_id
 *
 * @property TreeType $treeType
 * @property TreeTypePropertyEnum[] $enums
 * @property TreeProperty[] $elementProperties
 */
class TreeTypeProperty extends RelatedPropertyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tree_type_property}}';
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'tree_type_id' => \Yii::t('yiisns/kernel', "Linked To Section's Type"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['tree_type_id'], 'integer'],
            //[['code'], 'unique'],
            [['code', 'tree_type_id'], 'unique', 'targetAttribute' => ['tree_type_id', 'code'], 'message' => \Yii::t('yiisns/kernel', "For this section's type of the code is already in use.")],
        ]);
    } 
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElementProperties()
    {
        return $this->hasMany(TreeProperty::className(), ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnums()
    {
        return $this->hasMany(TreeTypePropertyEnum::className(), ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreeType()
    {
        return $this->hasOne(TreeType::className(), ['id' => 'tree_type_id']);
    }
}