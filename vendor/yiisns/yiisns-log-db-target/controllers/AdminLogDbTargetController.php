<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.05.2016
 */
namespace yiisns\logDbTarget\controllers;

use yiisns\logDbTarget\models\LogDbTargetModel;
use yiisns\admin\controllers\AdminModelEditorController;
use yii\helpers\ArrayHelper;

/**
 * Class AdminLogDbTargetController
 * 
 * @package yiisns\kernel\LogDbTarget\controllers
 */
class AdminLogDbTargetController extends AdminModelEditorController
{

    public function init()
    {
        $this->name = \Yii::t('yiisns/logdb', 'Managing logs');
        $this->modelShowAttribute = 'id';
        $this->modelClassName = LogDbTargetModel::className();
        
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = ArrayHelper::merge(parent::actions(), [
            'update' => [
                'name' => \Yii::t('yiisns/logdb', 'Watch'),
                'icon' => 'glyphicon glyphicon-pencil'
            ]
        ]);
        
        unset($actions['create']);
        
        return $actions;
    }
}