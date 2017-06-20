<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 17.04.2016
 */
namespace yiisns\agent\controllers;

use yiisns\agent\models\Agent;
use yiisns\apps\components\AppSettings;
use yiisns\kernel\helpers\RequestResponse;
use yiisns\admin\actions\modelEditor\AdminMultiModelEditAction;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\traits\AdminModelEditorStandartControllerTrait;
use yii\helpers\ArrayHelper;

/**
 * Class AdminAgentController
 * @package yiisns\kernel\controllers
 */
class AdminAgentController extends AdminModelEditorController
{
    use AdminModelEditorStandartControllerTrait;

    public function init()
    {
        $this->name                     = \Yii::t('yiisns/agent', 'Agents');
        $this->modelShowAttribute       = 'id';
        $this->modelClassName           = Agent::className();

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(),
            [
                'activate-multi' =>
                [
                    'class'             => AdminMultiModelEditAction::className(),
                    'name'              => \Yii::t('yiisns/agent', 'Activate'),
                    //'icon'              => 'glyphicon glyphicon-trash',
                    'eachCallback'      => [$this, 'eachMultiActivate'],
                ],

                'inActivate-multi' =>
                [
                    'class'             => AdminMultiModelEditAction::className(),
                    'name'              => \Yii::t('yiisns/agent', 'Activate'),
                    //'icon'              => 'glyphicon glyphicon-trash',
                    'eachCallback'      => [$this, 'eachMultiInActivate'],
                ]
            ]
        );
    }

    /**
     * @return RequestResponse
     */
    public function actionLoad()
    {
        $rr = new RequestResponse();
        if ($rr->isRequestAjaxPost())
        {
            \Yii::$app->agent->loadAgents();
            $rr->message = \Yii::t('yiisns/agent', 'Agents have been updated successfully');
            $rr->success = true;
            return $rr;
        }
    }

    /**
     * @return RequestResponse
     */
    public function actionStopExecutable()
    {
        $rr = new RequestResponse();
        if ($rr->isRequestAjaxPost())
        {
            $stoppedLong = Agent::stopLongExecutable(0);
            $rr->message = \Yii::t('yiisns/agent', 'Running agents stopped');
            $rr->success = true;
            return $rr;
        }
    }
}