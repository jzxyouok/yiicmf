<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.07.2016
 */
namespace yiisns\agent\models;

use yiisns\kerne\base\AppCore;
use yiisns\kernel\query\ActiveQuery;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%agent}}".
 *
 * @property integer $id
 * @property integer $last_exec_at
 * @property integer $next_exec_at
 * @property string $name
 * @property string $description
 * @property integer $agent_interval
 * @property integer $priority
 * @property string $active
 * @property string $is_period
 * @property string $is_running
 */
class Agent extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%agent}}';
    }

    /**
     * @return ActiveQuery
     */
    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['last_exec_at', 'next_exec_at', 'agent_interval', 'priority'], 'integer'],
            [['name'], 'required'],
            [['description'], 'string'],
            [['name'], 'string'],
            [['active', 'is_period', 'is_running'], 'string', 'max' => 1],
            [['active', 'is_period', 'is_running'], 'in', 'range' => array_keys(\Yii::$app->appCore->booleanFormat())],
            [['active'], 'default', 'value' => 'Y'],
            [['is_period'], 'default', 'value' => 'N'],
            [['is_running'], 'default', 'value' => 'N'],
            [['agent_interval'], 'default', 'value' => 86400],
            [['priority'], 'default', 'value' => 100],
            [['next_exec_at'], 'default', 'value' => function(self $model)
            {
                return \Yii::$app->formatter->asTimestamp(time()) + (int) $model->agent_interval;
            }],
            [['last_exec_at'], 'default', 'value' => function(self $model)
            {
                return \Yii::$app->formatter->asTimestamp(time());
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('yiisns/agent', 'ID'),
            'last_exec_at' => \Yii::t('yiisns/agent', 'Last Execution At'),
            'next_exec_at' => \Yii::t('yiisns/agent', 'Next Execution At'),
            'name' => \Yii::t('yiisns/agent', "Agent's Function"),
            'agent_interval' => \Yii::t('yiisns/agent', 'Interval (sec)'),
            'priority' => \Yii::t('yiisns/agent', 'Priority'),
            'active' => \Yii::t('yiisns/agent', 'Active'),
            'is_period' => \Yii::t('yiisns/agent', 'Periodic'),
            'is_running' => \Yii::t('yiisns/agent', 'Is Running'),
            'description' => \Yii::t('yiisns/agent', 'Description'),
        ];
    }


    /**
     * @return bool
     */
    public function stop()
    {
        $this->is_running   = AppCore::BOOL_N;
        $this->next_exec_at = \Yii::$app->formatter->asTimestamp(time()) + (int) $this->agent_interval;
        $this->last_exec_at = \Yii::$app->formatter->asTimestamp(time());
        return $this->save();
    }

    /**
     * Stop long executable agents
     *
     * @return int
     */
    static public function stopLongExecutable($agentMaxExecuteTime = null)
    {
        if ($agentMaxExecuteTime === null)
        {
            $agentMaxExecuteTime = \Yii::$app->agent->agentMaxExecuteTime;
        }

        $time = \Yii::$app->formatter->asTimestamp(time()) - (int) $agentMaxExecuteTime;

        $running = static::find()
            ->where([
                'is_running' => AppCore::BOOL_Y
            ])
            ->orderBy('priority')
            ->all();
        ;

        $stoping = 0;

        if ($running)
        {
            /**
             * @var $agent agent
             */
            foreach ($running as $agent)
            {
                if ($agent->next_exec_at <= $time)
                {
                    if ($agent->stop())
                    {
                        $stoping ++;
                    } else
                    {
                        \Yii::error('Not stopped long agent: ' . $agent->name, 'yiisns/agent');
                    }
                }
            }
        }

        return $stoping;
    }

    /**
     *
     * @return ActiveQuery
     */
    static public function findForExecute()
    {
        return static::find()->active()
            ->andWhere([
                'is_running' => AppCore::BOOL_N
            ])
            ->andWhere([
                '<=', 'next_exec_at', \Yii::$app->formatter->asTimestamp(time())
            ])->orderBy('priority')
        ;
    }
}