<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.05.2016
 */
namespace yiisns\admin\controllers;

use yiisns\kernel\models\TreeType;
use yiisns\admin\actions\modelEditor\AdminMultiModelEditAction;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\traits\AdminModelEditorStandartControllerTrait;

use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;

/**
 * Class AdminTreeTypeController
 * @package yiisns\admin\controllers
 */
class AdminTreeTypeController extends AdminModelEditorController
{
    use AdminModelEditorStandartControllerTrait;

    public function init()
    {
        $this->name                   = \Yii::t('yiisns/kernel', 'Set partition');
        $this->modelShowAttribute      = 'name';
        $this->modelClassName          = TreeType::className();

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
                    'class' => AdminMultiModelEditAction::className(),
                    'name' => \Yii::t('yiisns/kernel', 'Activate'),
                    //'icon' => 'glyphicon glyphicon-trash',
                    'eachCallback' => [$this, 'eachMultiActivate'],
                ],

                'inActivate-multi' =>
                [
                    'class' => AdminMultiModelEditAction::className(),
                    'name' => \Yii::t('yiisns/kernel', 'Deactivate'),
                    //'icon' => 'glyphicon glyphicon-trash',
                    'eachCallback' => [$this, 'eachMultiInActivate'],
                ]
            ]
        );
    }
}