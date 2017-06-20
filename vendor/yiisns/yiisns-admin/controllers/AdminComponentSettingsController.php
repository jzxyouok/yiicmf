<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.03.2016
 */
namespace yiisns\admin\controllers;

use yiisns\kernel\base\Component;
use yiisns\apps\components\AppSettings;
use yiisns\kernel\helpers\RequestResponse;
use yiisns\kernel\models\ComponentSettings;
use yiisns\kernel\models\Site;
use yiisns\kernel\models\User;
use yiisns\admin\controllers\AdminController;

use yii\base\ActionEvent;
use yii\base\Theme;
use yii\base\UserException;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * @property array $callableData; 
 * 
 * Class AdminComponentSettingsController
 * @package yiisns\admin\controllers
 */
class AdminComponentSettingsController extends AdminController
{
    /**
     *
     * @return string
     */
    public function getPermissionName()
    {
        return 'admin/admin-settings';
    }

    public function init()
    {
        $this->name = \Yii::t('yiisns/kernel', 'The configuration of components');
        parent::init();
    }

    /**
     *
     * @var Component
     */
    protected $_component = null;

    /**
     *
     * @var array
     */
    protected $_callableData = [];

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            
            $componentClassName = \Yii::$app->request->get('componentClassName');
            $namespace = \Yii::$app->request->get('componentNamespace');
            
            if ($namespace) {
                $component = new $componentClassName([
                    'namespace' => $namespace
                ]);
            } else {
                $component = new $componentClassName();
            }
            
            if (! $component || ! $component instanceof Component) {
                throw new UserException('The component is incorrect');
            }
            
            $this->_component = $component;
            $this->_callableData = $this->_getCallableData($component);
            
            \Yii::$app->view->theme = new Theme([
                'pathMap' => [
                    '@app/views' => [
                        '@yiisns/admin/views'
                    ]
                ]
            ]);
            
            \Yii::$app->language = \Yii::$app->admin->languageCode;
            
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @return array
     */
    public function getCallableData()
    {
        return $this->_callableData;
    }

    /**
     *
     * @return string
     */
    public function actionCallEdit()
    {
        $component = $this->_component;
        
        if (\Yii::$app->request->get('attributes') && ! $settings = \yiisns\kernel\models\ComponentSettings::fetchByComponentDefault($component)) {
            $attributes = \Yii::$app->request->get('attributes');
            $component->attributes = $attributes;
        } else {
            $component->loadDefaultSettings();
        }
        
        if (! \Yii::$app->request->get('callableId')) {
            return $this->redirect(\yii\helpers\Url::to('index') . "?" . http_build_query(\Yii::$app->request->get()));
        }
        
        return $this->render($this->action->id, [
            'component' => $component,
            'callableId' => \Yii::$app->request->get('callableId')
        ]);
    }

    public function actionSaveCallable()
    {
        $rr = new RequestResponse();
        
        if ($data = \Yii::$app->request->post('data')) {
            $component = $this->_component;
            $this->_saveCallableData($component, unserialize(base64_decode($data)));
        }
        
        return $rr;
    }

    public function actionIndex()
    {
        $component = $this->_component;
        
        $attibutes = (array) \Yii::$app->request->get('attributes');
        
        if ($attributesCallable = ArrayHelper::getValue($this->_callableData, 'attributes')) {
            $attibutes = ArrayHelper::merge($attibutes, $attributesCallable);
        }
        
        if ($attibutes && ! \yiisns\kernel\models\ComponentSettings::fetchByComponentDefault($component)) {
            $attributes = $attibutes;
            $component->attributes = $attributes;
        } else {
            $component->loadDefaultSettings();
        }
        
        $rr = new RequestResponse();
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost && ! \Yii::$app->request->isPjax) {
            return $rr->ajaxValidateForm($component);
        }
        
        if (\Yii::$app->request->isPost && \Yii::$app->request->isPjax) {
            if ($component->load(\Yii::$app->request->post()) && $component->validate()) {
                if ($component->saveDefaultSettings()) {
                    \Yii::$app->getSession()->setFlash('success', \Yii::t('yiisns/kernel', 'Saved successfully'));
                } else {
                    \Yii::$app->getSession()->setFlash('error', \Yii::t('yiisns/kernel', 'Saved faield'));
                }
            } else {
                \Yii::$app->getSession()->setFlash('error', \Yii::t('yiisns/kernel', 'Saved faield'));
            }
        }
        
