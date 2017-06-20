<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 17.04.2016
 */
namespace yiisns\mail;

use yiisns\kernel\base\Component;

use yii\helpers\ArrayHelper;
use yii\validators\EmailValidator;
use yii\widgets\ActiveForm;

/**
 * Class MailerSettings
 * @package yiisns\mail
 */
class MailerSettings extends Component
{
    /**
     * @var string Email A comma or address list that will duplicate all outgoing messages.
     */
    public $notifyEmailsHidden     = '';

    /**
     * @var string E-Mail A comma or address list that will duplicate all outgoing messages.
     */
    public $notifyEmails           = '';



    static public function descriptorConfig()
    {
        return ArrayHelper::merge(parent::descriptorConfig(), [
            'name' => \Yii::t('yiisns/mail', 'Mailer')
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [

            [['notifyEmailsHidden'], 'string'],
            [['notifyEmails'], 'string'],

            [['notifyEmailsHidden'], function($attribute)
            {
                if ($emails = explode(',', $this->notifyEmailsHidden))
                {
                    foreach ($emails as $email)
                    {
                        $validator = new EmailValidator();

                        if (!$validator->validate($email, $error))
                        {
                            $this->addError($attribute, $email . ' — ' . \Yii::t('yiisns/mail', 'Incorrect email address'));
                            return false;
                        }
                    }
                }

            }],

            [['notifyEmails'], function($attribute)
            {
                if ($emails = explode(',', $this->notifyEmails))
                {
                    foreach ($emails as $email)
                    {
                        $validator = new EmailValidator();

                        if (!$validator->validate($email, $error))
                        {
                            $this->addError($attribute, $email . ' — ' . \Yii::t('yiisns/mail', 'Incorrect email address'));
                            return false;
                        }
                    }
                }

            }],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'notifyEmails'              => \Yii::t('yiisns/mail', 'Duplicate all sent letters'),
            'notifyEmailsHidden'        => \Yii::t('yiisns/mail', 'Duplicate all sent letters as hidden'),
        ]);
    }

    public function renderConfigForm(ActiveForm $form)
    {
        echo $form->field($this, 'notifyEmails')->textarea();
        echo $form->field($this, 'notifyEmailsHidden')->textarea();
    }
}