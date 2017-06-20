<?php
/**
 * HasJsonFieldsBehavior
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.11.2016
 * @since 1.0.0
 */
namespace yiisns\kernel\models\behaviors;

use yii\db\ActiveRecord;
use yii\base\Behavior;
use yii\base\Event;
use yii\helpers\Json;

/**
 * Class HasJsonFieldsBehavior
 * 
 * @package yiisns\kernel\models\behaviors
 */
class HasJsonFieldsBehavior extends Behavior
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
            ActiveRecord::EVENT_BEFORE_INSERT => 'jsonEncodeFields',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'jsonEncodeFields',
            ActiveRecord::EVENT_AFTER_FIND => 'jsonDecodeFields',
            ActiveRecord::EVENT_AFTER_UPDATE => 'jsonDecodeFields',
            ActiveRecord::EVENT_AFTER_INSERT => 'jsonDecodeFields',
        ];
    }

    /**
     * Json编码
     * @param Event $event            
     */
    public function jsonEncodeFields($event)
    {
        foreach ($this->fields as $fielName) {
            if ($this->owner->{$fielName}) {
                if (is_array($this->owner->{$fielName})) {
                    $this->owner->{$fielName} = Json::encode((array) $this->owner->{$fielName});
                }
            } else {
                $this->owner->{$fielName} = '';
            }
        }
    }

    /**
     * Json解码
     * @param Event $event            
     */
    public function jsonDecodeFields($event)
    {
        foreach ($this->fields as $fielName) {
            if ($this->owner->{$fielName}) {
                if (is_string($this->owner->{$fielName})) {
                    try {
                        $this->owner->{$fielName} = Json::decode($this->owner->{$fielName});
                    } catch (\Exception $e) {
                        \Yii::error($e->getMessage());
                        $this->owner->{$fielName} = [];
                    }
                }
            } else {
                $this->owner->{$fielName} = [];
            }
        }
    }
}