<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 22.06.2016
 */
namespace yiisns\apps\controllers;

use yiisns\apps\actions\user\UserAction;

use yiisns\kernel\base\Controller;
use yiisns\kernel\base\AppCore;
use yiisns\apps\filters\AccessControl;
use yiisns\kernel\helpers\RequestResponse;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\User;
use yiisns\kernel\models\forms\PasswordChangeForm;

use Yii;
use yii\helpers\ArrayHelper;
use yii\rest\UpdateAction;
use yii\web\NotFoundHttpException;

/**
 * @property User $user
 * @property bool $isOwner Class UserController
 * @package yiisns\apps\controllers
 */
class UserController extends Controller
{
    const REQUEST_PARAM_USERNAME = 'username';

    /**
     * @var User
     */
    public $_user = false;

    public function init()
    {
        if (\Yii::$app->request->get(static::REQUEST_PARAM_USERNAME) && ! $this->user) {
            throw new NotFoundHttpException("User not found or inactive");
        } else 
            if (\Yii::$app->request->get(static::REQUEST_PARAM_USERNAME) && \Yii::$app->toolbar) {
                $controller = \Yii::$app->createController('admin/admin-user')[0];
                $adminControllerRoute = [
                    'admin/admin-user/update',
                    $controller->requestPkParamName => $this->user->{$controller->modelPkAttribute}
                ];
                
                $urlEditModel = UrlHelper::construct($adminControllerRoute)->enableAdmin()
                    ->setSystemParam(\yiisns\admin\Module::SYSTEM_QUERY_EMPTY_LAYOUT, 'true')
                    ->toString();
                
                \Yii::$app->toolbar->editUrl = $urlEditModel;
            }
    }

    /**
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            // Closed all by default
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return $this->isOwner;
                        }
                    ]
                ]
            ]
        ];
    }

    /**
     *
     * @return bool
     */
    public function getIsOwner()
    {
        return (bool) ($this->user->id == \Yii::$app->user->id);
    }

    /**
     *
     * @return array|bool|null|User|\yii\db\ActiveRecord
     * @throws \yii\db\Exception
     */
    public function getUser()
    {
        if ($this->_user !== false) {
            return $this->_user;
        }
        
        if (! $username = \Yii::$app->request->get(static::REQUEST_PARAM_USERNAME)) {
            $this->_user = null;
            return false;
        }
        
        $userClass = \Yii::$app->user->identityClass;
        $this->_user = $userClass::find()->where([
            "username" => $username,
            'active' => AppCore::BOOL_Y
        ])->one();
        
        return $this->_user;
    }
    
    /**
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render($this->action->id);
    }

    /**
     *
     * @return string
     */
    public function actionView()
    {
        $model = new User();
        return $this->render($this->action->id, ['model' => $model]);
    }

    /**
     *
     * @return string
     */
    public function actionEdit()
    {
        return $this->render($this->action->id);
    }

    /**
     *
     * @param $username
     * @return string
     */
    public function actionChangePassword()
    {
        $modelForm = new PasswordChangeForm([
            'user' => $this->user
        ]);
        
        $rr = new RequestResponse();
        
        if ($rr->isRequestOnValidateAjaxForm()) {
            return $rr->ajaxValidateForm($modelForm);
        }
        
        if ($rr->isRequestAjaxPost()) {
            if ($modelForm->load(\Yii::$app->request->post()) && $modelForm->changePassword()) {
                $rr->success = true;
                $rr->message = \Yii::t('yiisns/kernel', 'Password successfully changed');
            } else {
                $rr->message = \Yii::t('yiisns/kernel', 'Could not change the password');
            }     
            return $rr;
        }   
        return $this->render($this->action->id);
    }

    /**
     * @param $username
     * @return string
     */
    public function actionEditInfo()
    {
        $model = $this->user;
        
        $rr = new RequestResponse();
        
        if ($rr->isRequestOnValidateAjaxForm()) {
            return $rr->ajaxValidateForm($model);
        }
        
        if ($rr->isRequestAjaxPost()) {
            if ($model->load(\Yii::$app->request->post()) && $model->save()) {
                $rr->success = true;
                $rr->message = \Yii::t('yiisns/kernel', 'The data has been successfully saved');
            } else {
                $rr->message = \Yii::t('yiisns/kernel', 'Could not save data');
            }        
            return $rr;
        }      
        return $this->render($this->action->id);
    }
}