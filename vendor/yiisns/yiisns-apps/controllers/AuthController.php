<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 05.11.2016
 * @since 1.0.0
 */
namespace yiisns\apps\controllers;

use yiisns\kernel\actions\LogoutAction;
use yiisns\kernel\base\Controller;
use yiisns\apps\helpers\AjaxRequestResponse;
use yiisns\kernel\helpers\RequestResponse;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\UserEmail;
use yiisns\kernel\models\forms\LoginForm;
use yiisns\kernel\models\forms\LoginFormUsernameOrEmail;
use yiisns\kernel\models\forms\PasswordResetRequestFormEmailOrLogin;
use yiisns\kernel\models\forms\SignupForm;
use yiisns\kernel\models\User;
use yiisns\admin\controllers\helpers\ActionManager;
use yiisns\admin\filters\AccessControl;

use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class AuthController
 * 
 * @package yiisns\apps\controllers
 */
class AuthController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => [
                    'logout',
                    'login'
                ],
                'rules' => [
                    [
                        'actions' => [
                            'login'
                        ],
                        'allow' => true,
                        'roles' => [
                            '?'
                        ]
                    ],
                    [
                        'actions' => [
                            'logout'
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
                    ]
                ]
            ]
        ];
    }

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

    /**
     * Восстановлеине пароля
     * 
     * @return string|Response
     */
    public function actionForget()
    {
        $rr = new RequestResponse();
        $model = new PasswordResetRequestFormEmailOrLogin();
        $model->isAdmin = false;
       
        if ($rr->isRequestOnValidateAjaxForm()) {
            return $rr->ajaxValidateForm($model);
        }
        if ($rr->isRequestAjaxPost()) {
            if ($model->load(\Yii::$app->request->post()) && $model->sendEmail()) {
                $rr->success = true;
                $rr->message = \Yii::t('yiisns/apps', 'Check your email, we sent further instructions');
            } else {
                $rr->message = \Yii::t('yiisns/apps', 'Password recovery request failed');
            }
            
            return (array) $rr;
        } else 
            if (\Yii::$app->request->isPost) {
                if ($model->load(\Yii::$app->request->post()) && $model->sendEmail()) {
                    if ($ref = UrlHelper::getCurrent()->getRef()) {
                        return $this->redirect($ref);
                    } else {
                        return $this->goBack();
                    }
                }
            }
        
        return $this->render('forget', [
            'model' => $model
        ]);
    }

    public function actionLogin()
    {
        if (! \Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $rr = new RequestResponse();
        $model = new LoginFormUsernameOrEmail();
        if ($rr->isRequestOnValidateAjaxForm()) {
            return $rr->ajaxValidateForm($model);
        }
        if ($rr->isRequestAjaxPost()) {
            if ($model->load(\Yii::$app->request->post()) && $model->login()) {
                $rr->success = true;
                $rr->message = \Yii::t('yiisns/apps', 'Authorization was successful');
                
                if ($ref = UrlHelper::getCurrent()->getRef()) {
                    $rr->redirect = $ref;
                } else {
                    $rr->redirect = Yii::$app->getUser()->getReturnUrl();
                    ;
                }
            } else {
                $rr->message = \Yii::t('yiisns/apps', 'Could not log in');
            }
            
            return (array) $rr;
        } else 
            if (\Yii::$app->request->isPost) {
                if ($model->load(\Yii::$app->request->post()) && $model->login()) {
                    if ($ref = UrlHelper::getCurrent()->getRef()) {
                        return $this->redirect($ref);
                    } else {
                        return $this->goBack();
                    }
                }
            }
        
        return $this->render('login', [
            'model' => $model
        ]);
    }

    /**
     * 
     * @return string|Response
     */
    public function actionRegister()
    {
        if (! \Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $rr = new RequestResponse();
        $model = new SignupForm();
        $model->scenario = SignupForm::SCENARION_FULLINFO;
        if ($rr->isRequestOnValidateAjaxForm()) {
            return $rr->ajaxValidateForm($model);
        }
        if ($rr->isRequestAjaxPost()) {
            if ($model->load(\Yii::$app->request->post()) && $registeredUser = $model->signup()) {
                $rr->success = true;
                $rr->message = \Yii::t('yiisns/apps', 'You have successfully registered');
                
                \Yii::$app->user->login($registeredUser, 0);
                
                return $this->redirect($registeredUser->getPageUrl());
            } else {
                $rr->message = \Yii::t('yiisns/apps', 'Could not register');
            }
            
            return (array) $rr;
        } else 
            if (\Yii::$app->request->isPost) {
                if ($model->load(\Yii::$app->request->post()) && $model->sendEmail()) {
                    if ($ref = UrlHelper::getCurrent()->getRef()) {
                        return $this->redirect($ref);
                    } else {
                        return $this->goBack();
                    }
                }
            }
        
        return $this->render('register', [
            'model' => $model
        ]);
    }

    /**
     * 
     * @return string|Response
     */
    public function actionRegisterByEmail()
    {
        if (! \Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $rr = new RequestResponse();
        $model = new SignupForm();
        $model->scenario = SignupForm::SCENARION_ONLYEMAIL;
        if ($rr->isRequestOnValidateAjaxForm()) {
            return $rr->ajaxValidateForm($model);
        }
        if ($rr->isRequestAjaxPost()) {
            if ($model->load(\Yii::$app->request->post()) && $registeredUser = $model->signup()) {
                $rr->success = true;
                $rr->message = \Yii::t('yiisns/apps', 'For further action, check your mail');
                
                return $rr;
            } else {
                $rr->message = \Yii::t('yiisns/apps', 'Could not register');
            }
            
            return (array) $rr;
        }
        
        return $this->render('register', [
            'model' => $model
        ]);
    }

    public function actionResetPassword()
    {
        $rr = new RequestResponse();
        $token = \Yii::$app->request->get('token');
        
        if (! $token) {
            return $this->goHome();
        }
        
        $className = \Yii::$app->user->identityClass;
        $user = $className::findByPasswordResetToken($token);
        
        if ($user) {
            $password = \Yii::$app->getSecurity()->generateRandomString(10);
            
            $user->setPassword($password);
            $user->generatePasswordResetToken();
            
            if ($user->save()) {
                
                \Yii::$app->mailer->view->theme->pathMap = ArrayHelper::merge(\Yii::$app->mailer->view->theme->pathMap, [
                    '@app/mail' => [
                        '@yiisns/apps/mail-templates'
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
                    ->setSubject('New password for ' . \Yii::$app->appSettings->appName)
                    ->send();
                
                $rr->success = true;
                $rr->message = \Yii::t('yiisns/apps', 'Your new password has been sent to your e-mail');
            }
        } else {
            $rr->message = \Yii::t('yiisns/apps', 'Error, most likely this link is already out of date');
        }
        
        return $this->render('reset-password', (array) $rr);
    }
}