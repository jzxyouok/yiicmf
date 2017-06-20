<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.02.2016
 */
namespace yiisns\logDbTarget;

use yiisns\admin\components\UrlRule;
use yii\base\Event;
use yii\web\Application;
use yii\web\View;

/**
 * Class ConsoleModule
 * @package yiisns\logDbTarget
 */
class ConsoleModule extends Module
{
    public $controllerNamespace = 'yiisns\logDbTarget\console\controllers';
}