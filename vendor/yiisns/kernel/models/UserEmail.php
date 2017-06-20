<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.02.2016
 */
namespace yiisns\kernel\models;

use yiisns\kernel\base\AppCore;
use yiisns\kernel\models\User;

use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "user_email".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $value
 * @property string $approved
 * @property string $def
 * @property string $approved_key
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class UserEmail extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_email}}';
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            TimestampBehavior::className()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->on(self::EVENT_BEFORE_UPDATE,    [$this, 'beforeSaveEvent']);
    }

    /**
     * @param $event
     */
    public function beforeSaveEvent($event)
    {
        if ($this->def == AppCore::BOOL_N)
        {
            if ($this->user_id)
            {
                if (!static::find()->where(['def' => AppCore::BOOL_Y])->andWhere(['!=', 'id', $this->id])->andWhere(['user_id' => $this->user_id])->count())
                {
                    $this->def = AppCore::BOOL_Y;
                }
            }
        } else if ($this->def == AppCore::BOOL_Y)
        {
            if ($this->user_id)
            {
                static::updateAll(['def' => AppCore::BOOL_N], [
                    'and',
                    ['user_id' => $this->user_id],
                    ['!=', 'id', $this->id]
                ]);
            }
        }
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'required'],
            [['value'], 'email'],
            [['value', 'approved_key'], 'string', 'max' => 255],
            [['approved', 'def'], 'string', 'max' => 1],
            [['value'], 'unique'],
            [['approved'], 'default', 'value' => AppCore::BOOL_N],
            [['def'], 'default', 'value' => AppCore::BOOL_N],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('yiisns/kernel', 'ID'),
            'user_id' => \Yii::t('yiisns/kernel', 'User'),
            'value' => \Yii::t('yiisns/kernel', 'Email'),
            'approved' => \Yii::t('yiisns/kernel', 'Approved'),
            'created_at' => \Yii::t('yiisns/kernel', 'Created At'),
            'updated_at' => \Yii::t('yiisns/kernel', 'Updated At'),
            'def' => \Yii::t('yiisns/kernel', 'Default'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}