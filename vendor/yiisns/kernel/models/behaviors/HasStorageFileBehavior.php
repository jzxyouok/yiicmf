<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.02.2016
 * @since 1.0.0
 */
namespace yiisns\kernel\models\behaviors;

use common\models\User;
use yiisns\kernel\models\StorageFile;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 *
 * @property ActiveRecord|User $owner Class HasStorageFileBehavior
 * @package yiisns\kernel\models\behaviors
 */
class HasStorageFileBehavior extends Behavior
{
    /**
     * a set of models to which are attached id files
     * 
     * @var array
     */
    public $fields = ['image_id'];

    /**
     *
     * @var string
     */
    public $onDeleteCascade = true;

    /**
     *
     * @var array
     */
    protected $_removeFiles = [];

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_DELETE => 'deleteStorgaFile',
            ActiveRecord::EVENT_BEFORE_INSERT => 'saveStorgaFile',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'saveStorgaFile',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSaveStorgaFile',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSaveStorgaFile'
        ];
    }

    /**
     *
     * @param $e
     */
    public function saveStorgaFile($e)
    {
        foreach ($this->fields as $fieldCode) {
            if ($this->owner->isAttributeChanged($fieldCode)) {
                if ($this->owner->getOldAttribute($fieldCode) && $this->owner->getOldAttribute($fieldCode) != $this->owner->{$fieldCode}) {
                    $this->_removeFiles[] = $this->owner->getOldAttribute($fieldCode);
                }
            }
            
            if ($this->owner->{$fieldCode} && is_string($this->owner->{$fieldCode}) && ((string) (int) $this->owner->{$fieldCode} != (string) $this->owner->{$fieldCode})) {
                try {
                    $file = \Yii::$app->storage->upload($this->owner->{$fieldCode});
                    if ($file) {
                        $this->owner->{$fieldCode} = $file->id;
                    } else {
                        $this->owner->{$fieldCode} = null;
                    }
                } catch (\Exception $e) {
                    $this->owner->{$fieldCode} = null;
                }
            }
        }
    }

    /**
     *
     * @throws \Exception
     * @throws \Throwable
     */
    public function afterSaveStorgaFile()
    {
        if ($this->_removeFiles) {
            if ($files = StorageFile::find()->where([
                'id' => $this->_removeFiles
            ])->all()) {
                foreach ($files as $file) {
                    $file->delete();
                }
            }
        }
    }

    /**
     *
     * @throws Exception
     */
    public function deleteStorgaFile()
    {
        if (! $this->onDeleteCascade) {
            return $this;
        }
        
        foreach ($this->fields as $fieldValue) {
            if ($fileId = $this->owner->{$fieldValue}) {
                if ($storageFile = StorageFile::findOne($fileId)) {
                    $storageFile->delete();
                }
            }
        }
    }
}