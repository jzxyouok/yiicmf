<?php
namespace yiisns\kernel\models;

use Yii;
use yii\helpers\ArrayHelper;
use yiisns\kernel\models\behaviors\ImplodeBehavior;
use yiisns\kernel\models\behaviors\SerializeBehavior;
use yiisns\kernel\models\User;

/**
 * This is the model class for table "admin_filter".
 *
 * @property integer $user_id
 * @property integer $is_default
 * @property string $name
 * @property string $namespace
 * @property string $values
 * @property string $visibles
 * 
 * @property string $isPublic
 * 
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * 
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @property string $displayName
 */
class AdminFilter extends Core
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_filter}}';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'user_id', 'is_default'], 'integer'],
            [['namespace'], 'required'],
            [['values', 'visibles'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['namespace'], 'string', 'max' => 255],
            [['user_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => [
                    'user_id' => 'id'
                ]
            ],
            [['created_by'], 'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => [
                    'created_by' => 'id'
                ]
            ],
            [['updated_by'], 'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => [
                    'updated_by' => 'id'
                ]
            ],
            [['user_id'], 'default', 'value' => null],
            [['name'], 'default', 'value' => null],
            [['is_default'], 'default', 'value' => null],
            [['isPublic'], 'safe']
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('yiisns/admin', 'ID'),
            'created_by' => Yii::t('yiisns/admin', 'Created By'),
            'updated_by' => Yii::t('yiisns/admin', 'Updated By'),
            'created_at' => Yii::t('yiisns/admin', 'Created At'),
            'updated_at' => Yii::t('yiisns/admin', 'Updated At'),
            'user_id' => Yii::t('yiisns/admin', 'User ID'),
            'name' => Yii::t('yiisns/admin', 'Name'),
            'namespace' => Yii::t('yiisns/admin', 'Namespace'),
            'values' => Yii::t('yiisns/admin', 'Values filters'),
            'visibles' => Yii::t('yiisns/admin', 'Visible fields'),
            'is_default' => Yii::t('yiisns/admin', 'Is Default'),
            'isPublic' => \Yii::t('yiisns/admin', 'Available for all')
        ]);
    }
    
    /**
     *
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            
            SerializeBehavior::className() => [
                'class' => SerializeBehavior::className(),
                'fields' => [
                    'values'
                ]
            ],
            
            ImplodeBehavior::className() => [
                'class' => ImplodeBehavior::className(),
                'fields' => [
                    'visibles'
                ]
            ]
        ]);
    }

    /**
     * 是否用于所有用户
     */
    private $_isPublic = null;

    public function getIsPublic()
    {
        return (int) ($this->user_id ? 0 : 1);
    }

    public function setIsPublic($value)
    {
        if ($value) {
            $this->user_id = null;
        } else {
            $this->user_id = \Yii::$app->user->id;
        }
    }

    /**
     * 显示过滤器名称，默认为 Filter
     * @return string
     */
    public function getDisplayName()
    {
        if (! $this->name) {
            return \Yii::t('yiisns/admin', 'Filter');
        }
        
        return $this->name;
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), [
            'id' => 'user_id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), [
            'id' => 'created_by'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), [
            'id' => 'updated_by'
        ]);
    }
}