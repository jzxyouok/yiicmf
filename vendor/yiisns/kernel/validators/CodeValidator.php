<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 26.09.2016
 */
namespace yiisns\kernel\validators;

use yii\validators\Validator;
use Exception;

/**
 * Class CodeValidator
 * 
 * @package yiisns\kernel\validators
 */
class CodeValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $string = $model->{$attribute};
        
        if (! preg_match('/^[a-zA-Z]{1}[a-zA-Z0-9-]{1,255}$/', $string)) {
            
            $this->addError($model, $attribute, \Yii::t('yiisns/kernel', 'Use only letters of the alphabet in lower or upper case and numbers, the first character of the letter (Example {code})', [
                'code' => 'code1'
            ]));
            return false;
        }
    }
}