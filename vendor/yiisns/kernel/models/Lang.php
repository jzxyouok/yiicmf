<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.05.2016
 */
namespace yiisns\kernel\models;

use yiisns\kernel\base\AppCore;
use yiisns\kernel\models\behaviors\HasStorageFileBehavior;
use yiisns\kernel\validators\CodeValidator;

use yii\base\Event;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%lang}}".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $active
 * @property string $def
 * @property integer $priority
 * @property string $code
 * @property string $name
 * @property string $description
 * @property integer $image_id
 * @property Site[] $sites
 * @property StorageFile $image
 */
class Lang extends Core
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lang}}';
    }

    public function init()
    {
        parent::init();
        
        $this->on(BaseActiveRecord::EVENT_BEFORE_INSERT, [
            $this,
            'afterBeforeChecks'
        ]);
        $this->on(BaseActiveRecord::EVENT_BEFORE_UPDATE, [
            $this,
            'afterBeforeChecks'
        ]);
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            
            HasStorageFileBehavior::className() => [
                'class' => HasStorageFileBehavior::className(),
                'fields' => [
                    'image_id'
                ]
            ]
        ]);
    }

    /**
     *
     * @param Event $e            
     * @throws Exception
     */
    public function afterBeforeChecks(Event $e)
    {
        if ($this->active != AppCore::BOOL_Y) {
            $active = static::find()->where([
                '!=',
                'id',
                $this->id
            ])
                ->active()
                ->one();
            
            if (! $active) {
                $this->active = AppCore::BOOL_Y;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => \Yii::t('yiisns/kernel', 'ID'),
            'created_by' => \Yii::t('yiisns/kernel', 'Created By'),
            'updated_by' => \Yii::t('yiisns/kernel', 'Updated By'),
            'created_at' => \Yii::t('yiisns/kernel', 'Created At'),
            'updated_at' => \Yii::t('yiisns/kernel', 'Updated At'),
            'active' => \Yii::t('yiisns/kernel', 'Active'),
            'def' => \Yii::t('yiisns/kernel', 'Default'),
            'priority' => \Yii::t('yiisns/kernel', 'Priority'),
            'code' => \Yii::t('yiisns/kernel', 'Code'),
            'name' => \Yii::t('yiisns/kernel', 'Name'),
            'description' => \Yii::t('yiisns/kernel', 'Description'),
            'image_id' => \Yii::t('yiisns/kernel', 'Image')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                [
                    'created_by',
                    'updated_by',
                    'created_at',
                    'updated_at',
                    'priority'
                ],
                'integer'
            ],
            [
                [
                    'code',
                    'name'
                ],
                'required'
            ],
            [
                [
                    'code'
                ],
                CodeValidator::className(),
            ],
            [
                [
                    'active',
                    'def'
                ],
                'string',
                'max' => 1
            ],
            [
                [
                    'code'
                ],
                'string',
                'max' => 5
            ],
            [
                [
                    'name',
                    'description'
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'code'
                ],
                'unique'
            ],
            [
                'priority',
                'default',
                'value' => 500
            ],
            [
                'active',
                'default',
                'value' => AppCore::BOOL_Y
            ],
            [
                'def',
                'default',
                'value' => AppCore::BOOL_N
            ],
            [
                [
                    'image_id'
                ],
                'integer'
            ]
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSites()
    {
        return $this->hasMany(Site::className(), [
            'lang_code' => 'code'
        ]);
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
}