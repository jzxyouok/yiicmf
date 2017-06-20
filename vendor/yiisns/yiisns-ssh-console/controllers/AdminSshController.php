<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.04.2016
 */
namespace yiisns\sshConsole\controllers;

use yiisns\admin\controllers\AdminController;

use Yii;
use yii\web\Response;

/**
 * Class AdminSshController
 * @package yiisns\kernel\sshConsole\controllers
 */
class AdminSshController extends AdminController
{
    public function init()
    {
        $this->name = \Yii::t('yiisns/sshConsole', 'Ssh console');
        parent::init();
    }
    
    public function actionConsole()
    {
        $this->layout = '@yiisns/sshConsole/views/layouts/clean';

        return $this->render($this->action->id);
    }

    public function actionIndex()
    {
        return $this->render($this->action->id);
    }
}