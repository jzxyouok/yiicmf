<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 17.05.2016
 */
namespace yiisns\admin\controllers;

use yiisns\kernel\models\TreeTypePropertyEnum;
use yiisns\admin\controllers\AdminModelEditorController;

/**
 * Class AdminTreeTypePropertyEnumController
 * @package yiisns\admin\controllers
 */
class AdminTreeTypePropertyEnumController extends AdminModelEditorController
{
    public function init()
    {
        $this->name                   = \Yii::t('yiisns/kernel', 'Manage tree Property values');
        $this->modelShowAttribute      = 'value';
        $this->modelClassName          = TreeTypePropertyEnum::className();

        parent::init();
    }
}