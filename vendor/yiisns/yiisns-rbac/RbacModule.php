<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.04.2016
 */
namespace yiisns\rbac;

/**
 * Class RbacModule
 *
 * @package yiisns\kernel\rbac
 */
class RbacModule extends \yii\base\Module
{
    /**
     * 当前模块控制器的命名空间，如果不设置此属性，程序将会指定当前命名空间+ `controllers`为控制器默认命名空间
     * 
     * @var string
     */
    public $controllerNamespace = 'yiisns\rbac\controllers';
}