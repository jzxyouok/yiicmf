<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 17.05.2016
 */
namespace yiisns\admin\controllers;

use yiisns\kernel\models\TreeTypePropertyEnum;
use yiisns\kernel\models\UserUniversalProperty;
use yiisns\kernel\models\UserUniversalPropertyEnum;
use yiisns\admin\controllers\AdminModelEditorController;

/**
 * Class AdminUserUniversalPropertyEnumController
 * @package yiisns\admin\controllers
 */
class AdminUserUniversalPropertyEnumController extends AdminModelEditorController
{
    public function init()
    {
        $this->name                   = \Yii::t('yiisns/kernel', 'Manage User Property values');
        $this->modelShowAttribute      = 'value';
        $this->modelClassName          = UserUniversalPropertyEnum::className();

        parent::init();
    }
}