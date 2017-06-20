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
 * Class ServerNameValidator
 * 
 * @package yiisns\kernel\validators
 */
class ServerNameValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $string = $model->{$attribute};     
        
        //if (! preg_match('/^[а-z0-9.-]{2,255}$/', $string)) {
        if (! preg_match('/^[а-z0-9]{1,255}$/', $string)) {
            $this->addError($model, $attribute, \Yii::t('yiisns/kernel', 'Use only lowercase letters and numbers. Example {site} (2-255 characters)', [
                'site' => 'site.cn'
            ]));
            return false;
        }
    }
}