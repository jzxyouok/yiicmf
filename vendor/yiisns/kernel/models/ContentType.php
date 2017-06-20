<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 09.11.2016
 * @since 1.0.0
 */

namespace yiisns\kernel\models;

use yiisns\kernel\base\AppCore;
use yiisns\apps\base\Widget;
use yiisns\apps\helpers\StringHelper;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\behaviors\TimestampPublishedBehavior;

use yii\base\Exception;

/**
 * This is the model class for table "content_type".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $priority
 * @property string $name
 * @property string $code
 *
 * @property Content[] $contents
 */
class ContentType extends Core
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content_type}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), []);
    }

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_BEFORE_DELETE, [$this, '_actionBeforeDelete']);
    }

    public function _actionBeforeDelete($e)
    {
        if ($this->contents)
        {
            throw new Exception(\Yii::t('yiisns/kernel', 'Before you delete this type of content you want to delete the contents invested in it'));
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
            'priority' => \Yii::t('yiisns/kernel', 'Priority'),
            'name' => \Yii::t('yiisns/kernel', 'Name'),
            'code' => \Yii::t('yiisns/kernel', 'Code'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'priority'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 32],
            [['code'], 'unique'],
            ['code', 'default', 'value' => function($model, $attribute)
            {
                return "content_auto_" . md5(rand(1, 10) . time());
            }],
            ['priority', 'default', 'value' => function($model, $attribute)
            {
                return 500;
            }],
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContents()
    {
        return $this->hasMany(Content::className(), ['content_type' => 'code'])->orderBy('priority ASC')->andWhere(['active' => AppCore::BOOL_Y]);
    }
}