        return $this->render($this->action->id, [
            'component' => $component
        ]);
    }

    public function actionSite()
    {
        $component = $this->_component;
        
        $site_id = \Yii::$app->request->get('site_id');
        if (! $site_id) {
            throw new UserException('Not to the parameter:site_id');
        }
        
        $site = Site::findOne($site_id);
        if (! $site) {
            throw new UserException('WebSite not found');
        }
        
        $component->loadSettingsBySite($site);
        
        $rr = new RequestResponse();
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost && ! \Yii::$app->request->isPjax) {
            return $rr->ajaxValidateForm($component);
        }
        
        if (\Yii::$app->request->isPost && \Yii::$app->request->isPjax) {
            if ($component->load(\Yii::$app->request->post()) && $component->validate()) {
                if ($component->saveDefaultSettingsBySiteCode($site->code)) {
                    \Yii::$app->getSession()->setFlash('success', \Yii::t('yiisns/kernel', 'Saved successfully'));
                } else {
                    \Yii::$app->getSession()->setFlash('error', \Yii::t('yiisns/kernel', 'Saved failed'));
                }
            } else {
                \Yii::$app->getSession()->setFlash('error', \Yii::t('yiisns/kernel', 'Saved failed'));
            }
        }
        
        return $this->render($this->action->id, [
            'component' => $component,
            'site' => $site
        ]);
    }

    public function actionUser()
    {
        $component = $this->_component;
        
        $user_id = \Yii::$app->request->get('user_id');
        if (! $user_id) {
            throw new UserException("Not to the parameter:user_id");
        }
        
        $user = User::findOne($user_id);
        if (! $user) {
            throw new UserException("User not found");
        }
        
        $component->loadSettingsByUser($user);
        
        $rr = new RequestResponse();
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost && ! \Yii::$app->request->isPjax) {
            return $rr->ajaxValidateForm($component);
        }
        
        if (\Yii::$app->request->isPost && \Yii::$app->request->isPjax) {
            if ($component->load(\Yii::$app->request->post()) && $component->validate()) {
                if ($component->saveDefaultSettingsByUserId($user->id)) {
                    \Yii::$app->getSession()->setFlash('success', \Yii::t('yiisns/kernel', 'Saved successfully'));
                } else {
                    \Yii::$app->getSession()->setFlash('error', \Yii::t('yiisns/kernel', 'Saved failed'));
                }
            } else {
                \Yii::$app->getSession()->setFlash('error', \Yii::t('yiisns/kernel', 'Saved failed'));
            }
        }
        
        return $this->render($this->action->id, [
            'component' => $component,
            'user' => $user
        ]);
    }

    public function actionUsers()
    {
        $component = $this->_component;
        
        return $this->render($this->action->id, [
            'component' => $component
        ]);
    }

    public function actionSites()
    {
        $component = $this->_component;
        
        return $this->render($this->action->id, [
            'component' => $component
        ]);
    }

    public function actionCache()
    {
        $component = $this->_component;
        
        $rr = new RequestResponse();
        
        if ($rr->isRequestAjaxPost()) {
            $component->invalidateCache();
            $rr->message = 'The cache clearing successfully';
            $rr->success = true;
            return (array) $rr;
        }
        
        return $this->render($this->action->id, [
            'component' => $component
        ]);
    }

    public function actionRemove()
    {
        $component = $this->_component;
        
        $rr = new RequestResponse();
        
        if ($rr->isRequestAjaxPost()) {
            if (\Yii::$app->request->post('do') == 'all') {
                if ($settings = \yiisns\kernel\models\ComponentSettings::baseQuery($component)->all()) {
                    /**
                     *
                     * @var $setting ComponentSettings
                     */
                    foreach ($settings as $setting) {
                        if ($setting->delete()) {}
                    }
                    
                    $component->invalidateCache();
                    $rr->message = 'Configuration successfully deleted';
                    $rr->success = true;
                }
                ;
            } else 
                if (\Yii::$app->request->post('do') == 'default') {
                    if ($settings = \yiisns\kernel\models\ComponentSettings::fetchByComponentDefault($component)) {
                        $settings->delete();
                        $component->invalidateCache();
                        $rr->message = 'Configuration successfully deleted';
                        $rr->success = true;
                    }
                    ;
                } else 
                    if (\Yii::$app->request->post('do') == 'sites') {
                        if ($settings = \yiisns\kernel\models\ComponentSettings::baseQuerySites($component)->all()) {
                            /**
                             *
                             * @var $setting ComponentSettings
                             */
                            foreach ($settings as $setting) {
                                if ($setting->delete()) {}
                            }
                            
                            $component->invalidateCache();
                            $rr->message = 'Configuration successfully deleted';
                            $rr->success = true;
                        }
                        ;
                    } else 
                        if (\Yii::$app->request->post('do') == 'users') {
                            if ($settings = \yiisns\kernel\models\ComponentSettings::baseQueryUsers($component)->all()) {
                                /**
                                 *
                                 * @var $setting ComponentSettings
                                 */
                                foreach ($settings as $setting) {
                                    if ($setting->delete()) {}
                                }
                                
                                $component->invalidateCache();
                                $rr->message = 'Configuration successfully deleted';
                                $rr->success = true;
                            }
                            ;
                        } 

                        else 
                            if (\Yii::$app->request->post('do') == 'site') {
                                $code = \Yii::$app->request->post('code');
                                $site = Site::find()->where([
                                    'code' => $code
                                ])->one();
                                
                                if ($site) {
                                    if ($settings = \yiisns\kernel\models\ComponentSettings::fetchByComponentSite($component, $site)) {
                                        $settings->delete();
                                        $component->invalidateCache();
                                        $rr->message = 'Configuration successfully deleted';
                                        $rr->success = true;
                                    }
                                    ;
                                }
                            } 

                            else 
                                if (\Yii::$app->request->post('do') == 'user') {
                                    $id = \Yii::$app->request->post('id');
                                    $user = User::find()->where([
                                        'id' => $id
                                    ])->one();
                                    
                                    if ($user) {
                                        if ($settings = \yiisns\kernel\models\ComponentSettings::fetchByComponentUser($component, $user)) {
                                            $settings->delete();
                                            $component->invalidateCache();
                                            $rr->message = 'Configuration successfully deleted';
                                            $rr->success = true;
                                        }
                                        ;
                                    }
                                } 

                                else {
                                    $rr->message = 'All the settings';
                                    $rr->success = true;
                                }
            
            return (array) $rr;
        }
        
        return $this->render($this->action->id, [
            'component' => $component
        ]);
    }

    /**
     *
     * @param Component $component            
     * @param array $data            
     */
    protected function _saveCallableData($component, $data = [])
    {
        $key = md5($component::className() . $component->namespace);
        \Yii::$app->cache->set($key, $data);
    }

    /**
     *
     * @param Component $component            
     * @param array $data            
     */
    protected function _getCallableData($component)
    {
        $key = md5($component::className() . $component->namespace);
        return (array) \Yii::$app->cache->get($key);
    }
}