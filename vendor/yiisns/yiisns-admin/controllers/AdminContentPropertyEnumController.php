<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 17.05.2016
 */
namespace yiisns\admin\controllers;

use yiisns\kernel\models\ContentPropertyEnum;
use yiisns\admin\controllers\AdminModelEditorController;

use Yii;

/**
 * Class AdminContentPropertyEnumController
 * @package yiisns\admin\controllers
 */
class AdminContentPropertyEnumController extends AdminModelEditorController
{
    public function init()
    {
        $this->name                   = \Yii::t('yiisns/kernel', 'Manage Property values');
        $this->modelShowAttribute      = 'value';
        $this->modelClassName          = ContentPropertyEnum::className();

        parent::init();
    }
}