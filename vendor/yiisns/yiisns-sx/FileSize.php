<?php
/**
 * File
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 22.10.2016
 * @since 1.0.0
 */
namespace yiisns\sx;

use yiisns\sx\Exception;


/**
 * Class FileSize
 * @package yiisns\sx
 */
class FileSize
{
    use traits\Entity;
    use traits\InstanceObject;

    public function __construct($sizeBytes = 0)
    {
        $this->_data["bytes"] = (float) $sizeBytes;
    }

    /**
     * Размер в байтах
     * @return float
     */
    public function getBytes()
    {
        return (float) $this->get("bytes", 0);
    }

    /**
     * @param null $decimals
     * @param array $options
     * @param array $textOptions
     * @return string
     */
    public function formatedShortSize($decimals = null, $options = [], $textOptions = [])
    {
        return \Yii::$app->getFormatter()->asShortSize($this->getBytes(), $decimals, $options, $textOptions);
    }

    /**
     * @param null $decimals
     * @param array $options
     * @param array $textOptions
     * @return string
     */
    public function formatedSize($decimals = null, $options = [], $textOptions = [])
    {
        return \Yii::$app->getFormatter()->asSize($this->getBytes(), $decimals, $options, $textOptions);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->formatedShortSize();
    }
}