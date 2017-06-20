<?php

namespace yiisns\kernel\models;

/**
 * This is the model class for table "{{%tree_image}}".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $storage_file_id
 * @property integer $tree_id
 * @property integer $priority
 *
 * @property Tree $tree
 * @property StorageFile $storageFile
 */
class TreeImage extends Core
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tree_image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'storage_file_id', 'tree_id', 'priority'], 'integer'],
            [['storage_file_id', 'tree_id'], 'required'],
            [['storage_file_id', 'tree_id'], 'unique', 'targetAttribute' => ['storage_file_id', 'tree_id'], 'message' => \Yii::t('yiisns/kernel','The combination of Storage File ID and Tree ID has already been taken.')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('yiisns/kernel', 'ID'),
            'created_by' => \Yii::t('yiisns/kernel', 'Created By'),
            'updated_by' => \Yii::t('yiisns/kernel', 'Updated By'),
            'created_at' => \Yii::t('yiisns/kernel', 'Created At'),
            'updated_at' => \Yii::t('yiisns/kernel', 'Updated At'),
            'storage_file_id' => \Yii::t('yiisns/kernel', 'Storage File ID'),
            'tree_id' => \Yii::t('yiisns/kernel', 'Tree ID'),
            'priority' => \Yii::t('yiisns/kernel', 'Priority'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTree()
    {
        return $this->hasOne(Tree::className(), ['id' => 'tree_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStorageFile()
    {
        return $this->hasOne(StorageFile::className(), ['id' => 'storage_file_id']);
    }
}