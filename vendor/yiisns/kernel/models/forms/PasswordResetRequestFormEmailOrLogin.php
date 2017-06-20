<?php
/**
 * PasswordResetRequestFormEmailOrLogin
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 26.02.2016
 */
namespace yiisns\kernel\models\forms;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\User;

/**
 * Class PasswordResetRequestFormEmailOrLogin
 * @package yiisns\kernel\models\forms
 */
class PasswordResetRequestFormEmailOrLogin extends Model
{
    public $identifier;

    /**
     * @var bool
     */
    public $isAdmin = true;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $identityClassName = \Yii::$app->user->identityClass;
        return [
            ['identifier', 'filter', 'filter' => 'trim'],
            ['identifier', 'required'],
            ['identifier', 'validateEdentifier'],
            /*['email', 'exist',
                'targetClass' => $identityClassName,
                'filter' => ['status' => $identityClassName::STATUS_ACTIVE],
                'message' => 'There is no user with such email.'
            ],*/
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'identifier'    => \Yii::t('yiisns/kernel', 'Username or Email'),
        ];
    }

    public function validateEdentifier($attr)
    {
        $identityClassName = \Yii::$app->user->identityClass;
        $user = $identityClassName::findByUsernameOrEmail($this->identifier);

        if (!$user)
        {
            $this->addError($attr, \Yii::t('yiisns/kernel', 'User not found'));
        }
    }
    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user \common\models\User */
        $identityClassName = \Yii::$app->user->identityClass;

        $user = $identityClassName::findByUsernameOrEmail($this->identifier);
        //$user = $identityClassName::

        if ($user)
        {
            if (!$identityClassName::isPasswordResetTokenValid($user->password_reset_token))
            {
                $user->generatePasswordResetToken();
            }

            if ($user->save())
            {
                if (!$user->email)
                {
                    return false;
                }

                if ($this->isAdmin)
                {
                    $resetLink = \yiisns\apps\helpers\UrlHelper::construct('admin/auth/reset-password', ['token' => $user->password_reset_token])->enableAbsolute()->enableAdmin();
                } else
                {
                    $resetLink = \yiisns\apps\helpers\UrlHelper::construct('apps/auth/reset-password', ['token' => $user->password_reset_token])->enableAbsolute();
                }

                \Yii::$app->mailer->view->theme->pathMap = ArrayHelper::merge(\Yii::$app->mailer->view->theme->pathMap, [
                    '@app/mail' =>
                    [
                        '@yiisns/apps/mail-templates'
                    ]
                ]);

                $message = \Yii::$app->mailer->compose('@app/mail/password-reset-token', [
                        'user'      => $user,
                        'resetLink' => $resetLink
                    ])
                    ->setFrom([\Yii::$app->appSettings->adminEmail => \Yii::$app->appSettings->appName])
                    ->setTo($user->email)
                    ->setSubject(\Yii::t('yiisns/kernel', 'The request to change the password for') . \Yii::$app->appSettings->appName);
                return $message->send();
            }
        }
        return false;
    }
}