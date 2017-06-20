<?php
/**
 * AdminProfileController
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.11.2016
 * @since 1.0.0
 */
namespace yiisns\admin\controllers;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\User;
use yiisns\kernel\models\Search;
use yiisns\kernel\models\forms\PasswordChangeForm;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\actions\modelEditor\AdminOneModelEditAction;
use yiisns\admin\controllers\AdminController;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\controllers\helpers\rules\HasModel;
use yiisns\rbac\SnsManager;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * Class AdminProfileController
 * 
 * @package yiisns\admin\controllers
 */
class AdminProfileController extends AdminModelEditorController
{
    /**
     *
     * @return string
     */
    public function getPermissionName()
    {
        return SnsManager::PERMISSION_ADMIN_ACCESS;
    }

    public function init()
    {
        $this->name = \Yii::t('yiisns/kernel', 'My Profile');
        $this->modelShowAttribute = 'username';
        $this->modelClassName = User::className();
        parent::init();
    }

    public function actions()
    {
        $actions = ArrayHelper::merge(parent::actions(), [
            /*
             * 'change-password' =>
             * [
             * "class" => AdminOneModelEditAction::className(),
             * "name" => "Change The Password",
             * "icon" => "glyphicon glyphicon-cog",
             * "callback" => [$this, 'actionChangePassword'],
             * ],
             */
            
            'file-manager' => [
                'class' => AdminOneModelEditAction::className(),
                'name' => 'Personal Files',
                'icon' => 'glyphicon glyphicon-folder-open',
                'callback' => [
                    $this,
                    'actionFileManager'
                ]
            ],
            
            'update' => [
                'class' => AdminOneModelEditAction::className(),
                'callback' => [
                    $this,
                    'update'
                ]
            ]
        ]);
        
        unset($actions['delete']);
        unset($actions['create']);
        unset($actions['index']);
        return $actions;
    }

    public function update(AdminAction $adminAction)
    {
        /**
         *
         * @var $model User
         */
        $model = $this->model;
        $relatedModel = $model->relatedPropertiesModel;
        $passwordChange = new PasswordChangeForm([
            'user' => $model
        ]);
        $passwordChange->scenario = PasswordChangeForm::SCENARION_NOT_REQUIRED;
        
        $rr = new RequestResponse();
        
        if (\Yii::$app->request->isAjax && ! \Yii::$app->request->isPjax) {
            $model->load(\Yii::$app->request->post());
            $relatedModel->load(\Yii::$app->request->post());
            $passwordChange->load(\Yii::$app->request->post());
            
            return \yii\widgets\ActiveForm::validateMultiple([
                $model,
                $relatedModel,
                $passwordChange
            ]);
        }
        
        if ($rr->isRequestPjaxPost()) {
            $model->load(\Yii::$app->request->post());
            $relatedModel->load(\Yii::$app->request->post());
            $passwordChange->load(\Yii::$app->request->post());
            
            if ($model->save() && $relatedModel->save()) {
                \Yii::$app->getSession()->setFlash('success', \Yii::t('yiisns/kernel', 'Saved successfully'));
                
                if ($passwordChange->new_password) {
                    if (! $passwordChange->changePassword()) {
                        \Yii::$app->getSession()->setFlash('error', \Yii::t('yiisns/kernel', 'Saved failed'));
                    }
                }
                
                if (\Yii::$app->request->post('submit-btn') == 'apply') {} else {
                    return $this->redirect($this->indexUrl);
                }
                
                $model->refresh();
            } else {
                $errors = [];
                
                if ($model->getErrors()) {
                    foreach ($model->getErrors() as $error) {
                        $errors[] = implode(', ', $error);
                    }
                }
                
                \Yii::$app->getSession()->setFlash('error', \Yii::t('yiisns/kernel', 'Saved failed') . ". " . implode($errors));
            }
        }
        
        return $this->render('_form', [
            'model' => $model,
            'relatedModel' => $relatedModel,
            'passwordChange' => $passwordChange
        ]);
    }

    public function beforeAction($action)
    {
        $this->model = \Yii::$app->user->identity;
        return parent::beforeAction($action);
    }

    /**
     *
     * @return mixed|\yii\web\Response
     */
    public function actionIndex()
    {
        return $this->redirect(UrlHelper::construct("admin/admin-profile/update")->enableAdmin()
            ->toString());
    }

    /**
     * Updates an existing Game model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * 
     * @return mixed
     */
    public function actionFileManager()
    {
        $model = $this->model;
        
        return $this->render('@yiisns/admin/views/admin-user/file-manager', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing Game model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * 
     * @return mixed
     */
    public function actionChangePassword()
    {
        $model = $this->model;
        
        $modelForm = new PasswordChangeForm([
            'user' => $model
        ]);
        
        if (\Yii::$app->request->isAjax && ! \Yii::$app->request->isPjax) {
            $modelForm->load(\Yii::$app->request->post());
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return \yiisns\admin\widgets\ActiveForm::validate($modelForm);
        }
        
        if ($modelForm->load(\Yii::$app->request->post()) && $modelForm->changePassword()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('yiisns/kernel', 'Saved successfully'));
            return $this->redirect([
                'change-password',
                'id' => $model->id
            ]);
        } else {
            if (\Yii::$app->request->isPost) {
                \Yii::$app->getSession()->setFlash('error', \Yii::t('yiisns/kernel', 'Save failed'));
            }
            
            return $this->render('@yiisns/admin/views/admin-user/change-password.php', [
                'model' => $modelForm
            ]);
            
            /*
             * return $this->render('_form-change-password', [
             * 'model' => $modelForm,
             * ]);
             */
        }
    }
}