<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 16.10.2016
 */
namespace yiisns\admin\controllers;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\ComponentSettings;
use yiisns\kernel\models\Lang;
use yiisns\kernel\models\Comment;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\controllers\AdminController;
use yiisns\kernel\models\User;

/**
 * Class AdminAjaxController
 * @package yiisns\admin\controllers
 */
class AdminAjaxController extends AdminController
{
    public function actionSetLang()
    {
        $rr = new RequestResponse();

        $newLang = \Yii::$app->request->post('code');
        $lang = Lang::find()->active()->andWhere(['code' => $newLang])->one();

        if (!$lang)
        {
            $rr->message = \Yii::t('yiisns/kernel', 'The tongue is disconnected or removed');
            $rr->success = false;
            return $rr;
        }

        $rr->success = true;

        $userSettings = ComponentSettings::createByComponentUserId(\Yii::$app->admin, \Yii::$app->user->id);
        $userSettings->setSettingValue('languageCode', $lang->code);

        if (!$userSettings->save())
        {
            $rr->message = \Yii::t('yiisns/kernel', 'Could not save settings');
            $rr->success = false;
            return $rr;
        }

        \Yii::$app->admin->invalidateCache();

        return $rr;
    }
}