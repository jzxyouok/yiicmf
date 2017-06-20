<?php
/**
 * Validator
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
 * Class Validator
 * @package yiisns\sx\validators
 */
abstract class Validator implements IValidator
{
    /**
     * @return Result
     */
    protected function _ok()
    {
        return new Result(true);
    }

    /**
     * TODO: make a better name
     *
     * @param  mixed|null $message
     * @return Result
     */
    protected function _bad($message = null)
    {
        $result = new Result(false);

        if ($message)
        {
            $result->addErrorMessage($message);
        }

        return $result;
    }
}