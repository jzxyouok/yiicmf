<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 22.03.2016
 */
namespace yiisns\logDbTarget\console\controllers;

use yiisns\logDbTarget\models\LogDbTargetModel;
use yii\console\Controller;
use yii\helpers\Console;

/**
 *
 * @package yiisns\kernel\logDbTarget\console\controllers
 */
class FlushController extends Controller
{
    /**
     * 清理指定天数之前的日志
     *
     * @param int $countDay 天数
     */
    public function actionLogs($countDay = 5)
    {
        if ($count = LogDbTargetModel::find()->where([
            '<=',
            'log_time',
            time() - 3600 * 24 * $countDay
        ])->count()) {
            $this->stdout("Total logs found: {$count}\n", Console::BOLD);
            $totalDeleted = LogDbTargetModel::deleteAll([
                '<=',
                'log_time',
                time() - 3600 * 24 * $countDay
            ]);
            $this->stdout("Total deleted: {$totalDeleted}\n");
        } else {
            $this->stdout("Nothing to delete\n", Console::BOLD);
        }
    }
}