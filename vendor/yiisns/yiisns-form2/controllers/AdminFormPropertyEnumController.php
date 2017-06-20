<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.05.2016
 */
namespace yiisns\form2\controllers;

use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\kernel\relatedProperties\models\RelatedPropertyModel;
use yiisns\form2\models\Form2Form;
use yiisns\form2\models\Form2FormProperty;
use yiisns\form2\models\Form2FormPropertyEnum;

use yii\helpers\ArrayHelper;

/**
 * Class AdminFormPropertyEnumController
 * @package yiisns\form2\controllers
 */
class AdminFormPropertyEnumController extends AdminModelEditorController
{
    public function init()
    {
        $this->name                   = \Yii::t('yiisns/form2', 'Control of properties');
        $this->modelShowAttribute     = 'value';
        $this->modelClassName         = Form2FormPropertyEnum::className();

        parent::init();
    }
}