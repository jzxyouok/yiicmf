<?php
/**
 * HasWritableOptions
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 22.10.2016
 * @since 1.0.0
 */
namespace yiisns\sx\traits;


/**
 * Class HasWritableOptions
 * @package yiisns\sx\traits
 */
trait HasWritableOptions
{
    use HasReadableOptions;

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->_options = $options;
        return $this;
    }

    /**
     * @param  string $name
     * @param  mixed  $value
     * @return $this
     */
    public function setOption($name, $value)
    {
        $this->_options[$name] = $value;
        return $this;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setDefaultOptions($options = [])
    {
        $this->_options = array_merge($options, $this->_options);
        return $this;
    }
}