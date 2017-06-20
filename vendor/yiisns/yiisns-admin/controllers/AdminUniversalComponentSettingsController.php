<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 31.05.2016
 */
namespace yiisns\admin\controllers;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\apps\helpers\StringHelper;
use yiisns\admin\controllers\AdminController;
use yiisns\admin\controllers\AdminModelEditorController;

use yii\helpers\Json;

/**
 * Class AdminUniversalComponentSettingsController
 * @package yiisns\admin\controllers
 */
class AdminUniversalComponentSettingsController extends AdminController
{
    public function init()
    {
        $this->name = \Yii::t('yiisns/kernel', 'Configuration management component');
        parent::init();
    }

    public function actionIndex()
    {
        $rr = new RequestResponse();

        $classComponent = \Yii::$app->request->get('component');
        $classComponentSettings = (string) \Yii::$app->request->get('settings');
        if ($classComponentSettings)
        {
            $classComponentSettings = unserialize(StringHelper::base64DecodeUrl($classComponentSettings));
        }

        /**
         * @var $component \yiisns\kernel\relatedProperties\PropertyType;
         */
        $component = new $classComponent();
        try
        {
            $component->attributes = $classComponentSettings;
        } catch (\Exception $e)
        {}

        if (\Yii::$app->request->isAjax && !\Yii::$app->request->isPjax)
        {
            return $rr->ajaxValidateForm($component);
        }


        $forSave = "";
        if ($rr->isRequestPjaxPost())
        {
            if ($component->load(\Yii::$app->request->post()))
            {
                \Yii::$app->session->setFlash('success', 'Saved');
                $forSave = StringHelper::base64EncodeUrl(serialize($component->attributes));

            } else
            {
                \Yii::$app->session->setFlash('error', 'Error');
            };
        }

        return $this->render($this->action->id, [
            'component' => $component,
            'forSave'   => $forSave,
        ]);
    }

    public function actionSave()
    {
        $rr = new RequestResponse();

        $classComponent = \Yii::$app->request->get('component');

        /**
         * @var $component \yiisns\kernel\relatedProperties\PropertyType;
         */
        $component = new $classComponent();

        if (\Yii::$app->request->isAjax && !\Yii::$app->request->isPjax)
        {
            $component->load(\Yii::$app->request->post());
            $forSave = StringHelper::base64EncodeUrl(serialize($component->attributes));

            $rr->success = true;
            $rr->message;

            $rr->data =
            [
                'forSave' => $forSave
            ];

            return $rr;
        }
    }
}