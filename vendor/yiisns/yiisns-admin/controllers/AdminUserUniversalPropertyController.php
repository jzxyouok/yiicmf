<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 17.05.2016
 */
namespace yiisns\admin\controllers;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\TreeTypeProperty;
use yiisns\kernel\models\UserUniversalProperty;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\kernel\relatedProperties\models\RelatedPropertyModel;
use yii\helpers\ArrayHelper;

/**
 * Class AdminTreeTypePropertyController
 * @package yiisns\admin\controllers
 */
class AdminUserUniversalPropertyController extends AdminModelEditorController
{
    public $notSubmitParam = 'sx-not-submit';

    public function init()
    {
        $this->name                   = \Yii::t('yiisns/kernel', 'User control properties');
        $this->modelShowAttribute      = 'name';
        $this->modelClassName          = UserUniversalProperty::className();

        parent::init();

    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(),
            [

                'create' =>
                [
                    'callback'         => [$this, 'create'],
                ],

                'update' =>
                [
                    'callback'         => [$this, 'update'],
                ],
            ]
        );
    }



    public function create()
    {
        $rr = new RequestResponse();

        $modelClass = $this->modelClassName;
        $model = new $modelClass();
        $model->loadDefaultValues();

        if ($post = \Yii::$app->request->post())
        {
            $model->load($post);
        }

        $handler = $model->handler;
        if ($handler)
        {
            if ($post = \Yii::$app->request->post())
            {
                $handler->load($post);
            }
        }

        if ($rr->isRequestPjaxPost())
        {
            if (!\Yii::$app->request->post($this->notSubmitParam))
            {
                $model->component_settings = $handler->toArray();
                $handler->load(\Yii::$app->request->post());

                if ($model->load(\Yii::$app->request->post())
                    && $model->validate() && $handler->validate())
                {
                    $model->save();

                    \Yii::$app->getSession()->setFlash('success', \Yii::t('yiisns/kernel', 'Saved'));

                    return $this->redirect(
                        UrlHelper::constructCurrent()->setCurrentRef()->enableAdmin()->setRoute($this->modelDefaultAction)->normalizeCurrentRoute()
                            ->addData([$this->requestPkParamName => $model->{$this->modelPkAttribute}])
                            ->toString()
                    );
                } else
                {
                    \Yii::$app->getSession()->setFlash('error', \Yii::t('yiisns/kernel', 'Could not save'));
                }
            }
        }

        return $this->render('_form', [
            'model'     => $model,
            'handler'   => $handler,
        ]);
    }


    public function update()
    {
        $rr = new RequestResponse();

        $model = $this->model;

        if ($post = \Yii::$app->request->post())
        {
            $model->load($post);
        }

        $handler = $model->handler;
        if ($handler)
        {
            if ($post = \Yii::$app->request->post())
            {
                $handler->load($post);
            }
        }

        if ($rr->isRequestPjaxPost())
        {
            if (!\Yii::$app->request->post($this->notSubmitParam))
            {
                if ($rr->isRequestPjaxPost())
                {
                    $model->component_settings = $handler->toArray();
                    $handler->load(\Yii::$app->request->post());

                    if ($model->load(\Yii::$app->request->post())
                        && $model->validate() && $handler->validate())
                    {
                        $model->save();

                        \Yii::$app->getSession()->setFlash('success', \Yii::t('yiisns/kernel', 'Saved'));

                        if (\Yii::$app->request->post('submit-btn') == 'apply')
                        {

                        } else
                        {
                            return $this->redirect(
                                $this->indexUrl
                            );
                        }

                        $model->refresh();

                    }
                }
            }
        }

        return $this->render('_form', [
            'model'     => $model,
            'handler'   => $handler,
        ]);
    }
}