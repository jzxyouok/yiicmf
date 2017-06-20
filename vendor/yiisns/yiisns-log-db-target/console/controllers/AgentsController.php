<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 07.03.2016
 */
namespace yiisns\logDbTarget\console\controllers;

use yii\console\Controller;
use yiisns\logDbTarget\models\LogDbTargetModel;

/**
 * 代理登录模块
 *
 * Class AgentsController
 * @package yiisns\kernel\logDbTarget\console\controllers
 */
class AgentsController extends Controller
{
    /**
     * 查看创建的数据库备份
     */
    public function actionClearLogs()
    {
        $deleted = LogDbTargetModel::deleteAll([
            '<=', 'log_time', \Yii::$app->formatter->asTimestamp(time()) - (int) \Yii::$app->logDbTargetSettings->storeLogsTime
        ]);

        \Yii::info(\Yii::t('yiisns/logdb', 'The number of remote logging') . ": " . $deleted);
    }
}