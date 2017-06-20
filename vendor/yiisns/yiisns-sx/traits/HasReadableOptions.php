<?php
/**
 * HasReadableOptions
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 22.10.2016
 * @since 1.0.0
 */
namespace yiisns\sx\traits;
/**
 * Class Entity
 * @package yiisns\sx\traits
 */
trait HasReadableOptions
{
    /**
     * @var array
     */
    protected $_options = [];

    /**
     * @param $name
     * @param null $default
     * @return null
     */
    public function getOption($name, $default = null)
    {
        return $this->hasOption($name) ? $this->_options[$name] : $default;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * @param  string $name
     * @return bool
     */
    public function hasOption($name)
    {
        return array_key_exists($name, $this->_options);
    }
}