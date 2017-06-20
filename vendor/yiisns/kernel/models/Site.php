<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.05.2016
 */
namespace yiisns\kernel\models;

use yiisns\apps\base\Widget;
use yiisns\kernel\base\AppCore;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\behaviors\HasStorageFileBehavior;
use yiisns\kernel\models\behaviors\TimestampPublishedBehavior;
use yiisns\kernel\models\Tree;
use yiisns\kernel\validators\CodeValidator;
use yiisns\kernel\validators\ServerNameValidator;

use yii\base\Event;
use yii\base\Exception;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%site}}".
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
 * @property string $server_name
 * @property string $description
 * @property integer $image_id
 *
 * @property string $url
 *
 * @property Tree $rootTree
 * @property Lang $lang
 * @property SiteDomain[] $siteDomains
 * @property Tree[] $trees
 * @property StorageFile $image
 */
class Site extends Core
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%site}}';
    }

    public function init()
    {
        parent::init();
        
        $this->on(BaseActiveRecord::EVENT_AFTER_INSERT, [
            $this,
            'createTreeAfterInsert'
        ]);
        $this->on(BaseActiveRecord::EVENT_BEFORE_INSERT, [
            $this,
            'beforeInsertChecks'
        ]);
        $this->on(BaseActiveRecord::EVENT_BEFORE_UPDATE, [
            $this,
            'beforeUpdateChecks'
        ]);
        
        $this->on(BaseActiveRecord::EVENT_BEFORE_DELETE, [
            $this,
            'beforeDeleteRemoveTree'
        ]);
    }

    /**
     *
     * @throws Exception
     * @throws \Exception
     */
    public function beforeDeleteRemoveTree()
    {
        // Before delete site delete all tree
        foreach ($this->trees as $tree) {
            $tree->delete();
        }
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
    public function beforeUpdateChecks(Event $e)
    {
        if ($this->def == AppCore::BOOL_Y) {
            static::updateAll([
                'def' => AppCore::BOOL_N
            ], [
                '!=',
                'id',
                $this->id
            ]);
            
            $this->active = AppCore::BOOL_Y;
        }
    }

    /**
     *
     * @param Event $e            
     * @throws Exception
     */
    public function beforeInsertChecks(Event $e)
    {
        if ($this->def == AppCore::BOOL_Y) {
            static::updateAll([
                'def' => AppCore::BOOL_N
            ]);
            
            $this->active = AppCore::BOOL_Y;
        }
    }

    public function createTreeAfterInsert(Event $e)
    {
        $tree = new Tree([
            'name' => \Yii::t('yiisns/kernel, Main Page'),
            'site_code' => $this->code
        ]);
        
        if (! $tree->save(false)) {
            throw new Exception('Failed to create a section of the tree');
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
            'server_name' => \Yii::t('yiisns/kernel', 'Server Name'),
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
                'max' => 15
            ],
            [
                [
                    'name',
                    'server_name',
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
                [
                    'code'
                ],
                CodeValidator::className(),
            ],
            /*[
                [
                    'server_name'
                ],
                ServerNameValidator::className(),  // 这个正则有点问题需要解决
            ],*/
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

    public static $sites = [];

    /**
     *
     * @param (string) $code            
     * @return static
     */
    static public function getByCode($code)
    {
        if (! array_key_exists($code, static::$sites)) {
            static::$sites[$code] = static::find()->where([
                'code' => (string) $code
            ])
                ->active()
                ->one();
        }
        
        return static::$sites[$code];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSiteDomains()
    {
        return $this->hasMany(SiteDomain::className(), [
            'site_code' => 'code'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrees()
    {
        return $this->hasMany(Tree::className(), [
            'site_code' => 'code'
        ]);
    }

    /**
     *
     * @return string
     */
    public function getUrl()
    {
        if ($this->server_name) {
            return '//' . $this->server_name;
        }
        
        return \Yii::$app->urlManager->hostInfo;
    }

    /**
     *
     * @return Tree
     */
    public function getRootTree()
    {
        return $this->getTrees()
            ->andWhere([
            'level' => 0
        ])
            ->limit(1)
            ->one();
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