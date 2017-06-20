<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.02.2017
 */
namespace yiisns\dbDumper\controllers;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\controllers\AdminController;

use yii\data\ArrayDataProvider;
use yii\web\Response;

/**
 * Class AdminBackupController
 * 
 * @package yiisns\kernel\dbDumper\controllers
 */
class AdminBackupController extends AdminController
{
    public function init()
    {
        $this->name = \Yii::t('yiisns/dbDumper', 'Backups');
        
        parent::init();
    }

    public function actionIndex()
    {
        return $this->render($this->action->id);
    }

    public function actionDump()
    {
        $rr = new RequestResponse();
        
        if ($rr->isRequestAjaxPost()) {
            try {
                ob_start();
                \Yii::$app->dbDumper->dump();
                $result = ob_get_clean();
                
                $rr->success = true;
                $rr->message = \Yii::t('yiisns/dbDumper', 'A copy created successfully');
                $rr->data = [
                    'result' => $result
                ];
            } catch (\Exception $e) {
                $rr->success = false;
                $rr->message = $e->getMessage();
            }
            
            return $rr;
        }
        
        return $rr;
    }
}