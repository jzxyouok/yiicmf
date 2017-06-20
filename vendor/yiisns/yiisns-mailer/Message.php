<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 31.07.2016
 */
namespace yiisns\mail;

/**
 * Class Message
 * @package yiisns\mail
 */
class Message extends \yii\swiftmailer\Message
{
    public function init()
    {
        if (!$this->getFrom())
        {
            $this->setFrom([\Yii::$app->appSettings->adminEmail => \Yii::$app->name]);
        }

        parent::init();
    }
}