<?php
/**
 * ChainOr
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
 * Class ChainOr
 * 
 * @package yiisns\sx\validators
 */
class ChainOr extends Chain
{
    /**
     *
     * @param mixed $value            
     * @return Result
     */
    public function validate($value)
    {
        $result = new Result(true);
        
        foreach ($this->_validators as $validator) {
            /**
             *
             * @var IValidator $validator
             */
            if ($validator->validate($value)->isValid()) {
                return $this->_ok();
            } else {
                $result->mergeWithResult($validator->validate($value));
            }
        }
        
        $result->setInvalid();
        return $result->addErrorMessage("At least one condition must be satisfied");
    }
}