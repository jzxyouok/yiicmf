<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 09.11.2016
 * @since 1.0.0
 */

namespace yiisns\kernel\models;

/**
 * This is the model class for table "{{%content_element_tree}}".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $element_id
 * @property integer $tree_id
 *
 * @property ContentElement $element
 * @property Tree $tree
 */
class ContentElementTree extends Core
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content_element_tree}}';
    }

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
            'element_id' => \Yii::t('yiisns/kernel', 'Element ID'),
            'tree_id' => \Yii::t('yiisns/kernel', 'Tree ID'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'element_id', 'tree_id'], 'integer'],
            [['element_id', 'tree_id'], 'required'],
            [['element_id', 'tree_id'], 'unique', 'targetAttribute' => ['element_id', 'tree_id'], 'message' => \Yii::t('yiisns/kernel', 'The combination of Element ID and Tree ID has already been taken.')]
        ]);
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
    public function getTree()
    {
        return $this->hasOne(Tree::className(), ['id' => 'tree_id']);
    }
}