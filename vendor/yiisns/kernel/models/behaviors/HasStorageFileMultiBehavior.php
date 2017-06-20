<?php
/**
 * if a model attached files from the repository, the disposal model свяазнные will remove all files from the repository.
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 31.10.2016
 * @since 1.0.0
 */
namespace yiisns\kernel\models\behaviors;

use yiisns\kernel\models\StorageFile;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Class HasStorageFileMultiBehavior
 * @package yiisns\kernel\models\behaviors
 */
class HasStorageFileMultiBehavior extends Behavior
{
    /**
     * a set of models to which are attached id files
     * @var array
     */
    public $relations = ['images'];

    /**
     * @var string
     */
    public $onDeleteCascade = true;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_DELETE      => 'deleteStorgaFile',
        ];
    }

    /**
     * @throws Exception
     */
    public function deleteStorgaFile()
    {
        if (!$this->onDeleteCascade)
        {
            return $this;
        }

        foreach ($this->relations as $relationNmae)
        {
            if ($files = $this->owner->{$relationNmae})
            {
                foreach ($files as $file)
                {
                    $file->delete();
                }
            }
        }
    }
}