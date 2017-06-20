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
 * Class LoginValidator
 * @package yiisns\kernel\validators
 */
class LoginValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $string = $model->{$attribute};

        if (!preg_match('/^[a-z]{1}[a-z0-9_]+$/', $string))
        {
            $this->addError($model, $attribute, \Yii::t('yiisns/kernel', 'Use only letters (lowercase) and numbers. Must begin with a letter. Example {sample}',['sample' => 'admin']));
            return false;
        }
    }
}