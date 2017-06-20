<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 16.07.2016
 */
namespace yiisns\LogDbTarget\components;

use yiisns\kernel\base\Component;
use yiisns\kernel\base\AppCore;
use yiisns\kernel\models\Agent;
use yii\base\Event;
use yii\console\Application;
use yii\helpers\ArrayHelper;
//use yii\log\Logger;
use yii\widgets\ActiveForm;

/**
 * Class LogDbTargetSettings
 * @package yiisns\kernel\LogDbTarget\components
 */
class LogDbTargetSettings extends Component
{
    /**
     * @var array 错误等级
     */
    static public $levelMap = [
        'error'     => 'error',
        'warning'   => 'warning',
        'info'      => 'info',
        'trace'     => 'trace',
        'profile'   => 'profile',
    ];

    /**
     * //'_GET', '_POST', '_FILES', '_COOKIE', '_SESSION', '_SERVER'
     * @var array
     */
    public $logVars = [];
    /**
     * @var array
     */
    public $levels = [
        'error',
        'warning'
    ];

    /**
     * @var string
     */
    public $exceptString = 'yii\db\Command*,yii\web\Session*,yii\db\Connection*';
    /**
     * @var string
     */
    public $categoriesString  = '';

    /**
     * @var string
     */
    public $enabled = AppCore::BOOL_Y;

    /**
     * @var int
     */
    public $exportInterval = 9999999999;

    /**
     * @var int 日志保存时间
     */
    public $storeLogsTime = '3600 * 24 * 5'; 
    
    /**
     * 指定组件的名称和说明
     *
     * @return array
     */
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => \Yii::t('yiisns/logdb', 'Logging errors in the mysql database'),
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['levels'], 'safe'],
            [['logVars'], 'safe'],
            [['exceptString'], 'string'],
            [['categoriesString'], 'string'],
            [['enabled'], 'string'],
            [['storeLogsTime'], 'integer'],
            [['exportInterval'], 'integer'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'levels'                    => \Yii::t('yiisns/logdb', 'Error levels'),
            'logVars'                   => \Yii::t('yiisns/logdb', 'Additional information for logging'),
            'exceptString'              => \Yii::t('yiisns/logdb', 'Not logging'),
            'categoriesString'          => \Yii::t('yiisns/logdb', 'Logging only categies'),
            'enabled'                   => \Yii::t('yiisns/logdb', 'On or off'),
            'storeLogsTime'             => \Yii::t('yiisns/logdb', 'Time storage of logs (sec.)'),
            'exportInterval'            => \Yii::t('yiisns/logdb', 'How many messages should be accumulated before they are exported'),
        ]);
    }


    public function renderConfigForm(ActiveForm $form)
    {
        echo \Yii::$app->view->renderFile(__DIR__ . '/_form.php', [
            'form'  => $form,
            'model' => $this
        ], $this);
    }

    /**
     * @return array
     */
    public function getSafeLevels()
    {
        $result = [];
        foreach ($this->levels as $key => $level)
        {
            if (in_array($level, self::$levelMap))
            {
                $result[$key] = $level;
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getExcept()
    {
        $result = [];

        if ($this->exceptString)
        {
            return explode(",", $this->exceptString);
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        $result = [];

        if ($this->categoriesString)
        {
            return explode(",", $this->categoriesString);
        }

        return $result;
    }
}