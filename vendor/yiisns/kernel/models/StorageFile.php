<?php
/**
 * StorageFile
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 26.02.2016
 */

namespace yiisns\kernel\models;

use yiisns\apps\components\storage\ClusterLocal;
use yiisns\kernel\models\behaviors\TimestampPublishedBehavior;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\base\Event;

/**
 * This is the model class for table "{{%storage_file}}".
 *
 * @property integer $id
 * @property string $cluster_id
 * @property string $cluster_file
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $size
 * @property string $mime_type
 * @property string $extension
 * @property string $original_name
 * @property string $name_to_save
 * @property string $name
 * @property string $description_short
 * @property string $description_full
 * @property integer $image_height
 * @property integer $image_width
 *
 * @property string $src
 * @property string $absoluteSrc
 *
 * @property \yiisns\apps\components\storage\Cluster $cluster
 */
class StorageFile extends Core
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%storage_file}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'size', 'image_height', 'image_width'], 'integer'],
            [['description_short', 'description_full'], 'string'],
            [['cluster_file', 'original_name', 'name'], 'string', 'max' => 255],
            [['cluster_id', 'mime_type', 'extension'], 'string', 'max' => 16],
            [['name_to_save'], 'string', 'max' => 32],
            [['cluster_id', 'cluster_file'], 'unique', 'targetAttribute' => ['cluster_id', 'cluster_file'], 'message' => \Yii::t('yiisns/kernel', 'The combination of Cluster ID and Cluster Src has already been taken.')],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => \Yii::t('yiisns/kernel', 'ID'),
            'cluster_id' => \Yii::t('yiisns/kernel', 'Storage'),
            'cluster_file' => \Yii::t('yiisns/kernel', 'Cluster File'),
            'created_by' => \Yii::t('yiisns/kernel', 'Created By'),
            'updated_by' => \Yii::t('yiisns/kernel', 'Updated By'),
            'created_at' => \Yii::t('yiisns/kernel', 'Created At'),
            'updated_at' => \Yii::t('yiisns/kernel', 'Updated At'),
            'size' => \Yii::t('yiisns/kernel', 'File Size'),
            'mime_type' => \Yii::t('yiisns/kernel', 'File Type'),
            'extension' => \Yii::t('yiisns/kernel', 'Extension'),
            'original_name' => \Yii::t('yiisns/kernel', 'Original FileName'),
            'name_to_save' => \Yii::t('yiisns/kernel', 'Name To Save'),
            'name' => \Yii::t('yiisns/kernel', 'Name'),
            'description_short' => \Yii::t('yiisns/kernel', 'Description Short'),
            'description_full' => \Yii::t('yiisns/kernel', 'Description Full'),
            'image_height' => \Yii::t('yiisns/kernel', 'Image Height'),
            'image_width' => \Yii::t('yiisns/kernel', 'Image Width'),
        ]);
    }

    const TYPE_FILE     = 'file';
    const TYPE_IMAGE    = 'image';

    /**
     * @return bool|int
     * @throws \Exception
     */
    public function delete()
    {
        try
        {
            $cluster = $this->cluster;

            $cluster->deleteTmpDir($this->cluster_file);
            $cluster->delete($this->cluster_file);

        } catch (\common\components\storage\Exception $e)
        {
            return false;
        }

        return parent::delete();
    }

    /**
     * @return $this
     */
    public function deleteTmpDir()
    {
        $this->cluster->deleteTmpDir($this->cluster_file);

        return $this;
    }

    /**
     * mime_type
     * @return string
     */
    public function getFileType()
    {
        $dataMimeType = explode('/', $this->mime_type);
        return (string) $dataMimeType[0];
    }

    /**
     * @return bool
     */
    public function isImage()
    {
        if ($this->getFileType() == 'image')
        {
            return true;
        } else
        {
            return false;
        }
    }

    /**
     * 
     * @return $this
     */
    public function updateFileInfo()
    {
        $src = $this->src;

        if ($this->cluster instanceof ClusterLocal)
        {
            if (!\Yii::$app->request->hostInfo)
            {
                return $this;
            }

            $src = \Yii::$app->request->hostInfo . $this->src;
        }

        if ($this->isImage())
        {
            if (extension_loaded('gd'))
            {
                list($width, $height, $type, $attr) = getimagesize($src);
                $this->image_height       = $height;
                $this->image_width        = $width;
            }
        }
        $this->save();
        return $this;
    }

    /**
     * @return string
     */
    public function getAbsoluteSrc()
    {
        return $this->cluster->getAbsoluteUrl($this->cluster_file);
    }

    /**
     * 
     * @return string
     */
    public function getSrc()
    {
        return $this->cluster->getPublicSrc($this->cluster_file);
    }

    /**
     * @return \yiisns\apps\components\storage\Cluster
     */
    public function getCluster()
    {
        return \Yii::$app->storage->getCluster($this->cluster_id);
    }

    /**
     *
     * @return \yiisns\apps\components\storage\Cluster
     */
    public function cluster()
    {
        return $this->cluster;
    }

    /**
     * 
     * @return string
     */
    public function getRootSrc()
    {
        return $this->cluster->getRootSrc($this->cluster_file);
    }
}