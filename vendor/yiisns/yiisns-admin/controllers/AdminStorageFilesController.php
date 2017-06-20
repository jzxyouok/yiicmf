<?php
/**
 * AdminStorageFilesController
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.11.2016
 * @since 1.0.0
 */
namespace yiisns\admin\controllers;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\kernel\models\StorageFile;
use yiisns\kernel\models\User;
use yiisns\kernel\models\behaviors\HasDescriptionsBehavior;
use yiisns\admin\actions\modelEditor\AdminOneModelEditAction;
use yiisns\admin\controllers\AdminController;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\controllers\helpers\rules\HasModelBehaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * Class AdminStorageFilesController
 * 
 * @package yiisns\admin\controllers
 */
class AdminStorageFilesController extends AdminModelEditorController
{
    public $enableCsrfValidation = false;

    public function init()
    {
        $this->name = \Yii::t('yiisns/kernel', 'File storage');
        $this->modelClassName = StorageFile::className();
        
        parent::init();
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'upload' => [
                        'post'
                    ],
                    'remote-upload' => [
                        'post'
                    ],
                    'link-to-model' => [
                        'post'
                    ],
                    'link-to-models' => [
                        'post'
                    ]
                ]
            ]
        ]);
    }

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'delete-tmp-dir' => [
                'class' => AdminOneModelEditAction::className(),
                'name' => 'delete temporary files',
                'icon' => 'glyphicon glyphicon-folder-open',
                'method' => 'post',
                'request' => 'ajax',
                'callback' => [
                    $this,
                    'actionDeleteTmpDir'
                ]
            ],
            
            'download' => [
                'class' => AdminOneModelEditAction::className(),
                'name' => 'download',
                'icon' => 'glyphicon glyphicon-circle-arrow-down',
                'method' => 'post',
                'callback' => [
                    $this,
                    'actionDownload'
                ]
            ],
            
            'create' => [
                'visible' => false
            ]
        ]);
    }

    public function actionDownload()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $success = false;
        
        /**
         *
         * @var StorageFile $file
         */
        $file = $this->model;
        $file->src;
        
        header('Content-type: ' . $file->mime_type);
        header('Content-Disposition: attachment; filename="' . $file->cluster_file . '"');
        echo file_get_contents($file->cluster->getAbsoluteUrl($file->cluster_file));
        die();
    }

    public function actionDeleteTmpDir()
    {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $success = false;
            
            /**
             *
             * @var StorageFile $file
             */
            $file = $this->model;
            $file->deleteTmpDir();
            
            return [
                'message' => \Yii::t('yiisns/kernel', 'Temporary files deleted'),
                'success' => true
            ];
        }
    }

    public function actionUpload()
    {
        $response = [
            'success' => false
        ];
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $request = Yii::$app->getRequest();
        
        $dir = \yiisns\sx\Dir::runtimeTmp();
        
        $uploader = new \yii\widget\simpleajaxuploader\backend\FileUpload('imgfile');
        $file = $dir->newFile()->setExtension($uploader->getExtension());
        
        $originalName = $uploader->getFileName();
        
        $uploader->newFileName = $file->getBaseName();
        $result = $uploader->handleUpload($dir->getPath() . DIRECTORY_SEPARATOR);
        
        if (! $result) {
            $response['msg'] = $uploader->getErrorMsg();
            return $result;
        } else {
            
            $storageFile = Yii::$app->storage->upload($file, array_merge([
                'name' => '',
                'original_name' => $originalName
            ]));
            
            if ($request->get('modelData') && is_array($request->get('modelData'))) {
                $storageFile->setAttributes($request->get('modelData'));
            }
            
            $storageFile->save(false);
            
            $response['success'] = true;
            $response['file'] = $storageFile;
            return $response;
        }
        
        return $response;
    }

    public function actionRemoteUpload()
    {
        $response = [
            'success' => false
        ];
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $post = Yii::$app->request->post();
        $get = Yii::$app->getRequest();
        
        $request = Yii::$app->getRequest();
        
        if (\Yii::$app->request->post('link')) {
            $storageFile = Yii::$app->storage->upload(\Yii::$app->request->post('link'), array_merge([
                "name" => isset($model->name) ? $model->name : '',
                "original_name" => basename($post['link'])
            ]));
            
            if ($request->post('modelData') && is_array($request->post('modelData'))) {
                $storageFile->setAttributes($request->post('modelData'));
            }
            
            $storageFile->save(false);
            $response["success"] = true;
            $response["file"] = $storageFile;
            return $response;
        }
        
        return $response;
    }

    /**
     * Attach another file to the model
     * 
     * @see yiisns\apps\widgets\formInputs\StorageImage
     * @return RequestResponse
     */
    public function actionLinkToModel()
    {
        $rr = new RequestResponse();
        
        if ($rr->isRequestAjaxPost()) {
            try {
                if (! \Yii::$app->request->post('file_id') || ! \Yii::$app->request->post('modelId') || ! \Yii::$app->request->post('modelClassName') || ! \Yii::$app->request->post('modelAttribute')) {
                    throw new \yii\base\Exception('Not enough input data');
                }
                
                $file = StorageFile::findOne(\Yii::$app->request->post('file_id'));
                if (! $file) {
                    throw new \yii\base\Exception('Maybe the file is already deleted or not loaded');
                }
                
                if (! is_subclass_of(\Yii::$app->request->post('modelClassName'), ActiveRecord::className())) {
                    throw new \yii\base\Exception('Can not bind file to this model');
                }
                
                $className = \Yii::$app->request->post('modelClassName');
                /**
                 *
                 * @var $model ActiveRecord
                 */
                $model = $className::findOne(\Yii::$app->request->post('modelId'));
                if (! $model) {
                    throw new \yii\base\Exception("The model to which you want to bind a file is not found");
                }
                
                if (! $model->hasAttribute(\Yii::$app->request->post('modelAttribute'))) {
                    throw new \yii\base\Exception("The model did not find the file binding attribute: " . \Yii::$app->request->post('modelAttribute'));
                }
                
                if ($oldFileId = $model->{\Yii::$app->request->post('modelAttribute')}) {
                    /**
                     *
                     * @var $oldFile StorageFile
                     * @var $file StorageFile
                     */
                    $oldFile = StorageFile::findOne($oldFileId);
                    $oldFile->delete();
                }
                
                $model->{\Yii::$app->request->post('modelAttribute')} = $file->id;
                if (! $model->save(false)) {
                    throw new \yii\base\Exception("Could not save model");
                }
                
                $file->name = $model->name;
                $file->save(false);
                
                $rr->success = true;
                $rr->message = '';
            } catch (\Exception $e) {
                $rr->success = false;
                $rr->message = $e->getMessage();
            }
        }
        
        return $rr;
    }

    /**
     * Attach another file to the model
     * 
     * @see yiisns\apps\widgets\formInputs\StorageImage
     * @return RequestResponse
     */
    public function actionLinkToModels()
    {
        $rr = new RequestResponse();
        
        if ($rr->isRequestAjaxPost()) {
            try {
                if (! \Yii::$app->request->post('file_id') || ! \Yii::$app->request->post('modelId') || ! \Yii::$app->request->post('modelClassName') || ! \Yii::$app->request->post('modelRelation')) {
                    throw new \yii\base\Exception("Not enough input data");
                }
                
                $file = StorageFile::findOne(\Yii::$app->request->post('file_id'));
                if (! $file) {
                    throw new \yii\base\Exception("Maybe the file is already deleted or not loaded");
                }
                
                if (! is_subclass_of(\Yii::$app->request->post('modelClassName'), ActiveRecord::className())) {
                    throw new \yii\base\Exception("Can not bind file to this model");
                }
                
                $className = \Yii::$app->request->post('modelClassName');
                /**
                 *
                 * @var $model ActiveRecord
                 */
                $model = $className::findOne(\Yii::$app->request->post('modelId'));
                if (! $model) {
                    throw new \yii\base\Exception("The model to which you want to bind a file is not found");
                }
                
                if (! $model->hasProperty(\Yii::$app->request->post('modelRelation'))) {
                    throw new \yii\base\Exception("The model did not find the binding attribute to modelRelation files: " . \Yii::$app->request->post('modelRelation'));
                }
                
                try {
                    $model->link(\Yii::$app->request->post('modelRelation'), $file);
                    
                    if (! $file->name) {
                        $file->name = $model->name;
                        $file->save(false);
                    }
                    
                    $rr->success = true;
                    $rr->message = '';
                } catch (\Exception $e) {
                    $rr->success = false;
                    $rr->message = $e->getMessage();
                }
            } catch (\Exception $e) {
                $rr->success = false;
                $rr->message = $e->getMessage();
            }
        }
        
        return $rr;
    }
}