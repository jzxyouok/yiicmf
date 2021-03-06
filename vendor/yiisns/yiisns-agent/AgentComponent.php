<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.04.2016
 */
namespace yiisns\agent;
use yiisns\agent\models\Agent;
use yiisns\apps\helpers\FileHelper;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\web\Application;
use Yii;

/**
 * @property string[] $agentsConfigFiles
 * @property [] $agentsConfig
 *
 * Class AgentComponent
 * @package yiisns\kernel\agent
 */
class AgentComponent extends Component implements BootstrapInterface
{
    /**
     * @var bool Enabled agents on the hits
     */
    public $onHitsEnabled   = true;

    /**
     * @var int Interval if enabled agents on the hits
     */
    public $onHitsInterval  = 60;

    /**
     * @var int Maximum wait time for the agent
     */
    public $agentMaxExecuteTime    = 7200; //2 hours


    public function bootstrap($application)
    {
        if ($application instanceof Application && $this->onHitsEnabled)
        {
            $key = 'Agents';
            Yii::beginProfile(\Yii::t('yiisns/agent', 'Agents enabled on the hits'));

                $data = \Yii::$app->cache->get($key);
                if ($data === false)
                {
                    Yii::beginProfile(\Yii::t('yiisns/agent', 'Executing'));

                        $result = \Yii::$app->console->execute("cd " . ROOT_DIR . '; php yii agent/execute;');
                        \Yii::$app->cache->set($key, '1', (int) $this->onHitsInterval);

                    Yii::endProfile(\Yii::t('yiisns/agent', 'Executing'));
                }

            Yii::endProfile(\Yii::t('yiisns/agent', 'Agents enabled on the hits'));
        }
    }

    /**
     * @return array
     */
    public function getAgentsConfig()
    {
        $result = [];
        foreach ($this->agentsConfigFiles as $filePath)
        {
            $fileData = (array) include $filePath;
            $result = \yii\helpers\ArrayHelper::merge($result, $fileData);
        }

        return (array) $result;
    }

    /**
     * @return array
     */
    public function getAgentsConfigFiles()
    {
        $files = FileHelper::findExtensionsFiles(['/config/agents.php']);
        $files = array_unique(array_merge(
            [
                \Yii::getAlias('@app/config/agents.php'),
                \Yii::getAlias('@common/config/agents.php'),
            ], $files
        ));

        $result = [];
        foreach ($files as $file)
        {
            if (file_exists($file))
            {
                $result[] = $file;
            }
        }

        return $result;
    }

    /**
     * @return $this
     */
    public function loadAgents()
    {
        if ($this->agentsConfig)
        {
            foreach ($this->agentsConfig as $exec => $data)
            {
                if (Agent::find()->where(['name' => $exec])->one())
                {
                    continue;
                }

                $agent = new Agent();
                $agent->name = $exec;
                $agent->agent_interval = ArrayHelper::getValue($data, 'agent_interval');
                $agent->is_period = ArrayHelper::getValue($data, 'is_period');
                $agent->description = ArrayHelper::getValue($data, 'description');
                $agent->save();
            }
        }

        return $this;
    }
}