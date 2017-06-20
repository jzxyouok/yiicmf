<?php

namespace yiisns\kernel\models;

use Yii;

/**
 * This is the model class for table "{{%content_element2cms_user}}".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 * @property integer $content_element_id
 *
 * @property ContentElement $contentElement
 * @property User $user
 */
class ContentElement2cmsUser extends Core
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content_element2cms_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'user_id', 'content_element_id'], 'integer'],
            [['user_id', 'content_element_id'], 'required'],
            [['user_id', 'content_element_id'], 'unique', 'targetAttribute' => ['user_id', 'content_element_id'], 'message' => 'The combination of User ID and Content Element ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'user_id' => 'User ID',
            'content_element_id' => 'Content Element ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentElement()
    {
        return $this->hasOne(ContentElement::className(), ['id' => 'content_element_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}