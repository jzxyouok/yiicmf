<?php
/**
 * PasswordResetRequestForm
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.10.2016
 * @since 1.0.0
 */
namespace yiisns\kernel\models\forms;

use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class PasswordResetRequestForm
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $identityClassName = \Yii::$app->user->identityClass;
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => $identityClassName,
                'filter' => ['status' => $identityClassName::STATUS_ACTIVE],
                'message' => \Yii::t('yiisns/kernel','There is no user with such email.')
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {
                \Yii::$app->mailer->view->theme->pathMap = ArrayHelper::merge(\Yii::$app->mailer->view->theme->pathMap, [
                    '@app/mail' =>
                    [
                        '@yiisns/apps/mail-templates'
                    ]
                ]);

                return \Yii::$app->mailer->compose('@app/mail/password-reset-token', ['user' => $user])
                    ->setFrom([\Yii::$app->appSettings->adminEmail => \Yii::$app->appSettings->appName . ' robot'])
                    ->setTo($this->email)
                    ->setSubject(\Yii::t('yiisns/kernel', 'Password reset for ') . \Yii::$app->appSettings->appName)
                    ->send();
            }
        }
        return false;
    }
}