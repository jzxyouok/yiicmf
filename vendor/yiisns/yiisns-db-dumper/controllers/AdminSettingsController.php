<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.04.2016
 */
namespace yiisns\dbDumper\controllers;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\controllers\AdminController;

use yii\data\ArrayDataProvider;
use yii\web\Response;

/**
 * Class AdminSettingsController
 * 
 * @package yiisns\kernel\dbDumper\controllers
 */
class AdminSettingsController extends AdminController
{
    public function init()
    {
        $this->name = \Yii::t('yiisns/dbDumper', 'Settings');
        
        parent::init();
    }

    public function actionIndex()
    {
        return $this->render($this->action->id);
    }

    public function actionRefresh()
    {
        $rr = new RequestResponse();
        
        if ($rr->isRequestAjaxPost()) {
            \Yii::$app->db->schema->refresh();
            $rr->message = \Yii::t('yiisns/dbDumper', 'The cache is updated successfully');
            $rr->success = true;
            return $rr;
        }
    }
}