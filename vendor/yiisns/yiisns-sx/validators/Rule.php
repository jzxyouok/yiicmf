<?php
/**
 * Rule
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 07.11.2016
 * @since 1.0.0
 */
namespace yiisns\sx\validators;

use yiisns\sx\validate\Exception;
use yiisns\sx\validate\IResult;
use yiisns\sx\validate\Validate;

/**
 * Class Rule
 * 
 * @package yiisns\sx\validators
 */
class Rule extends Validator
{
    /**
     *
     * @var string
     */
    protected $_rule = null;

    /**
     *
     * @var array
     */
    protected $_options = array(
        'pluginsMap' => array(
            // regex
            'regex' => 'regEx',
            'regEx' => 'regEx',
            
            // is
            'is_int' => 'is_int',
            'is_numeric' => 'is_numeric',
            'is_string' => 'is_string',
            'is_array' => 'is_array',
            'is_object' => 'is_object',
            'is_email' => 'is_email',
            'is_refSpec' => 'is_refSpec',
            
            // negate
            'not' => 'negate',
            'negate' => 'negate',
            
            // instanceof
            'instanceOf' => 'instanceOf',
            'iof' => 'instanceOf',
            
            // array
            'count' => 'count',
            'array_of' => 'array_of',
            'array_hasKey' => 'array_hasKey',
            'enum' => 'enum',
            
            // not
            'not_empty' => 'not_empty',
            
            // cmp
            'cmp_gt' => 'cmp_gt'
        )
    );

    /**
     *
     * @param string $rule            
     * @param array $options            
     * @throws Exception
     */
    public function __construct($rule, array $options = array())
    {
        if (! (is_string($rule) && mb_strlen($rule))) {
            throw new Exception("DSL rule should be a non empty string.");
        }
        
        $this->_rule = $rule;
        $this->_options = array_merge_recursive($this->_options, $options);
    }

    /**
     * Verification Validations Meanings
     *
     * @param mixed $value            
     * @return IResult
     */
    public function validate($value)
    {
        $parser = new Cx_Validator_Rule_Parser($this->_options['pluginsMap']);
        $validator = $parser->parse($this->_rule);
        
        return $validator->validate($value);
    }
}