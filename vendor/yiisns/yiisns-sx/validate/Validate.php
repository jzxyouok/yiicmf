<?php
/**
 * Tool for validating data with a small DSL
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 07.11.2016
 * @since 1.0.0
 */
namespace yiisns\sx\validate;

use yiisns\sx\validators\IValidator;
use yiisns\sx\validators\Rule;
use yiisns\sx\validators\Validator;

/**
 * Class Validate
 * @package yiisns\sx\validate
 */
class Validate
{
    /**
     * @param  string|array|IValidator  $rule
     * @param  array|mixed                $data
     * @param  array                      $options
     * @return Result
     */
    static public function validate($rule, $data, array $options = array())
    {
        return static::_validate($rule, $data, $options);
    }

    /**
     * @param string|array|IValidator  $rule
     * @param array|mixed                $data
     * @param array                      $options
     */
    static public function assert($rule, $data, array $options = array())
    {
        assert('static::_validate($rule, $data, $options)->isValid()');
    }

    /**
     * @param  string|array|IValidator  $rule
     * @param  array|mixed                $data
     * @param  array                      $options
     * @throws Exception
     */
    static public function ensure($rule, $data, array $options = array())
    {
        $result = static::_validate($rule, $data, $options);

        if ($result->isInvalid())
        {
            $ruleStr = is_object($rule) ? get_class($rule) : $rule;
            if (is_array($rule))
            {
                $chunks = array();
                foreach ($rule as $k => $r)
                {
                    $chunks[] = $k . ' => ' . is_object($r) ? get_class($r) : $r;
                }

                $ruleStr = '[' . join(', ', $chunks) . ']';
            }

            $backtrace = debug_backtrace();
            $backtrace = $backtrace[0];

            $file = $backtrace['file'];
            $line = $backtrace['line'];

            /*if(strncmp($file, SX_DIR, strlen(SX_DIR)) === 0)
            {
                $file = substr($file, strlen(SX_DIR) + 1);
            }*/

            $messages = implode("; ", $result->getErrorMessages());
            throw new Exception("Given data for [Cx_Validate::ensure() called from $file at line $line], didn't match the rule '$ruleStr'. messages: '$messages'");
        }
    }

    /**
     * @param $rule
     * @param $data
     * @param array $options
     * @return bool
     */
    static public function isValid($rule, $data, array $options = array())
    {
        return static::_validate($rule, $data, $options)->isValid();
    }

    /**
     * @param  string|array|IValidator $rule
     * @param  mixed|array               $data
     * @param  array                     $options
     * @return Result
     * @throws Exception
     */
    static protected function _validate($rule, $data, array $options)
    {
        $result = null;

        if (is_array($rule))
        {
            $result = new ResultComposite();

            foreach ($rule as $key => $ruleSpec)
            {
                if (!array_key_exists($key, $data, true))
                {
                    throw new Exception("No corresponding data key '$key' was found for a rule.");
                }

                $validator = $ruleSpec instanceof IValidator ? $ruleSpec : new Rule($ruleSpec, $options);
                $result->setResultByKey($key, $validator->validate($data[$key]));
            }

        }
        else
        {
            $validator = $rule instanceof Validator ? $rule : new Rule($rule, $options);
            $result    = $validator->validate($data);
        }

        return $result;
    }
}