<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.04.2016
 */
namespace yiisns\search\models;

use yiisns\kernel\models\behaviors\SerializeBehavior;
use yiisns\kernel\models\Site;

use yii\helpers\ArrayHelper;
use yii\web\Request;

/**
 * This is the model class for table "{{%search_phrase}}".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $phrase
 * @property integer $result_count
 * @property integer $pages
 * @property string $ip
 * @property string $site_code
 * @property string $data_server
 * @property string $data_session
 * @property string $data_cookie
 * @property string $data_request
 * @property string $session_id
 *
 * @property Site $site
 */
class SearchPhrase extends \yiisns\kernel\models\Core
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%search_phrase}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [

            SerializeBehavior::className() =>
            [
                'class' => SerializeBehavior::className(),
                'fields' => ['data_server', 'data_session', 'data_cookie', 'data_request']
            ],

        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'result_count', 'pages'], 'integer'],
            [['data_server', 'data_session', 'data_cookie', 'data_request'], 'string'],
            [['phrase'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 32],
            [['site_code'], 'string', 'max' => 15],
            ['data_request', 'default', 'value' => $_REQUEST],
            ['data_server', 'default', 'value' => $_SERVER],
            ['data_cookie', 'default', 'value' => $_COOKIE],
            ['data_session', 'default', 'value' => function(self $model, $attribute)
            {
                \Yii::$app->session->open();
                return $_SESSION;
            }],
            ['session_id', 'default', 'value' => function(self $model, $attribute)
            {
                \Yii::$app->session->open();
                return \Yii::$app->session->id;
            }],

            [['site_code'], 'default', 'value' => function(self $model, $attribute)
            {
                if (\Yii::$app->appSettings->site)
                {
                    return \Yii::$app->appSettings->site->code;
                }

                return null;
            }],

            ['ip', 'default', 'value' => \Yii::$app->request->userIP],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => \Yii::t('yiisns/search', 'ID'),
            'session_id' => \Yii::t('yiisns/search', 'Session ID'),
            'created_by' => \Yii::t('yiisns/search', 'Created By'),
            'updated_by' => \Yii::t('yiisns/search', 'Updated By'),
            'created_at' => \Yii::t('yiisns/search', 'Created At'),
            'updated_at' => \Yii::t('yiisns/search', 'Updated At'),
            'phrase' => \Yii::t('yiisns/search', 'Search Phrase'),
            'result_count' => \Yii::t('yiisns/search', 'Documents Found'),
            'pages' => \Yii::t('yiisns/search', 'Pages Count'),
            'ip' => \Yii::t('yiisns/search', 'Ip'),
            'site_code' => \Yii::t('yiisns/search', 'Site'),
            'data_server' => \Yii::t('yiisns/search', 'Data Server'),
            'data_session' => \Yii::t('yiisns/search', 'Data Session'),
            'data_cookie' => \Yii::t('yiisns/search', 'Data Cookie'),
            'data_request' => \Yii::t('yiisns/search', 'Data Request'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSite()
    {
        return $this->hasOne(Site::className(), ['code' => 'site_code']);
    }
}