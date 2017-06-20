<?php
/**
 * AdminFileManagerController
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.02.2016
 * @since 1.0.0
 */
namespace yiisns\admin\controllers;

use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\User;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\controllers\AdminController;

use Yii;

/**
 * Class AdminFileManagerController
 * 
 * @package yiisns\admin\controllers
 */
class AdminFileManagerController extends AdminController
{
    public function init()
    {
        if (! $this->name) {
            $this->name = \Yii::t('yiisns/kernel', 'File management');
        }
        
        parent::init();
    }

    public function actionIndex()
    {
        return $this->render($this->action->id);
    }
}