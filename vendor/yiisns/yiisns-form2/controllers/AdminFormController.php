<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.05.2016
 */
namespace yiisns\form2\controllers;

use yiisns\admin\actions\modelEditor\AdminOneModelEditAction;
use yiisns\admin\actions\modelEditor\ModelEditorGridAction;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\form2\models\Form2Form;

use yii\helpers\ArrayHelper;

/**
 * Class AdminFormController
 * @package yiisns\form2\controllers
 */
class AdminFormController extends AdminModelEditorController
{
    public function init()
    {
        $this->name                     = \Yii::t('yiisns/form2', 'Forms management');
        $this->modelShowAttribute       = 'name';
        $this->modelClassName           = Form2Form::className();

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(),
            [
                'view' =>
                [
                    'class' => AdminOneModelEditAction::className(),
                    'name' => \Yii::t('yiisns/form2', 'Result'),
                    'icon' => 'glyphicon glyphicon-eye-open',
                    'priority' => 0,
                ],
            ]
        );
    }
}