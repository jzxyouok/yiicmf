<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\di;

use Yii;
use Closure;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * ServiceLocator实现了一个[service locator]（http://en.wikipedia.org/wiki/Service_locator_pattern）。
 *
 * 使用定位器（ `ServiceLocator`），首先需要调用 [[set()]] 或者 [[setComponents()]] 注册一个与组件相应的组件ID。
 * 然后，可以通过调用 [[get()]] 获取具有指定ID的组件，定位器（ `ServiceLocator`）将根据定义自动实例化和配置组件。
 *
 * 例如：
 *
 * ```php
 * $locator = new \yii\di\ServiceLocator;
 * $locator->setComponents([
 *     'db' => [
 *         'class' => 'yii\db\Connection',
 *         'dsn' => 'sqlite:path/to/file.db',
 *     ],
 *     'cache' => [
 *         'class' => 'yii\caching\DbCache',
 *         'db' => 'db',
 *     ],
 * ]);
 *
 * $db = $locator->get('db');  // or $locator->db
 * $cache = $locator->get('cache');  // or $locator->cache
 * ```
 *
 * 因为 [[\yii\base\Module]] 继承于  ServiceLocator，所以 [[\yii\base\Module]] 和  [[\yii\base\Application]] 都是服务定位器。
 *
 * 更多的关于加载器 （`ServiceLocator`）信息，请参阅《[关于服务定位器的指南文章](guide:concept-service-locator)》。
 *
 * @property array $components 组件定义或加载的组件实例的列表（`ID => definition 或  ID => instance`）。
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ServiceLocator extends Component
{
    /**
     * @var array 由ID标识的共享组件实例
     */
    private $_components = [];
    /**
     * @var array 由ID标识的组件定义
     */
    private $_definitions = [];


    /**
     * Getter魔术方法
     * 
     * 此方法被重写以支持如读取属性一样的访问组件。
     * 
     * @param string $name 组件或属性名称
     * @return mixed 命名的属性值
     */
    public function __get($name)
    {
        if ($this->has($name)) {
            return $this->get($name);
        } else {
            return parent::__get($name);
        }
    }

    /**
     * 检查属性值是否为空（`null`）
     * 
     * 此方法通过重写以实现检查命名组件是否被加载
     * 
     * @param string $name 属性或事件名称
     * @return bool 属性值是否为空（`null`）
     */
    public function __isset($name)
    {
        if ($this->has($name)) {
            return true;
        } else {
            return parent::__isset($name);
        }
    }

    /**
     * 返回一个值, 指示定位器是否具有指定的组件定义或已实例化该组件
     * 
     * 此方法可能会根据  `$checkInstance` 的值返回不同的结果。
     *
     * - 如果 `$checkInstance` 默认值为 `false` , 该方法将返回一个值, 指示定位器是否具有指定的组件定义。
     * - 如果 `$checkInstance` 为 `true`, 则该方法将返回一个值, 指示定位器是否已实例化指定的组件。
     *
     * @param string 组件ID（例如：`db`）
     * @param bool $checkInstance 该方法是否应该检查组件是否被共享和实例化
     * @return bool 定位器是否具有指定的组件定义或已实例化该组件
     * 
     * @see set()
     */
    public function has($id, $checkInstance = false)
    {
        return $checkInstance ? isset($this->_components[$id]) : isset($this->_definitions[$id]);
    }

    /**
     * 返回指定ID的组件实例
     *
     * @param string $id 组件ID（例如：`db`）
     * @param bool $throwException 如果 `$id` 未在定位器之前注册，是否抛出异常
     * @return object|null 指定ID的组件。如果 `$throwException` 为 `false` 并且 `$id` 未被注册，则返回 `null`
     * @throws InvalidConfigException 如果 `$id` 是指不存在的组件ID，导致的异常
     * @see has()
     * @see set()
     */
    public function get($id, $throwException = true)
    {
        if (isset($this->_components[$id])) {
            return $this->_components[$id];
        }

        if (isset($this->_definitions[$id])) {
            $definition = $this->_definitions[$id];
            if (is_object($definition) && !$definition instanceof Closure) {
                return $this->_components[$id] = $definition;
            } else {
                return $this->_components[$id] = Yii::createObject($definition);
            }
        } elseif ($throwException) {
            throw new InvalidConfigException("Unknown component ID: $id");
        } else {
            return null;
        }
    }

    /**
     * 使用定位器注册组件定义
     *
     * 例如：
     *
     * ```php
     * // a class name
     * $locator->set('cache', 'yii\caching\FileCache');
     *
     * // a configuration array
     * $locator->set('db', [
     *     'class' => 'yii\db\Connection',
     *     'dsn' => 'mysql:host=127.0.0.1;dbname=demo',
     *     'username' => 'root',
     *     'password' => '',
     *     'charset' => 'utf8',
     * ]);
     *
     * // an anonymous function
     * $locator->set('cache', function ($params) {
     *     return new \yii\caching\FileCache;
     * });
     *
     * // an instance
     * $locator->set('cache', new \yii\caching\FileCache);
     * ```
     *
     * 如果已经存在相同ID的组件定义，它将被覆盖。
     *
     * @param string $id 组件ID （例如：`db`）
     * @param mixed $definition 要向该定位器注册的组件定义
     * 
     * 它可以是一下形式之一：
     *
     * - a class name
     * - a configuration array：该数组包含名 `name-value` 值对，它将用于在调用 [[get()]] 方法时初始化新创建的对象的属性值。 `class`元素是必需的，代表要创建的对象的类。
     * - a PHP callable：无论是匿名函数还是表示类方法的数组（例如：`['Foo'，'bar']`）。 这种回调将被[[get()]]调用返回与指定的组件ID相关联的对象。
     * - an object：当调用 [[get()]] 方法时，将返回此对象。
     *
     * @throws InvalidConfigException 如果定义是无效的配置数组，导致的异常
     */
    public function set($id, $definition)
    {
        if ($definition === null) {
            unset($this->_components[$id], $this->_definitions[$id]);
            return;
        }

        unset($this->_components[$id]);

        if (is_object($definition) || is_callable($definition, true)) {
            // an object, a class name, or a PHP callable
            $this->_definitions[$id] = $definition;
        } elseif (is_array($definition)) {
            // a configuration array
            if (isset($definition['class'])) {
                $this->_definitions[$id] = $definition;
            } else {
                throw new InvalidConfigException("The configuration for the \"$id\" component must contain a \"class\" element.");
            }
        } else {
            throw new InvalidConfigException("Unexpected configuration type for the \"$id\" component: " . gettype($definition));
        }
    }

    /**
     * 从定位器移除组件
     * 
     * @param string $id 组件ID
     */
    public function clear($id)
    {
        unset($this->_definitions[$id], $this->_components[$id]);
    }

    /**
     * 返回组件定义或加载的组件实例的列表。
     * 
     * @param bool $returnDefinitions 是否返回组件的定义而不是加载的组件实例
     * @return array 组件定义或加载的组件实例的列表 （`ID => definition` 或 `ID => instance`）。
     */
    public function getComponents($returnDefinitions = true)
    {
        return $returnDefinitions ? $this->_definitions : $this->_components;
    }

    /**
     * 在此定位器中注册一组组件的定义
     *
     * 这是 [[set()]] 的批量版本，参数应该是一个数组，其`键(key)`表示组件ID，`值(value)`表示相应的组件定义。
     *
     * 有关如何指定组件ID和定义的更多详细信息，请参见[[set()]]。
     *
     * 如果已经存在相同ID的组件定义，它将被覆盖。
     *
     * 以下是注册两个组件定义的示例：
     *
     * ```php
     * [
     *     'db' => [
     *         'class' => 'yii\db\Connection',
     *         'dsn' => 'sqlite:path/to/file.db',
     *     ],
     *     'cache' => [
     *         'class' => 'yii\caching\DbCache',
     *         'db' => 'db',
     *     ],
     * ]
     * ```
     *
     * @param array $components 组件的定义或实例
     */
    public function setComponents($components)
    {
        foreach ($components as $id => $component) {
            $this->set($id, $component);
        }
    }
}