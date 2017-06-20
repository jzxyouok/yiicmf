<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 31.05.2016
 */
namespace yiisns\admin\controllers;

use yiisns\apps\components\AppSettings;
use yiisns\kernel\models\Site;
use yiisns\admin\actions\modelEditor\AdminMultiModelEditAction;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\traits\AdminModelEditorStandartControllerTrait;

use yii\helpers\ArrayHelper;

/**
 * Class AdminSiteController
 * 
 * @package yiisns\admin\controllers
 */
class AdminSiteController extends AdminModelEditorController
{
    use AdminModelEditorStandartControllerTrait;

    public function init()
    {
        $this->name = \Yii::t('yiisns/kernel', 'Sites management');
        $this->modelShowAttribute = 'name';
        $this->modelClassName = Site::className();
        
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'def-multi' => [
                'class' => AdminMultiModelEditAction::className(),
                'name' => \Yii::t('yiisns/kernel', 'Default'),
                'eachCallback' => [
                    $this,
                    'eachMultiDef'
                ],
                'priority' => 0
            ],
            
            'activate-multi' => [
                'class' => AdminMultiModelEditAction::className(),
                'name' => \Yii::t('yiisns/kernel', 'Activate'),
                'eachCallback' => [
                    $this,
                    'eachMultiActivate'
                ]
            ],
            
            'inActivate-multi' => [
                'class' => AdminMultiModelEditAction::className(),
                'name' => \Yii::t('yiisns/kernel', 'Deactivate'),
                'eachCallback' => [
                    $this,
                    'eachMultiInActivate'
                ]
            ]
        ]);
    }
}