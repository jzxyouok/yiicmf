<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 02.03.2016
 */
namespace yiisns\kernel\base;

use yii\widgets\ActiveForm;

/**
 *
 * Interface ConfigFormInterface
 * 
 * @package yiisns\kernel\base
 */
interface ConfigFormInterface
{
    /**
     *
     * @return string the view path that may be prefixed to a relative view name.
     */
    public function renderConfigForm(ActiveForm $form);
}