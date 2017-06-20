<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.03.2016
 */
namespace yiisns\apps\helpers;

use yiisns\apps\components\imaging\Filter;

/**
 * Class Request
 * @package yiisns\kernel\helpers
 */
class Image
{
    /**
     * @return string
     */
    static public function getCapSrc()
    {
        return (string) \Yii::$app->appSettings->noImageUrl;
    }
    /**
     *
     * @param string $originalSrc
     * @param null $capSrc
     * @return string
     */
    static public function getSrc($originalSrc = '', $capSrc = null)
    {
        if ($originalSrc)
        {
            return (string) $originalSrc;
        }

        if (!$capSrc)
        {
            $capSrc = static::getCapSrc();
        }

        return (string) $capSrc;
    }

    /**
     * @param string $originalSrc
     * @param Filter $filter
     * @param string $nameForSave
     * @param null $capSrc
     * @return string
     */
    static public function thumbnailUrlOnRequest($originalSrc = '', Filter $filter, $nameForSave = '', $capSrc = null)
    {
        if ($originalSrc)
        {
            return \Yii::$app->imaging->thumbnailUrlOnRequest($originalSrc, $filter, $nameForSave = '');

        } else
        {
            return static::getCapSrc();
        }
    }
}