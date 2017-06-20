<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.06.2016
 */
namespace yiisns\form2\models;

use yiisns\kernel\models\behaviors\HasRelatedPropertiesBehavior;
use yiisns\kernel\models\behaviors\ImplodeBehavior;
use yiisns\kernel\models\behaviors\SerializeBehavior;
use yiisns\kernel\models\behaviors\traits\HasRelatedPropertiesTrait;
use yiisns\kernel\models\Site;
use yiisns\kernel\models\Core;
use yiisns\kernel\models\User;
use yiisns\kernel\relatedProperties\models\RelatedElementModel;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "{{%form2_form_send}}".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer processed_at
 * @property integer $processed_by
 * @property string $data_values
 * @property string $data_labels
 * @property string $emails
 * @property string $site_code
 * @property string $comment
 * @property string $phones
 * @property string $user_ids
 * @property string $email_message
 * @property string $phone_message
 * @property integer $status
 * @property integer $form_id
 * @property string $ip
 * @property string $page_url
 * @property string $data_server
 * @property string $data_session
 * @property string $data_cookie
 * @property string $data_request
 * @property string $additional_data
 *
 * @property User $processedBy
 * @property Form2Form $form
 *
 * @property Form2FormSendProperty[]    relatedElementProperties
 * @property Form2FormProperty[]        relatedProperties
 * @property Site                    $site
 */
class Form2FormSend extends RelatedElementModel
{
    const STATUS_NEW        = 0;
    const STATUS_PROCESSED  = 5;
    const STATUS_EXECUTED   = 10;

    static public function getStatuses()
    {
        return [
            self::STATUS_NEW          => \Yii::t('yiisns/form2', 'New message'),
            self::STATUS_PROCESSED    => \Yii::t('yiisns/form2', 'In progress'),
            self::STATUS_EXECUTED     => \Yii::t('yiisns/form2', 'Completed'),
        ];
    }


    use HasRelatedPropertiesTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%form2_form_send}}';
    }


    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [

            HasRelatedPropertiesBehavior::className() =>
            [
                'class'                             => HasRelatedPropertiesBehavior::className(),
                'relatedElementPropertyClassName'   => Form2FormSendProperty::className(),
                'relatedPropertyClassName'          => Form2FormProperty::className(),
            ],

            SerializeBehavior::className() =>
            [
                'class' => SerializeBehavior::className(),
                'fields' => ['data_labels', 'data_values', 'data_server', 'data_session', 'data_cookie', 'additional_data', 'data_request']
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'processed_by', 'processed_at', 'status', 'form_id'], 'integer'],
            [['email_message', 'phone_message', 'site_code'], 'string'],
            [['data_labels', 'data_values', 'data_server', 'data_session', 'data_cookie', 'additional_data', 'data_request'], 'safe'],
            [['emails', 'phones', 'user_ids'], 'string'],
            [['ip'], 'string', 'max' => 32],
            [['page_url'], 'string', 'max' => 500],
            [['comment'], 'string'],
            [['status'], 'in', 'range' => array_keys(self::getStatuses())],

            ['data_request', 'default', 'value' => function(self $model, $attribute)
            {
                return $_REQUEST;
            }],

            ['data_server', 'default', 'value' => function(self $model, $attribute)
            {
                return $_SERVER;
            }],

            ['data_cookie', 'default', 'value' => function(self $model, $attribute)
            {
                return $_COOKIE;
            }],

            ['data_session', 'default', 'value' => function(self $model, $attribute)
            {
                \Yii::$app->session->open();
                return $_SESSION;
            }],

            ['ip', 'default', 'value' => function(self $model, $attribute)
            {
                return \Yii::$app->request->userIP;
            }],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => \Yii::t('yiisns/form2', 'ID'),
            'created_by' => \Yii::t('yiisns/form2', 'Created By'),
            'updated_by' => \Yii::t('yiisns/form2', 'Updated By'),
            'created_at' => \Yii::t('yiisns/form2', 'Created At'),
            'updated_at' => \Yii::t('yiisns/form2', 'Updated At'),
            'processed_by' => \Yii::t('yiisns/form2', 'Who handled'),
            'data_values' => \Yii::t('yiisns/form2', 'Data Values'),
            'data_labels' => \Yii::t('yiisns/form2', 'Data Labels'),
            'emails' => \Yii::t('yiisns/form2', 'Emails'),
            'phones' => \Yii::t('yiisns/form2', 'Phones'),
            'user_ids' => \Yii::t('yiisns/form2', 'User Ids'),
            'email_message' => \Yii::t('yiisns/form2', 'Email Message'),
            'phone_message' => \Yii::t('yiisns/form2', 'Phone Message'),
            'status' => \Yii::t('yiisns/form2', 'Status'),
            'form_id' => \Yii::t('yiisns/form2', 'Form'),
            'ip' => \Yii::t('yiisns/form2', 'Ip'),
            'page_url' => \Yii::t('yiisns/form2', 'Page Url'),
            'data_server' => \Yii::t('yiisns/form2', 'Data Server'),
            'data_session' => \Yii::t('yiisns/form2', 'Data Session'),
            'data_cookie' => \Yii::t('yiisns/form2', 'Data Cookie'),
            'data_request' => \Yii::t('yiisns/form2', 'Data Request'),
            'additional_data' => \Yii::t('yiisns/form2', 'Additional Data'),
            'site_code' => \Yii::t('yiisns/form2', 'Site'),
            'processed_at' => \Yii::t('yiisns/form2', 'When handled'),
            'comment' => \Yii::t('yiisns/form2', 'Comment'),
        ]);
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'processed_by']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(Form2Form::className(), ['id' => 'form_id']);
    }

    /**
     * @return Site
     */
    public function getSite()
    {
        //return $this->hasOne(Site::className(), ['code' => 'site_code']);
        return Site::getByCode($this->site_code);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getRelatedProperties()
    {
        //return $this->form->form2FormProperties;
        return $this->hasMany(Form2FormProperty::className(), ['form_id' => 'id'])
                    ->via('form')->orderBy(['priority' => SORT_ASC]);
    }


    /**
     * @return array
     */
    public function getEmailsAsArray()
    {
        $emailsAll = [];
        if ($this->emails)
        {
            $emails = explode(',', $this->emails);

            foreach ($emails as $email)
            {
                $emailsAll[] = trim($email);
            }
        }

        return $emailsAll;
    }

    public function notify()
    {
        if ($this->form)
        {
            if ($this->form->emailsAsArray)
            {
                foreach ($this->form->emailsAsArray as $email)
                {
                    \Yii::$app->mailer->compose('@yiisns/form2/mail/send-message', [
                        'form'              => $this->form,
                        'formSend'          => $this
                    ])
                    ->setFrom([\Yii::$app->appSettings->adminEmail => \Yii::$app->appSettings->appName])
                    ->setTo($email)
                    ->setSubject(\Yii::t('yiisns/form2', 'Submitting form') . ": «{$this->form->name}» #" . $this->id)
                    ->send();
                }
            }
        }
    }
}