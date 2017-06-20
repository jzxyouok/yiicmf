<?php
/**
 * ErrorController
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 04.11.2016
 * @since 1.0.0
 */
namespace yiisns\apps\controllers;

use yiisns\kernel\base\AppCore;
use yiisns\kernel\helpers\RequestResponse;
use yiisns\kernel\models\ComponentSettings;

use Yii;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class ToolbarController
 * 
 * @package yiisns\apps\controllers
 */
class ToolbarController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }

    public function actionTriggerEditWidgets()
    {
        $rr = new RequestResponse();
        
        if (\Yii::$app->request->isPost && \Yii::$app->request->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            
            if (\Yii::$app->toolbar->editWidgets == AppCore::BOOL_Y) {
                $userSettings = ComponentSettings::createByComponentUserId(\Yii::$app->toolbar, \Yii::$app->user->id);
                $userSettings->setSettingValue('editWidgets', AppCore::BOOL_N);
                
                if (! $userSettings->save()) {
                    $rr->message = \Yii::t('yiisns/kernel', 'Could not save settings');
                    $rr->success = false;
                    return $rr;
                }
                
                \Yii::$app->toolbar->invalidateCache();
            } else {
                $userSettings = ComponentSettings::createByComponentUserId(\Yii::$app->toolbar, \Yii::$app->user->id);
                $userSettings->setSettingValue('editWidgets', AppCore::BOOL_Y);
                
                if (! $userSettings->save()) {
                    $rr->message = \Yii::t('yiisns/kernel', 'Could not save settings');
                    $rr->success = false;
                    return $rr;
                }
                
                \Yii::$app->toolbar->invalidateCache();
            }
            
            return $rr;
        }
    }

    public function actionTriggerEditViewFiles()
    {
        $rr = new RequestResponse();
        
        if (\Yii::$app->request->isPost && \Yii::$app->request->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            
            if (\Yii::$app->toolbar->editViewFiles == AppCore::BOOL_Y) {
                $userSettings = ComponentSettings::createByComponentUserId(\Yii::$app->toolbar, \Yii::$app->user->id);
                $userSettings->setSettingValue('editViewFiles', AppCore::BOOL_N);
                
                if (! $userSettings->save()) {
                    $rr->message = 'Could not save settings';
                    $rr->success = false;
                    return $rr;
                }
                
                \Yii::$app->toolbar->invalidateCache();
            } else {
                $userSettings = ComponentSettings::createByComponentUserId(\Yii::$app->toolbar, \Yii::$app->user->id);
                $userSettings->setSettingValue('editViewFiles', AppCore::BOOL_Y);
                
                if (! $userSettings->save()) {
                    $rr->message = 'Could not save settings';
                    $rr->success = false;
                    return $rr;
                }
                
                \Yii::$app->toolbar->invalidateCache();
            }
            
            return $rr;
        }
    }

    public function actionTriggerIsOpen()
    {
        if (\Yii::$app->request->isPost && \Yii::$app->request->isAjax) {
            $rr = new RequestResponse();
            
            if (\Yii::$app->request->post('isOpen') == 'true') {
                $userSettings = ComponentSettings::createByComponentUserId(\Yii::$app->toolbar, \Yii::$app->user->id);
                $userSettings->setSettingValue('isOpen', AppCore::BOOL_Y);
                
                if (! $userSettings->save()) {
                    $rr->message = \Yii::t('yiisns/kernel', 'Could not save settings');
                    $rr->success = false;
                    return $rr;
                }
                
                \Yii::$app->toolbar->invalidateCache();
                $rr->message = \Yii::t('yiisns/kernel', 'Successfully opened');
                $rr->success = true;
            } else {
                $userSettings = ComponentSettings::createByComponentUserId(\Yii::$app->toolbar, \Yii::$app->user->id);
                $userSettings->setSettingValue('isOpen', AppCore::BOOL_N);
                
                if (! $userSettings->save()) {
                    $rr->message = \Yii::t('yiisns/kernel', 'Could not save settings');
                    $rr->success = false;
                    return $rr;
                }
                
                \Yii::$app->toolbar->invalidateCache();
                $rr->message = \Yii::t('yiisns/kernel', 'Successfully closed');
                $rr->success = true;
            }
            
            return $rr;
        }
    }
}