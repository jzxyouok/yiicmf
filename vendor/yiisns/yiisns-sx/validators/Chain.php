<?php
/**
 * Abstract chain of validators
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 07.11.2016
 * @since 1.0.0
 */
namespace yiisns\sx\validators;

use yiisns\sx\validate\Exception;

/**
 *
 * @since 1.0
 * @author uussoft <uussoft@yiisns.cn>
 */
abstract class Chain extends Validator
{
    /**
     *
     * @var array
     */
    protected $_validators = array();

    /**
     *
     * @param array $validators            
     * @throws Exception
     */
    public function __construct(array $validators)
    {
        foreach ($validators as $validator) {
            if (! ($validator instanceof IValidator)) {
                throw new Exception("Array of objects of class Ix_Validator was expected.");
            }
        }
        
        $this->_validators = $validators;
    }
}