<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.05.2016
 */
namespace yiisns\kernel\models;

use yiisns\apps\base\Widget;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\behaviors\TimestampPublishedBehavior;
use yiisns\kernel\validators\CodeValidator;

use yii\base\Event;
use yii\db\BaseActiveRecord;

/**
 * This is the model class for table "{{%site}}".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $site_code
 * @property string $domain
 *
 *  @property Site $site
 */
class SiteDomain extends Core
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%site_domain}}';
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
            'site_code' => \Yii::t('yiisns/kernel', 'Site'),
            'domain' => \Yii::t('yiisns/kernel', 'Domain'),
        ]);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['site_code', 'domain'], 'required'],
            [['site_code'], 'string', 'max' => 15],
            [['domain'], 'string', 'max' => 255],
            [['domain', 'site_code'], 'unique', 'targetAttribute' => ['domain', 'site_code'], 'message' => \Yii::t('yiisns/kernel', 'The combination of Site Code and Domain has already been taken.')]
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSite()
    {
        return $this->hasOne(Site::className(), ['code' => 'site_code']);
    }
}