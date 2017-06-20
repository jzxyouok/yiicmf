<?php
/**
 * User
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.10.2016
 * @since 1.0.0
 */
namespace yiisns\kernel\models;

use Imagine\Image\ManipulatorInterface;
use yiisns\kernel\base\AppCore;
use yiisns\kernel\models\behaviors\HasRelatedPropertiesBehavior;
use yiisns\kernel\models\behaviors\HasStorageFileBehavior;
use yiisns\kernel\models\behaviors\traits\HasRelatedPropertiesTrait;
use yiisns\kernel\validators\PhoneValidator;
use yiisns\kernel\validators\LoginValidator;

use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\validators\EmailValidator;
use yii\validators\UniqueValidator;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name
 * @property integer $image_id
 * @property string $gender
 * @property string $active
 * @property integer $updated_by
 * @property integer $created_by
 * @property integer $logged_at
 * @property integer $last_activity_at
 * @property integer $last_admin_activity_at
 * @property string $email
 * @property string $phone
 * @property integer $email_is_approved
 * @property integer $phone_is_approved
 *
 * @property string $lastActivityAgo
 * @property string $lastAdminActivityAgo
 *
 * @property StorageFile $image
 * @property string $avatarSrc
 * @property string $profileUrl
 *
 * @property UserEmail[] $userEmails
 * @property UserPhone[] $userPhones
 * @property UserAuthClient[] $userAuthClients
 *
 * @property \yii\rbac\Role[] $roles
 * @property [] $roleNames
 *
 * @property string $displayName
 * @property string $profileUrl
 *
 * @property ContentElement2cmsUser[] $contentElement2cmsUsers
 * @property ContentElement[] $favoriteContentElements
 *
 * @method find()
 */
