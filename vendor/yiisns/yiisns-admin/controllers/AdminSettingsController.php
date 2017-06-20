<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.03.2016
 */
namespace yiisns\admin\controllers;

use yiisns\kernel\base\Component;
use yiisns\kernel\base\AppCore;
use yiisns\apps\components\AppSettings;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\controllers\AdminController;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class AdminSettingsController
 * 
 * @package yiisns\admin\controllers
 */
class AdminSettingsController extends AdminController
{
    public function init()
    {
        $this->name = \Yii::t('yiisns/kernel', 'Management settings');
        parent::init();
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => AdminAction::className(),
                'name' => 'Settings',
                'callback' => [
                    $this,
                    'actionIndex'
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $loadedComponents = [];
        $loadedForSelect = [];
        $component = '';
        $componentSelect = AppSettings::className();
        
        foreach (\Yii::$app->getComponents(true) as $id => $data) {
            $loadedComponent = \Yii::$app->get($id);
            if ($loadedComponent instanceof Component) {
                $loadedComponents[$loadedComponent->className()] = $loadedComponent;
                
                if ($name = $loadedComponent->descriptor->name) {
                    $loadedForSelect[$loadedComponent->className()] = $name;
                } else {
                    $loadedForSelect[$loadedComponent->className()] = $loadedComponent->className();
                }
            }
        }
        
        if (\Yii::$app->request->get('component')) {
            $componentSelect = \Yii::$app->request->get('component');
        }
        
        $component = ArrayHelper::getValue($loadedComponents, $componentSelect);
        
        if ($component && $component instanceof Component) {
            
            if (\Yii::$app->request->isAjax && ! \Yii::$app->request->isPjax) {
                $component->load(\Yii::$app->request->post());
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($component);
            }
            
            if (\Yii::$app->request->isAjax) {
                if ($component->load(\Yii::$app->request->post())) {
                    if ($component->saveDefaultSettings()) {
                        \Yii::$app->getSession()->setFlash('success', 'Save Succes');
                    } else {
                        \Yii::$app->getSession()->setFlash('error', 'Could not save');
                    }
                } else {
                    \Yii::$app->getSession()->setFlash('error', 'Could not save');
                }
            }
        }
        
        if ($component) {}
        
        return $this->render('index', [
            'loadedComponents' => $loadedComponents,
            'loadedForSelect' => $loadedForSelect,
            'component' => $component
        ]);
    }
}