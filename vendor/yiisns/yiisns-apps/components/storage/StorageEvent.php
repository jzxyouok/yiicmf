<?php
/**
 * StorageEvent
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 17.10.2016
 * @since 1.0.0
 */

namespace yiisns\apps\components\storage;

use yii\base\Event;

/**
 * Class StorageEvent
 * @package yiisns\apps\components\storage
 */
class StorageEvent extends Event
{
    /**
     * @var boolean if message was sent successfully.
     */
    public $isSuccessful;
    /**
     * @var boolean whether to continue sending an email. Event handlers of
     * [[\yii\mail\BaseMailer::EVENT_BEFORE_SEND]] may set this property to decide whether
     * to continue send or not.
     */
    public $isValid = true;
}