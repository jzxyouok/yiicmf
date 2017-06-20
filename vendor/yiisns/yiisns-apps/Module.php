<?php
/**
 * Module
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.10.2016
 * @since 1.0.0
 */
namespace yiisns\apps;

use yiisns\admin\components\UrlRule;

use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\web\Application;
use yii\web\View;

/**
 * Class Module
 * @package yiisns\kernel
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'yiisns\apps\controllers';
}