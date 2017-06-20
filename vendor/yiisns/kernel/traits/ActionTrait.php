<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.05.2016
 */
namespace yiisns\kernel\traits;

use yii\base\Action;
use yii\web\NotFoundHttpException;

/**
 * Class ActionTrait
 * 
 * @package yiisns\kernel\traits
 */
trait ActionTrait
{
    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string icon
     */
    public $icon;

    /**
     *
     * @var string
     */
    public $confirm = '';

    /**
     *
     * @var string
     */
    public $method = 'get';

    /**
     *
     * @var string
     */
    public $request = '';

    /**
     *
     * @var bool
     */
    public $visible = true;

    /**
     *
     * @var int
     */
    public $priority = 100;
}