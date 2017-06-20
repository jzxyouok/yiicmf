<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.06.2016
 */
namespace yiisns\form2\controllers;

use yiisns\admin\actions\modelEditor\AdminOneModelEditAction;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\form2\models\Form2Form;
use yiisns\form2\models\Form2FormSend;

use yii\helpers\ArrayHelper;

/**
 * Class AdminFormController
 * @package yiisns\form2\controllers
 */
class AdminFormSendController extends AdminModelEditorController
{
    public function init()
    {
        $this->name                     = \Yii::t('yiisns/form2', 'Messages');
        $this->modelShowAttribute       = 'id';
        $this->modelClassName           = Form2FormSend::className();

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = ArrayHelper::merge(parent::actions(),
        [
            'update' =>
            [
                'name' => \Yii::t('yiisns/form2', 'View'),
                'icon' => 'glyphicon glyphicon-eye-open',
                'priority' => 0,
            ],
        ]);

        ArrayHelper::remove($actions, 'create');
        ArrayHelper::remove($actions, 'system');
        ArrayHelper::remove($actions, 'related-properties');

        return $actions;
    }
}