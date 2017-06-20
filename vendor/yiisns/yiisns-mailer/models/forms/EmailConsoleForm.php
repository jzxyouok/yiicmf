<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 12.03.2016
 */
namespace yiisns\mail\models\forms;

use yiisns\kernel\models\User;

use Yii;
use yii\base\Model;

/**
 * Class EmailConsoleForm
 * 
 * @package yiisns\mail\models\forms
 */
class EmailConsoleForm extends Model
{

    public $content;

    public $to;

    public $from;

    public $subject;

    public function attributeLabels()
    {
        return [
            'content' => \Yii::t('yiisns/mail', 'Content'),
            'subject' => \Yii::t('yiisns/mail', 'Subject'),
            'to' => \Yii::t('yiisns/mail', 'To'),
            'from' => \Yii::t('yiisns/mail', 'From')
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['subject','to','from','content'],'required'],
            [['subject','to','from','content'],'string'],
            [['to','from'],'email']
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function execute()
    {
        if ($this->validate()) {
            $message = \Yii::$app->mailer->compose('@yiisns/mail/templates/test', [
                'content' => $this->content
            ])
                ->setFrom([
                $this->from => \Yii::$app->appSettings->appName
            ])
                ->setTo($this->to)
                ->setSubject($this->subject . ' ' . \Yii::$app->appSettings->appName);
            
            return $message->send();
        } else {
            return false;
        }
    }
}