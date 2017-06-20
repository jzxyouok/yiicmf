<?php
/**
 * The basic model consists of user behavior, when updated or created.
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 31.10.2016
 * @since 1.0.0
 */
namespace yiisns\kernel\models;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yiisns\kernel\models\behaviors\HasTableCacheBehavior;
use yii\db\ActiveRecord;
use yiisns\kernel\query\ActiveQuery;

/**
 *
 * @method string getTableCacheTag()
 *        
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 * 
 * @package yiisns\kernel\models
 */
abstract class Core extends ActiveRecord
{
    /**
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'id' ], 'integer']
        ];
    }
    
    /**
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('yiisns/kernel', 'ID'),
            'created_by' => \Yii::t('yiisns/kernel', 'Created By'),
            'updated_by' => \Yii::t('yiisns/kernel', 'Updated By'),
            'created_at' => \Yii::t('yiisns/kernel', 'Created At'),
            'updated_at' => \Yii::t('yiisns/kernel', 'Updated At')
        ];
    } 
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            BlameableBehavior::className() => [
                'class' => BlameableBehavior::className(),
                'value' => function ($event) {
                    if (\Yii::$app instanceof \yii\console\Application) {
                        return null;
                    } else {
                        $user = \Yii::$app->get('user', false);
                        return $user && ! $user->isGuest ? $user->id : null;
                    }
                }
            ],
            TimestampBehavior::className() => [
                'class' => TimestampBehavior::className()
            ],
            
            HasTableCacheBehavior::className() => [
                'class' => HasTableCacheBehavior::className(),
                'cache' => \Yii::$app->cache
            ]
        ]);
    }

    /**
     *
     * @return ActiveQuery
     */
    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }

    /**
     *
     * @method see \yii\db\BaseActiveRecord::hasOne($class, $link)
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\Yii::$app->user->identityClass, [
            'id' => 'created_by'
        ]);
    }

    /**
     *
     * @method see \yii\db\BaseActiveRecord::hasOne($class, $link)
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(\Yii::$app->user->identityClass, [
            'id' => 'updated_by'
        ]);
    }
}