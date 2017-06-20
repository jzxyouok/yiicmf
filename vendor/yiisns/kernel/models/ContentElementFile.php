<?php

namespace yiisns\kernel\models;

use Yii;

/**
 * This is the model class for table "{{%content_element_file}}".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $storage_file_id
 * @property integer $content_element_id
 * @property integer $priority
 *
 * @property ContentElement $contentElement
 * @property StorageFile $storageFile
 */
class ContentElementFile extends Core
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content_element_file}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'storage_file_id', 'content_element_id', 'priority'], 'integer'],
            [['storage_file_id', 'content_element_id'], 'required'],
            [['storage_file_id', 'content_element_id'], 'unique', 'targetAttribute' => ['storage_file_id', 'content_element_id'], 'message' => \Yii::t('yiisns/kernel','The combination of Storage File ID and Content Element ID has already been taken.')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yiisns/kernel', 'ID'),
            'created_by' => Yii::t('yiisns/kernel', 'Created By'),
            'updated_by' => Yii::t('yiisns/kernel', 'Updated By'),
            'created_at' => Yii::t('yiisns/kernel', 'Created At'),
            'updated_at' => Yii::t('yiisns/kernel', 'Updated At'),
            'storage_file_id' => Yii::t('yiisns/kernel', 'Storage File ID'),
            'content_element_id' => Yii::t('yiisns/kernel', 'Content Element ID'),
            'priority' => Yii::t('yiisns/kernel', 'Priority'),
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
    public function getStorageFile()
    {
        return $this->hasOne(StorageFile::className(), ['id' => 'storage_file_id']);
    }
}