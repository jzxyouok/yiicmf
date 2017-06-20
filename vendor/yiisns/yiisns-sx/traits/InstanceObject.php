<?php
/**
 * InstanceObject
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 22.10.2016
 * @since 1.0.0
 */
namespace yiisns\sx\traits;

/**
 * Class InstanceObject
 * @package yiisns\sx\traits
 */
trait InstanceObject
{
    /**
     * @param $file
     * @return static
     */
    static public function object($file = null)
    {
        if ($file instanceof static)
        {
            return $file;
        } else
        {
            return new static($file);
        }
    }
}