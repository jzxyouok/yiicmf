<?php
/**
 * App
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.10.2016
 * @since 1.0.0
 */
namespace yiisns\sx;

/**
 * Interface Ix_Filter
 * 
 * @package yiisns\sx
 */
interface Ix_Filter
{
    /**
     *
     * @param mixed $value            
     * @return mixed
     */
    function filter($value);
}

/**
 * Class Filter
 * 
 * @package yiisns\sx
 */
abstract class Filter implements Ix_Filter
{
    /**
     *
     * @param mixed $value            
     * @return mixed
     */
    public function __invoke($value)
    {
        return $this->filter($value);
    }
}