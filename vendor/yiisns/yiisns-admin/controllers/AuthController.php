<?php
/**
 * AuthController
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 05.05.2016
 * @since 1.0.0
 */
namespace yiisns\admin\controllers;

use yiisns\apps\helpers\UrlHelper;

use yiisns\kernel\actions\LogoutAction;
use yiisns\kernel\helpers\RequestResponse;
use yiisns\kernel\models\forms\BlockedUserForm;
use yiisns\kernel\models\User;
use yiisns\kernel\models\forms\LoginForm;
use yiisns\kernel\models\forms\LoginFormUsernameOrEmail;
use yiisns\kernel\models\forms\PasswordResetRequestForm;
use yiisns\kernel\models\forms\PasswordResetRequestFormEmailOrLogin;
use yiisns\admin\controllers\helpers\ActionManager;
use yiisns\admin\filters\AccessControl;
use yiisns\admin\filters\AdminAccessControl;
use yiisns\admin\widgets\ActiveForm;

use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * Class AuthController
 *
 * @package yiisns\admin\controllers
 */
class AuthController extends AdminController
{
    /**
     *
     * @var boolean whether to enable CSRF validation for the actions in this controller.
     *      CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
     */
    //public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AdminAccessControl::className(),
                'only' => [
                    'logout',
                    'lock'
                ],
                // , 'login', 'auth', 'reset-password'
                'rules' => [
                    /*
                     * [
                     * 'actions' => ['login', 'auth', 'reset-password'],
                     * 'allow' => true,
                     * 'roles' => ['?'],
                     * ],
                     */
                    [
                        'actions' => [
                            'logout',
                            'lock'
                        ],
                        'allow' => true,
                        'roles' => [
                            '@'
                        ]
                    ]
                ]
            ],
            
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => [
                        'post'
                    ],
                    'lock' => [
                        'post'
                    ]
                ]
            ]
        ];
    }

    public $defaultAction = 'auth';

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'logout' => [
                'class' => LogoutAction::className()
            ]
        ];
    }

    public function actionLock()
    {
        $this->view->title = \Yii::t('yiisns/kernel', 'Lock Mode');
        \Yii::$app->user->identity->lockAdmin();
        
        if ($ref = UrlHelper::getCurrent()->getRef()) {
            return $this->redirect($ref);
        } else {
            return $this->redirect(Yii::$app->getUser()
                ->getReturnUrl());
        }
    }

    public function actionResetPassword()
    {
        $this->view->title = \Yii::t('yiisns/kernel', 'Password recovery');
        $this->layout = 'main-login';
        
        if (! \Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $token = \Yii::$app->request->get('token');
        
        if (! $token) {
            return $this->goHome();
        }
        
        $user = User::findByPasswordResetToken($token);
        
        if ($user) {
            $password = \Yii::$app->getSecurity()->generateRandomString(10);
            
            $user->setPassword($password);
            $user->generatePasswordResetToken();
            
            if ($user->save(false)) {
                
                \Yii::$app->mailer->view->theme->pathMap = ArrayHelper::merge(\Yii::$app->mailer->view->theme->pathMap, [
                    '@app/mail' => [
                        '@yiisns/mail-templates'
                    ]
                ]);
                
                \Yii::$app->mailer->compose('@app/mail/new-password', [
                    'user' => $user,
                    'password' => $password
                ])
                    ->setFrom([
                    \Yii::$app->appSettings->adminEmail => \Yii::$app->appSettings->appName
                ])
                    ->setTo($user->email)
                    ->setSubject(\Yii::t('yiisns/kernel', 'New password') . ' ' . \Yii::$app->appSettings->appName)
                    ->send();
                
                $message = \Yii::t('yiisns/kernel', 'New password sent to your e-mail');
            }
        } else {
            $message = \Yii::t('yiisns/kernel', 'Link outdated, try to request a password recovery again.');
        }
        
        return $this->render('reset-password', [
            'message' => $message
        ]);
    }

    public function actionBlocked()
    {
        $this->view->title = \Yii::t('yiisns/kernel', 'Lock Mode');
        
        $this->layout = 'main-login';
        
        if ($ref = UrlHelper::getCurrent()->getRef()) {
            $goUrl = $ref;
        }
        
        if (! $goUrl) {
            $goUrl = \Yii::$app->getHomeUrl();
        }
        
        if (\Yii::$app->user->isGuest) {
            return $goUrl ? $this->redirect($goUrl) : $this->goHome();
        }
        
        $model = new BlockedUserForm();
        
        $rr = new RequestResponse();
        if ($rr->isRequestOnValidateAjaxForm()) {
            return $rr->ajaxValidateForm($model);
        }
        
        if ($rr->isRequestAjaxPost()) {
            if ($model->load(\Yii::$app->request->post()) && $model->login()) {
                $rr->success = true;
                $rr->message = '';
                $rr->redirect = $goUrl;
            } else {
                $rr->success = false;
                $rr->message = \Yii::t('yiisns/kernel', 'Failed log in');
            }
            
            return $rr;
        }
        
        return $this->render('blocked', [
            'model' => $model
        ]);
    }

    public function actionAuth()
    {
        $this->view->title = \Yii::t('yiisns/kernel', 'Authorization');
        
        $this->layout = 'main-login';
        
        $goUrl = "";
        $loginModel = new LoginFormUsernameOrEmail();
        $passwordResetModel = new PasswordResetRequestFormEmailOrLogin();
        
        if ($ref = UrlHelper::getCurrent()->getRef()) {
            $goUrl = $ref;
        }
        
        $rr = new RequestResponse();
        
        if (! \Yii::$app->user->isGuest) {
            return $goUrl ? $this->redirect($goUrl) : $this->goHome();
        }
        
        if (\Yii::$app->request->post('do') == 'login') {
            
            if ($rr->isRequestOnValidateAjaxForm()) {
                return $rr->ajaxValidateForm($loginModel);
            }
            
            if ($rr->isRequestAjaxPost()) {
                if ($loginModel->load(\Yii::$app->request->post()) && $loginModel->login()) {
                    if (! $goUrl) {
                        $goUrl = \Yii::$app->getUser()->getReturnUrl($defaultUrl);
                    }
                    
                    $rr->redirect = $goUrl;
                    
                    $rr->success = true;
                    $rr->message = '';
                    $rr->message = '';
                    return (array) $rr;
                } else {
                    $rr->success = false;
                    $rr->message = \Yii::t('yiisns/kernel', 'Unsuccessful attempt authorization');
                    return (array) $rr;
                }
            }
        }
        
        if (\Yii::$app->request->post('do') == 'password-reset') {
            if ($rr->isRequestOnValidateAjaxForm()) {
                return $rr->ajaxValidateForm($passwordResetModel);
            }
            
            if ($rr->isRequestAjaxPost()) {
                if ($passwordResetModel->load(\Yii::$app->request->post()) && $passwordResetModel->sendEmail()) {
                    $rr->success = true;
                    $rr->message = \Yii::t('yiisns/kernel', 'Check your email address');
                    return (array) $rr;
                } else {
                    $rr->success = false;
                    $rr->message = \Yii::t('yiisns/kernel', 'Failed send email');
                    return (array) $rr;
                }
            }
        }
        
        return $this->render('auth', [
            'loginModel' => $loginModel,
            'passwordResetModel' => $passwordResetModel,
            'goUrl' => $goUrl
        ]);
    }
}