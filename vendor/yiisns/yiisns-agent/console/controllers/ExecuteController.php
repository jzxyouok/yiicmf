<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 17.04.2016
 */
namespace yiisns\agent\console\controllers;

use yiisns\agent\models\Agent as AgentModle;
use yiisns\kernel\base\AppCore;
use yiisns\apps\helpers\StringHelper;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class ExecuteController
 * 
 * @package yiisns\kernel\console\controllers
 */
class ExecuteController extends Controller
{
    /**
     * Execute agents
     */
    public function actionIndex()
    {
        $stoppedLong = AgentModle::stopLongExecutable();
        if ($stoppedLong > 0) {
            \Yii::warning('Agents stopped: ' . count($stoppedLong), 'yiisns/agent');
        }
        
        $agents = AgentModle::findForExecute()->all();
        
        \Yii::info('Agents execute: ' . count($agents), 'yiisns/agent::total');
        $this->stdout('Agents execute: ' . count($agents) . "\n", Console::BOLD);
        
        if ($agents) {
            foreach ($agents as $agent) {
                $this->_executeAgent($agent);
            }
        }
    }

    /**
     * 执行代理
     *
     * @return $this
     */
    protected function _executeAgent(Agent $gent)
    {
        if ($agent->is_running == AppCore::BOOL_Y) {
            $this->stdout('Agent is already running: ' . $agent->name, Console::BOLD);
            return $this;
        }
        
        $agent->is_running = AppCore::BOOL_Y;
        $agent->save();
        
        $timeStart = $this->_microtimeFloat();
        
        $this->stdout("------------------------------\n");
        $this->stdout(" > {$agent->name}\n");
        $result = \Yii::$app->console->execute("cd " . ROOT_DIR . "; php yii " . $agent->name);
        $this->stdout($result . "\n");
        
        $time = $this->_microtimeFloat() - $timeStart;
        
        $this->stdout("Lead time > {$time} sec\n");
        $this->stdout("------------------------------\n");
        
        $result = $this->_getShortResultContent($result);
        
        \Yii::info("Execute agent > {$agent->name}\n{$result}\nLead time > {$time} sec", 'yiisns/agent::' . $agent->name);
        
        $agent->stop();
        
        return $this;
    }

    /**
     *
     * @param string $result            
     * @return string
     */
    protected function _getShortResultContent($result = '')
    {
        if (StringHelper::strlen($result) > 10000) {
            $totalLenght = StringHelper::strlen($result);
            $newResult = '';
            $newResult .= StringHelper::substr($result, 0, 5000);
            $newResult .= "\n\n..............\n\n........ Total lenght: {$totalLenght}  ........\n\n..............\n\n";
            $newResult .= StringHelper::substr($result, ($totalLenght - 3000), $totalLenght);
            
            return $newResult;
        } else {
            return $result;
        }
    }

    protected function _microtimeFloat()
    {
        list ($usec, $sec) = explode(" ", microtime());
        return ((float) $usec + (float) $sec);
    }
}