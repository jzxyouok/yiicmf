<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 31.05.2016
 */
namespace yiisns\admin\controllers;

use yiisns\kernel\models\Lang;
use yiisns\admin\actions\modelEditor\AdminMultiModelEditAction;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\traits\AdminModelEditorStandartControllerTrait;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class AdminLangController
 * 
 * @package yiisns\admin\controllers
 * @method eachMultiActivate()
 * @method eachMultiInActivate()
 * @see yiisns\admin\traits\AdminModelEditorStandartControllerTrait
 */
class AdminLangController extends AdminModelEditorController
{
    use AdminModelEditorStandartControllerTrait;

    public function init()
    {
        $this->name = \Yii::t('yiisns/kernel', 'Languages management');
        $this->modelShowAttribute = 'name';
        $this->modelClassName = Lang::className();
        
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'activate-multi' => [
                'class' => AdminMultiModelEditAction::className(),
                'name' => \Yii::t('yiisns/kernel', 'Activate'),
                //'icon' => 'glyphicon glyphicon-*',
                'eachCallback' => [
                    $this,
                    'eachMultiActivate',
                ]
            ],
            
            'inActivate-multi' => [
                'class' => AdminMultiModelEditAction::className(),
                'name' => \Yii::t('yiisns/kernel', 'Deactivate'),
                //'icon' => 'glyphicon glyphicon-*',
                'eachCallback' => [
                    $this,
                    'eachMultiInActivate'
                ]
            ]
        ]);
    }
}