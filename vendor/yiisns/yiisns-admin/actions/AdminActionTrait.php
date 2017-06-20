<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.05.2016
 */
namespace yiisns\admin\actions;

use yii\base\Action;
use yii\web\NotFoundHttpException;
/**
 * 
 *
 * Class AdminActionTrait
 * @package yiisns\admin\actions
 */
trait AdminActionTrait
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $icon;

    /**
     * @var string
     */
    public $confirm = '';

    /**
     * @var string
     */
    public $method  = 'get';

    /**
     * @var string
     */
    public $request = ''; //ajax

    /**
     * @var bool
     */
    public $visible = true;

    /**
     * @var int
     */
    public $priority = 100;
}