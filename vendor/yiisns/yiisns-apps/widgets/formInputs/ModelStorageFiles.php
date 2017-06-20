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
 *
 *
 *
 * <?= $form->field($model, 'images')->widget(
    \yiisns\apps\widgets\formInputs\ModelStorageFiles::className(),
    [
        'backendUrl' => \yii\helpers\Url::to(['/apps/storage-files/link-to-models']),
        'viewItemTemplate' => '',
        'controllWidgetOptions' => [
            'backendSimpleUploadUrl' => \yii\helpers\Url::to(['/apps/storage-files/upload']),
            'backendRemoteUploadUrl' => \yii\helpers\Url::to(['/apps/storage-files/remote-upload']),
        ],
    ]
); ?>
 *
 *
 * @property StorageFile[] $files
 * Class StorageImages
 * @package yiisns\kernel\widgets\formInputs
 */
class ModelStorageFiles extends InputWidget
{
    /**
     * @var array
     */
    public $clientOptions = [];

    /**
     * @var null
     */
    public $viewItemTemplate = null;

    /**
     * @var string url to communicate with the model pictures
     * apps/storage-files/link-to-models
     * admin/admin-storage-files/link-to-models
     */
    public $backendUrl = null;

    /**
     * @var array
     */
    public $controllWidgetOptions = [];

    public function init()
    {
        parent::init();

        if ($this->backendUrl === null)
        {
            $this->backendUrl = UrlHelper::construct('admin/admin-storage-files/link-to-models')->enableAdmin()->toString();
        }
    }
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
                throw new Exception(\Yii::t('yiisns/kernel',"Current widget works only in form with model"));
            }

            if ($this->model->isNewRecord)
            {
                throw new Exception(\Yii::t('yiisns/kernel',"Images can be downloaded after you save the form data"));
            }


            if (!$this->model->hasProperty($this->attribute))
            {
                throw new Exception("Relation {$this->attribute} не найдена");
            }

            echo $this->render('model-storage-files', [
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
     * @return null|StorageFile[]
     */
    public function getFiles()
    {
        return $this->model->{$this->attribute};
    }

    public function getJsonString()
    {
        return Json::encode([
            'backendUrl'        => $this->backendUrl,
            'modelId'           => $this->model->id,
            'modelClassName'    => $this->model->className(),
            'modelRelation'     => $this->attribute,
        ]);
    }
}
