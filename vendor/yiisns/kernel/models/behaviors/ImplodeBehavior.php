<?php
/**
 * implode / explode before after save
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.10.2016
 * @since 1.0.0
 */
namespace yiisns\kernel\models\behaviors;

use yii\db\BaseActiveRecord;
use \yii\base\Behavior;
use yii\base\Event;

/**
 * Class ImplodeBehavior
 * 
 * @package yiisns\kernel\models\behaviors
 */
class ImplodeBehavior extends Behavior
{
    /**
     *
     * @var array
     */
    public $fields = [];

    /**
     *
     * @var string
     */
    public $delimetr = ',';

    /**
     *
     * @return array
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'implodeFields',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'implodeFields',
            BaseActiveRecord::EVENT_AFTER_FIND => 'explodeFields',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'explodeFields',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'explodeFields',
        ];
    }

    /**
     *
     * @param Event $event            
     */
    public function implodeFields($event)
    {
        foreach ($this->fields as $fielName) {
            if ($this->owner->{$fielName}) {
                if (is_array($this->owner->{$fielName})) {
                    $this->owner->{$fielName} = implode($this->delimetr, $this->owner->{$fielName});
                }
            } else {
                $this->owner->{$fielName} = "";
            }
        }
    }

    /**
     *
     * @param Event $event            
     */
    public function explodeFields($event)
    {
        foreach ($this->fields as $fielName) {
            if ($this->owner->{$fielName}) {
                if (is_string($this->owner->{$fielName})) {
                    $this->owner->{$fielName} = explode($this->delimetr, $this->owner->{$fielName});
                }
            } else {
                $this->owner->{$fielName} = [];
            }
        }
    }
}