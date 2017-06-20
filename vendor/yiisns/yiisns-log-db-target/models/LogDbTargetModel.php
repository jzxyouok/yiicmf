<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.05.2016
 */
namespace yiisns\logDbTarget\models;

use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%log_db_target}}".
 *
 * @property string $id
 * @property integer $level
 * @property string $category
 * @property integer $log_time
 * @property string $prefix
 * @property string $message
 */
class LogDbTargetModel extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%log_db_target}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'log_time'], 'integer'],
            [['prefix', 'message'], 'string'],
            [['category'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('yiisns/logdb', 'ID'),
            'level' => \Yii::t('yiisns/logdb', 'Level'),
            'category' => \Yii::t('yiisns/logdb', 'Category'),
            'log_time' => \Yii::t('yiisns/logdb', 'Log Time'),
            'prefix' => \Yii::t('yiisns/logdb', 'Prefix'),
            'message' => \Yii::t('yiisns/logdb', 'Message'),
        ];
    }
}