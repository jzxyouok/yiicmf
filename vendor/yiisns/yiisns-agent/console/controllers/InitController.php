<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 17.04.2016
 */
namespace yiisns\agent\console\controllers;

use yiisns\agent\models\Agent;
use yii\console\Controller;

/**
 * Init agents from config files
 *
 * Class InitController
 * @package yiisns\kernel\agent\console\controllers
 */
class InitController extends Controller
{
    /**
     * Init agents from config files
     */
    public function actionIndex()
    {
        $this->stdout('Agents files: ' . count(\Yii::$app->agent->agentsConfigFiles) . "\n");
        $this->stdout('Agents in files: ' . count(\Yii::$app->agent->agentsConfig) . "\n");

        \Yii::$app->agent->loadAgents();
    }
}