class User extends Core implements IdentityInterface
{
    use HasRelatedPropertiesTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * Logins that cannot be removed, and you can't change
     *
     * @return array
     */
    static public function getProtectedUsernames()
    {
        return [
            'root',
            'admin'
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $this->on(self::EVENT_AFTER_INSERT, [
            $this,
            'afterInsertUpdate'
        ]);
        $this->on(self::EVENT_AFTER_UPDATE, [
            $this,
            'afterInsertUpdate'
        ]);
        
        $this->on(self::EVENT_BEFORE_DELETE, [
            $this,
            'checkDataBeforeDelete'
        ]);
        //var_dump(\Yii::$app->authManager->getRolesByUser(2));
    }

    public function afterInsertUpdate($e)
    {
        if ($this->_roleNames !== null) {
            if ($this->roles) {
                foreach ($this->roles as $roleExist) {
                    if (! in_array($roleExist->name, (array) $this->_roleNames)) {
                        \Yii::$app->authManager->revoke($roleExist, $this->id);
                    }
                }
            }
            
            foreach ((array) $this->_roleNames as $roleName) {
                if ($role = \Yii::$app->authManager->getRole($roleName)) {
                    try {
                        \Yii::$app->authManager->assign($role, $this->id);
                    } catch (\Exception $e) {}
                }
            }
        }
    }

    /**
     *
     * @throws Exception
     */
    public function checkDataBeforeDelete($e)
    {
        if (in_array($this->username, static::getProtectedUsernames())) {
            throw new Exception(\Yii::t('yiisns/kernel', 'This user can not be removed'));
        }
        
        if ($this->id == \Yii::$app->user->identity->id) {
            throw new Exception(\Yii::t('yiisns/kernel', 'You can not delete yourself'));
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            
            TimestampBehavior::className(),
            
            HasStorageFileBehavior::className() => [
                'class' => HasStorageFileBehavior::className(),
                'fields' => [
                    'image_id'
                ]
            ],
            
            HasRelatedPropertiesBehavior::className() => [
                'class' => HasRelatedPropertiesBehavior::className(),
                'relatedElementPropertyClassName' => UserProperty::className(),
                'relatedPropertyClassName' => UserUniversalProperty::className()
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                'active',
                'default',
                'value' => AppCore::BOOL_Y
            ],
            [
                'gender',
                'default',
                'value' => 'men'
            ],
            [
                'gender',
                'in',
                'range' => [
                    'men',
                    'women'
                ]
            ],
            
            [
                [
                    'created_at',
                    'updated_at',
                    'email_is_approved',
                    'phone_is_approved'
                ],
                'integer'
            ],
            
            [
                [
                    'image_id'
                ],
                'safe'
            ],
            [
                [
                    'gender'
                ],
                'string'
            ],
            [
                [
                    'username',
                    'password_hash',
                    'password_reset_token',
                    'email',
                    'name'
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'auth_key'
                ],
                'string',
                'max' => 32
            ],
            
            [
                [
                    'phone'
                ],
                'string',
                'max' => 64
            ],
            [
                [
                    'phone'
                ],
                PhoneValidator::className()
            ],
            [
                [
                    'phone'
                ],
                'unique'
            ],
            [
                [
                    'phone',
                    'email'
                ],
                'default',
                'value' => null
            ],
            
            [
                [
                    'email'
                ],
                'unique'
            ],
            [
                [
                    'email'
                ],
                'email'
            ],
            
            // [['username'], 'required'],
            [
                'username',
                'string',
                'min' => 4,
                'max' => 25
            ],
            [
                [
                    'username'
                ],
                'unique'
            ],
            [
                [
                    'username'
                ],
                LoginValidator::className()
            ],
            
            [
                [
                    'logged_at'
                ],
                'integer'
            ],
            [
                [
                    'last_activity_at'
                ],
                'integer'
            ],
            [
                [
                    'last_admin_activity_at'
                ],
                'integer'
            ],
            
            [
                [
                    'username'
                ],
                'default',
                'value' => function (self $model) {
                    $userLast = static::find()->orderBy('id DESC')->one();
                    return 'id' . ($userLast->id + 1);
                }
            ],
            
            [
                [
                    'email_is_approved',
                    'phone_is_approved'
                ],
                'default',
                'value' => 0
            ],
            
            [
                [
                    'auth_key'
                ],
                'default',
                'value' => function (self $model) {
                    return \Yii::$app->security->generateRandomString();
                }
            ],
            
            [
                [
                    'password_hash'
                ],
                'default',
                'value' => function (self $model) {
                    return \Yii::$app->security->generatePasswordHash(\Yii::$app->security->generateRandomString());
                }
            ],
            
            [
                [
                    'roleNames'
                ],
                'safe'
            ],
            [
                [
                    'roleNames'
                ],
                'default',
                'value' => \Yii::$app->appSettings->registerRoles
            ]
        ];
    }

    public function extraFields()
    {
        return [
            'displayName'
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('yiisns/kernel', 'ID'),
            'username' => \Yii::t('yiisns/kernel', 'Login'),
            'auth_key' => \Yii::t('yiisns/kernel', 'Auth Key'),
            'password_hash' => \Yii::t('yiisns/kernel', 'Password Hash'),
            'password_reset_token' => \Yii::t('yiisns/kernel', 'Password Reset Token'),
            'email' => \Yii::t('yiisns/kernel', 'Email'),
            'phone' => \Yii::t('yiisns/kernel', 'Phone'),
            'active' => \Yii::t('yiisns/kernel', 'Active'),
            'created_at' => \Yii::t('yiisns/kernel', 'Created At'),
            'updated_at' => \Yii::t('yiisns/kernel', 'Updated At'),
            'name' => \Yii::t('yiisns/kernel', 'Name'),
            'gender' => \Yii::t('yiisns/kernel', 'Gender'),
            'logged_at' => \Yii::t('yiisns/kernel', 'Logged At'),
            'last_activity_at' => \Yii::t('yiisns/kernel', 'Last Activity At'),
            'last_admin_activity_at' => \Yii::t('yiisns/kernel', 'Last Activity In The Admin At'),
            'image_id' => \Yii::t('yiisns/kernel', 'image'),
            'roleNames' => \Yii::t('yiisns/kernel', 'Role groups'),
            'email_is_approved' => \Yii::t('yiisns/kernel', 'Email is approved'),
            'phone_is_approved' => \Yii::t('yiisns/kernel', 'Phone is approved')
        ];
    }

    /**
     *
     * @return $this
     */
    public function lockAdmin()
    {
        $this->last_admin_activity_at = \Yii::$app->formatter->asTimestamp(time()) - (\Yii::$app->admin->blockedTime + 1);
        $this->save(false);
        
        return $this;
    }

    /**
     * the time of the last activity on the site.
     *
     * @return int
     */
    public function getLastAdminActivityAgo()
    {
        $now = \Yii::$app->formatter->asTimestamp(time());
        return (int) ($now - (int) $this->last_admin_activity_at);
    }

    /**
     *
     * @return $this
     */
    public function updateLastAdminActivity()
    {
        $now = \Yii::$app->formatter->asTimestamp(time());
        
        if (! $this->lastAdminActivityAgo || $this->lastAdminActivityAgo > 10) {
            $this->last_activity_at = $now;
            $this->last_admin_activity_at = $now;
            
            $this->save(false);
        }
        
        return $this;
    }

    /**
     *
     * @return int
     */
    public function getLastActivityAgo()
    {
        $now = \Yii::$app->formatter->asTimestamp(time());
        return (int) ($now - (int) $this->last_activity_at);
    }

    /**
     *
     * @return $this
     */
    public function updateLastActivity()
    {
        $now = \Yii::$app->formatter->asTimestamp(time());
        
        if (! $this->lastActivityAgo || $this->lastActivityAgo > 10) {
            $this->last_activity_at = $now;
            $this->save(false);
        }
        
        return $this;
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(StorageFile::className(), [
            'id' => 'image_id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStorageFiles()
    {
        return $this->hasMany(StorageFile::className(), [
            'created_by' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAuthClients()
    {
        return $this->hasMany(UserAuthClient::className(), [
            'user_id' => 'id'
        ]);
    }

    /**
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->name ? $this->name : $this->username;
    }

    /**
     *
     * @param string $action            
     * @param array $params            
     * @return string
     */
    public function getPageUrl($action = 'view', $params = [])
    {
        return $this->getProfileUrl($action, $params);
    }

    /**
     *
     * @param string $action            
     * @param array $params            
     * @return string
     */
    public function getProfileUrl($action = 'view', $params = [])
    {
        $params = ArrayHelper::merge([
            'apps/user/' . $action,
            'username' => $this->username
        ], $params);
        
        return \Yii::$app->urlManager->createUrl($params);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id,
            'active' => AppCore::BOOL_Y
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException(\Yii::t('yiisns/kernel', '"findIdentityByAccessToken" is not implemented.'));
    }

    /**
     * Finds user by username
     *
     * @param string $username            
     * @return static
     */
    public static function findByUsername($username)
    {
        return static::findOne([
            'username' => $username,
            'active' => AppCore::BOOL_Y
        ]);
    }

    /**
     * Finds user by email
     *
     * @param $email
     * @return static
     */
    public static function findByEmail($email)
    {
        return static::findOne([
            'email' => $email,
            'active' => AppCore::BOOL_Y
        ]);
    }

    /**
     *
     * @param $phone
     * @return null|User
     */
    public static function findByPhone($phone)
    {
        return static::findOne([
            'phone' => $phone,
            'active' => AppCore::BOOL_Y
        ]);
        
        return null;
    }

    /**
     *
     * @param $value
     * @return User
     */
    static public function findByUsernameOrEmail($value)
    {
        if ($user = static::findByUsername($value)) {
            return $user;
        }
        
        if ($user = static::findByEmail($value)) {
            return $user;
        }
        
        return null;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (! static::isPasswordResetTokenValid($token)) {
            return null;
        }
        
        return static::findOne([
            'password_reset_token' => $token,
            'active' => AppCore::BOOL_Y
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$appSettings->passwordResetTokenExpire;
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @var fill in the missing data, which are necessary for the preservation of user.
     *
     * @return $this
     */
    public function populate()
    {
        $password = \Yii::$app->security->generateRandomString(6);
        
        $this->generateUsername();
        $this->setPassword($password);
        $this->generateAuthKey();
        
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password  password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password            
     */
    public function setPassword($password)
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }

    /**
     *
     * @return $this
     */
    public function generateUsername()
    {
        /*
         * if ($this->email)
         * {
         * $userName = \yiisns\apps\helpers\StringHelper::substr($this->email, 0, strpos() );
         * }
         */
        $userLast = static::find()->orderBy('id DESC')->one();
        $this->username = 'id' . ($userLast->id + 1);
        
        if (static::find()->where([
            'username' => $this->username
        ])->one()) {
            $this->username = $this->username . '_' . \yiisns\apps\helpers\StringHelper::substr(md5(time()), 0, 6);
        }
        
        return $this;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = \Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     *
     * @param int $width            
     * @param int $height            
     * @param $mode
     * @return mixed|null|string
     */
    public function getAvatarSrc($width = 50, $height = 50, $mode = ManipulatorInterface::THUMBNAIL_OUTBOUND)
    {
        if ($this->image) {
            return \Yii::$app->imaging->getImagingUrl($this->image->src, new \yiisns\apps\components\imaging\filters\Thumbnail([
                'w' => $width,
                'h' => $height,
                'm' => $mode
            ]));
        }
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    /*public function getUserAuthClients()
    {
        return $this->hasMany(UserAuthClient::className(), [
            'user_id' => 'id'
        ]);
    }*/

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserEmails()
    {
        return $this->hasMany(UserEmail::className(), [
            'user_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserPhones()
    {
        return $this->hasMany(UserPhone::className(), [
            'user_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\rbac\Role[]
     */
    public function getRoles()
    {
        return \Yii::$app->authManager->getRolesByUser($this->id);
    }

    protected $_roleNames = null;

    /**
     *
     * @return array
     */
    public function getRoleNames()
    {
        if ($this->_roleNames !== null) {
            return $this->_roleNames;
        }
        
        $this->_roleNames = (array) ArrayHelper::map($this->roles, 'name', 'name');
        return $this->_roleNames;
    }

    /**
     *
     * @param array $roleNames            
     * @return $this
     */
    public function setRoleNames($roleNames = [])
    {
        $this->_roleNames = $roleNames;
        
        return $this;
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContentElement2cmsUsers()
    {
        return $this->hasMany(ContentElement2cmsUser::className(), [
            'user_id' => 'id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoriteContentElements()
    {
        return $this->hasMany(ContentElement::className(), [
            'id' => 'content_element_id'
        ])->via('contentElement2cmsUsers');
    }
}