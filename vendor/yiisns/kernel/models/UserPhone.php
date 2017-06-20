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
use yiisns\kernel\validators\PhoneValidator;

use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "user_phone".
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
class UserPhone extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_phone}}';
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
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'required'],
            [['value'], PhoneValidator::className()],
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
            'value' => \Yii::t('yiisns/kernel', 'Phone Number'),
            'approved' => \Yii::t('yiisns/kernel', 'Approved'),
            'created_at' => \Yii::t('yiisns/kernel', 'Created At'),
            'updated_at' => \Yii::t('yiisns/kernel', 'Updated At'),
            'def' => 'Def',
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