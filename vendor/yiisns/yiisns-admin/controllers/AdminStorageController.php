<?php
/**
 * AdminStorageController
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 29.01.2016
 * @since 1.0.0
 */
namespace yiisns\admin\controllers;

use yiisns\kernel\models\StorageFile;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\controllers\AdminController;
use yiisns\kernel\models\User;

use Yii;

/**
 * Class AdminStorageFilesController
 * 
 * @package yiisns\admin\controllers
 */
class AdminStorageController extends AdminController
{
    public function init()
    {
        $this->name = \Yii::t('yiisns/kernel', 'Managing Servers');
        parent::init();
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => AdminAction::className(),
                'name' => 'Managing Servers',
                'callback' => [
                    $this,
                    'actionIndex'
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $clusters = \Yii::$app->storage->getClusters();
        
        return $this->render($this->action->id);
    }
}