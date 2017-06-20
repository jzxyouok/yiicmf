<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.07.2016
 */
namespace yiisns\logDbTarget;

use yiisns\kernel\base\AppCore;
use yii\log\DbTarget;

/**
 * Class LogDbTarget
 * @package yiisns\logDbTarget
 */
class LogDbTarget extends DbTarget
{
    public $logTable = '{{%log_db_target}}';

    public function init()
    {
        parent::init();

        $this->logVars = \Yii::$app->logDbTargetSettings->logVars ? (array) \Yii::$app->logDbTargetSettings->logVars : [];
        $this->levels = (array) \Yii::$app->logDbTargetSettings->getSafeLevels();
        $this->except = (array) \Yii::$app->logDbTargetSettings->getExcept();
        $this->categories = (array) \Yii::$app->logDbTargetSettings->getCategories();
        $this->enabled = (bool) (\Yii::$app->logDbTargetSettings->enabled == AppCore::BOOL_Y);
        $this->exportInterval = (int) \Yii::$app->logDbTargetSettings->exportInterval;
    }
}