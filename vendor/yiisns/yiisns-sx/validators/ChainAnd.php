<?php
/**
 * ChainAnd
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
 *
 * @since 1.0
 * @author uussoft <uussoft@yiisns.cn>
 */
class ChainAnd extends Chain
{
    /**
     *
     * @param mixed $value            
     * @return Result
     */
    function validate($value)
    {
        $result = new Result(true);
        
        foreach ($this->_validators as $validator) {
            /**
             *
             * @var IValidator $validator
             */
            $result->mergeWithResult($validator->validate($value));
        }
        
        return $result;
    }
}