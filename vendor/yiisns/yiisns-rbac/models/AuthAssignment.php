<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.04.2016
 */

namespace yiisns\rbac\models;

use yiisns\kernel\models\User;

use Yii;
use yii\db\ActiveRecord;
use yii\rbac\Item;
use yii\helpers\Json;
/**
 * This is the model class for table "tbl_auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $ruleName
 * @property string $data
 *
 * @property AuthItem $authItem
 * @property User $user
 */
class AuthAssignment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_assignment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['item_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_name' => \Yii::t('yiisns/rbac', 'Item Name'),
            'user_id' => \Yii::t('yiisns/kernel', 'User ID'),
            'created_at' => \Yii::t('yiisns/kernel', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItem()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}