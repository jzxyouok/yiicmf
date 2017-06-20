<?php
/**
 * IResult
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 07.11.2016
 * @since 1.0.0
 */
namespace yiisns\sx\validate;

/**
 * Interface IResult
 * @package yiisns\sx\validate
 */
interface IResult
{
    /**
     * @return bool
     */
    function isValid();

    /**
     * @return array
     */
    function getErrorMessages();
}