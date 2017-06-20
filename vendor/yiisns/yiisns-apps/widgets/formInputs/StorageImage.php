<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 02.03.2016
 */
namespace yiisns\apps\widgets\formInputs;

use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\StorageFile;
use yii\base\Exception;
use yii\bootstrap\Alert;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * @property StorageFile $image
 * Class StorageImage
 * @package yiisns\kernel\widgets\formInputs
 */
class StorageImage extends InputWidget
{
    /**
     * @var array
     */
    public $clientOptions = [];

    public $viewItemTemplate = null;

    /**
     * @param $storageFile
     * @return string
     */
    public function renderItem($storageFile)
    {
        return $this->render($this->viewItemTemplate, [
            'model' => $storageFile
        ]);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        try
        {
            if (!$this->hasModel())
            {
                throw new Exception(\Yii::t('yiisns/kernel', "Current widget works only in form with model"));
            }

            if ($this->model->isNewRecord)
            {
                throw new Exception(\Yii::t('yiisns/kernel', "The image can be downloaded after you save the form data"));
            }

            echo $this->render('storage-image', [
                'model'         => $this->model,
                'widget'        => $this,
            ]);

        } catch (\Exception $e)
        {
            echo Alert::widget([
                'options' => [
                      'class' => 'alert-warning',
                ],
                'body' => $e->getMessage()
            ]);
        }
    }

    /**
     * @return null|StorageFile
     */
    public function getImage()
    {
        $imageId = $this->model->{$this->attribute};
        if (!$imageId)
        {
            return null;
        }

        return StorageFile::findOne($imageId);
    }

    public function getJsonString()
    {
        return Json::encode([
            'backendUrl'        => UrlHelper::construct('admin/admin-storage-files/link-to-model')->enableAdmin()->toString(),
            'modelId'           => $this->model->id,
            'modelClassName'    => $this->model->className(),
            'modelAttribute'    => $this->attribute,
        ]);
    }
}