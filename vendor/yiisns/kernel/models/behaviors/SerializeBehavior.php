<?php
/**
 * SerializeBehavior
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 10.11.2016
 * @since 1.0.0
 */
namespace yiisns\kernel\models\behaviors;

use yii\db\BaseActiveRecord;
use \yii\base\Behavior;
use yii\base\Event;

/**
 * Class SerializeBehavior
 * 
 * @package yiisns\kernel\models\behaviors
 */
class SerializeBehavior extends Behavior
{
    /**
     *
     * @var array
     */
    public $fields = [];

    /**
     *
     * @return array
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'serializeFields',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'serializeFields',
            BaseActiveRecord::EVENT_AFTER_FIND => 'unserializeFields',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'unserializeFields',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'unserializeFields'
        ];
    }

    /**
     *
     * @param Event $event            
     */
    public function serializeFields($event)
    {
        foreach ($this->fields as $fielName) {
            if ($this->owner->{$fielName}) {
                if (is_array($this->owner->{$fielName})) {
                    $this->owner->{$fielName} = serialize($this->owner->{$fielName});
                }
            } else {
                $this->owner->{$fielName} = '';
            }
        }
    }

    /**
     *
     * @param Event $event            
     */
    public function unserializeFields($event)
    {
        foreach ($this->fields as $fielName) {
            if ($this->owner->{$fielName}) {
                if (is_string($this->owner->{$fielName})) {
                    $this->owner->{$fielName} = @unserialize($this->owner->{$fielName});
                }
            } else {
                $this->owner->{$fielName} = [];
            }
        }
    }
}