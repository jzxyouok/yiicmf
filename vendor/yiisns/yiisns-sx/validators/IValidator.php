<?php
/**
 * IValidator
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 07.11.2016
 * @since 1.0.0
 */

namespace yiisns\sx\validators;

use yiisns\sx\validate\Result;

/**
 * Interface IValidator
 * @package yiisns\sx\validators
 */
interface IValidator
{
    /**
     *
     * @param  mixed $value
     * @return Result
     */
     function validate($value);
}