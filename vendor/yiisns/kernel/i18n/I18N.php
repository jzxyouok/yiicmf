<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 21.12.2016
 */
namespace yiisns\kernel\i18n;

use yii\base\InvalidConfigException;
use yii\i18n\MissingTranslationEvent;

class I18N extends \yii\i18n\I18N
{
    public $missingTranslationHandler = ['yiisns\kernel\I18n\I18N', 'handleMissingTranslation'];

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!isset($this->translations['*']))
        {
            $this->translations['*'] = [
                'class' => 'yii\i18n\PhpMessageSource'
            ];
        }

        parent::init();
    }

    public static function handleMissingTranslation(MissingTranslationEvent $event)
    {
        \Yii::info("@Missing: {$event->category}.{$event->message} For Language {$event->language} @", self::className());

        if ($event->category != 'yiisns/kernel')
        {
            $event->translatedMessage = \Yii::t('yiisns/kernel', $event->message);
        }
    }
}