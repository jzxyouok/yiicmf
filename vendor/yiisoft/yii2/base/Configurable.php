<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\base;

/**
 * Configurable是一个由支持通过构造函数最后一个参数来配置其属性的类来实现的接口。
 * 
 * 此接口不声明任何方法。 实现此接口的类必须声明它们的构造函数如下：
 *
 * ```php
 * public function __constructor($param1, $param2, ..., $config = [])
 * ```
 *
 * 也就是说，构造函数的最后一个参数必须接受一个可配置数组。
 *
 * 此接口主要由 [[\yii\di\Container]] 使用 ，以便将对象配置作为最后一个参数传递给实现类的构造函数。
 *
 * 有关配置的更多详细信息和使用信息 [guide article on configurations](guide:concept-configurations)。
 * 
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0.3
 */
interface Configurable
{
}