<?php
/**
 * SignupForm
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.10.2016
 * @since 1.0.0
 */

namespace yiisns\kernel\models\forms;

use yiisns\kernel\models\UserEmail;
use yiisns\kernel\models\User;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class SignupForm
 * @package yiisns\kernel\models\forms
 */
class SignupForm extends Model
{
    const SCENARION_FULLINFO    = 'fullInfo';
    const SCENARION_ONLYEMAIL   = 'onlyEmail';

    public $username;
    public $email;
    public $password;

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username'      => \Yii::t('yiisns/kernel', 'Login'),
            'email'         => \Yii::t('yiisns/kernel', 'Email'),
            'password'      => \Yii::t('yiisns/kernel', 'Password'),
        ];
    }

    public function scenarios()
    {
        $scenarions = parent::scenarios();

        $scenarions[self::SCENARION_FULLINFO] = [
            'username', 'email', 'password'
        ];

        $scenarions[self::SCENARION_ONLYEMAIL] = [
            'email'
        ];

        return $scenarions;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => \Yii::$app->user->identityClass, 'message' => \Yii::t('yiisns/kernel','This login is already in use by another user.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => \Yii::$app->user->identityClass, 'message' => \Yii::t('yiisns/kernel', 'This Email is already in use by another user')],

            //[['email'], 'unique', 'targetClass' => UserEmail::className(), 'targetAttribute' => 'value'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate())
        {
            /**
             * @var User $user
             */
            $userClassName = \Yii::$app->user->identityClass;
            $user = new $userClassName();

            if ($this->scenario == self::SCENARION_FULLINFO)
            {
                $user->username = $this->username;
                $user->email = $this->email;
                $user->setPassword($this->password);
                $user->generateAuthKey();
                $user->save();

                return $user;

            } else if ($this->scenario == self::SCENARION_ONLYEMAIL) {

                $password = \Yii::$app->security->generateRandomString(6);

                $user->generateUsername();
                $user->setPassword($password);
                $user->email = $this->email;
                $user->generateAuthKey();

                if ($user->save())
                {
                    \Yii::$app->mailer->view->theme->pathMap = ArrayHelper::merge(\Yii::$app->mailer->view->theme->pathMap, [
                        '@app/mail' =>
                        [
                            '@yiisns/apps/mail-templates'
                        ]
                    ]);

                    \Yii::$app->mailer->compose('@app/mail/register-by-email', [
                        'user'      => $user,
                        'password'  => $password
                    ])
                        ->setFrom([\Yii::$app->appSettings->adminEmail => \Yii::$app->appSettings->appName . ''])
                        ->setTo($user->email)
                        ->setSubject(\Yii::t('yiisns/kernel', 'Sign up at site') . \Yii::$app->appSettings->appName)
                        ->send();

                    return $user;
                } else
                {
                    \Yii::error("User rgister by email error: {$user->username} " . Json::encode($user->getFirstErrors()), 'RegisterError');
                    return null;
                }
            }

        }


        return null;
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */

        if ($user = User::findByEmail($this->email))
        {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {

                \Yii::$app->mailer->view->theme->pathMap = ArrayHelper::merge(\Yii::$app->mailer->view->theme->pathMap, [
                    '@app/mail' =>
                    [
                        '@yiisns/apps/mail'
                    ]
                ]);

                return \Yii::$app->mailer->compose('@app/mail/password-reset-token', ['user' => $user])
                    ->setFrom([\Yii::$app->appSettings->adminEmail => \Yii::$app->appSettings->appName . ' robot'])
                    ->setTo($this->email)
                    ->setSubject(\Yii::t('yiisns/kernel','Password reset for ') . \Yii::$app->appSettings->appName)
                    ->send();
            }
        }
        return false;
    }
}