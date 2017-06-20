<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.05.2016
 */
namespace yiisns\kernel\models\behaviors;

use yii\base\Behavior;
use yii\caching\Cache;
use yii\caching\TagDependency;
use yii\db\ActiveQuery;
use yii\db\AfterSaveEvent;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\ErrorHandler;

/**
 * Class HasTableCacheBehavior
 * 
 * @package yiisns\kernel\models\behaviors
 */
class HasTableCacheBehavior extends Behavior
{
    /**
     *
     * @var Cache
     */
    public $cache;

    /**
     *
     * @return array
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'invalidateTableCache',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'invalidateTableCache',
            BaseActiveRecord::EVENT_AFTER_DELETE => 'invalidateTableCache',
        ];
    }

    /**
     *
     * @return $this
     */
    public function invalidateTableCache()
    {
        TagDependency::invalidate($this->cache, [
            $this->getTableCacheTag()
        ]);
        
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getTableCacheTag()
    {
        //var_dump($this->owner->tableName());
        return 'sx-table-' . $this->owner->tableName();
    }
}