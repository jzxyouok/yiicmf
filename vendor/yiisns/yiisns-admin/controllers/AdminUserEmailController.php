<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 31.05.2016
 */
namespace yiisns\admin\controllers;

use yiisns\kernel\models\UserEmail;
use yiisns\admin\controllers\AdminModelEditorController;

/**
 * Class AdminUserEmailController
 * 
 * @package yiisns\admin\controllers
 */
class AdminUserEmailController extends AdminModelEditorController
{
    public function init()
    {
        $this->name = \Yii::t('yiisns/kernel', 'Email addresses management');
        $this->modelShowAttribute = 'value';
        $this->modelClassName = UserEmail::className();
        
        parent::init();
    }
}