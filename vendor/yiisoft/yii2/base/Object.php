<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\base;

use Yii;

/**
 * Object是实现  `property` 特性的基类。
 * 
 * 属性是一个定义了getter方法（例如： `getLabel`）和/或setter方法（例如： `setLabel`）。例如：
 * 下面的  getter 和  setter 方法定义了一个名称为 `label` 的属性。
 * 
 * ```php
 * private $_label;          // 声明一个私有变量：$_label
 *
 * public function getLabel()
 * {
 *     return $this->_label;
 * }
 *
 * public function setLabel($value)
 * {
 *     $this->_label = $value;
 * }
 * ```
 *
 * 属性名称不区分大小写（case-insensitive）。
 *
 * 
 * 属性可以像对象的成员变量一样的访问。读取或写入属性会使相应的 `getter` 或者 `setter` 方法被调用。例如：
 * 
 * ```php
 * $label = $object->label;   // 等同于  $label = $object->getLabel();
 * 
 * $object->label = 'abc';    // 等同于  $object->setLabel('abc');
 * ```
 *
 * 如果属性只有 `getter` 方法而没有 `setter` 方法，那么它就被认为是 `只读` 属性。
 * 在这样的情况下，如果修改此属性值会导致异常。
 *
 * 调用 [[hasProperty()]], [[canGetProperty()]] 和/或 [[canSetProperty()]] 检查属性是否存在。
 *
 * 除了属性特性，对象还引入了重要的对象初始化生命周期。特别地，创建对象或派生类的新实例将依次包含下列生命周期：
 * 
 * 1、调用类的构造函数；
 * 
 * 2、根据给定的配置初始化对象属性；
 * 
 * 3、`init()` 方法被调用。
 *
 * 由上面可以看出，步骤2和步骤3都发生在类的构造函数结尾。
 * 建议您在 `init()` 方法内完成对象的初始化。因为在那个阶段，对象配置已经应用。
 * 
 * 为了确保上述生命周期，如果对象的子类需要重写构造函数，它应该这样做如下：
 *
 * ```php
 * public function __construct($param1, $param2, ..., $config = [])
 * {
 *     ...
 *     parent::__construct($config);
 * }
 * ```
 *
 * 也就是说，`$config` 参数（默认为`[]`）应声明为构造函数的最后一个参数，并且父实现应该在构造函数的末尾调用。
 * 
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Object implements Configurable
{
    /**
     * 返回当前类的完全限定名称
     * 
     * @return string 当前类的完全限定名称
     */
    public static function className()
    {
        return get_called_class();
    }

    /**
     * 构造函数
     * 
     * 默认做两件事情：
     *
     * - 使用给定的配置 `$config` 初始化对象。
     * - 调用 [[init()]]。
     *
     * 如果此方法被子类重写，建议：
     *
     * - 构造函数的最后一个参数是一个配置数组，就像这里的 `$config`。
     * - 在构造函数的结尾调用父类 [[init()]] 方法。
     *
     * @param array $config 用于初始化对象属性的 `键-值` 对。
     */
    public function __construct($config = [])
    {
        if (!empty($config)) {
            Yii::configure($this, $config);
        }
        $this->init();
    }

    /**
     * 初始化对象
     * 
     * 使用给定配置初始化对象后，在构造函数的结尾调用此方法。
     */
    public function init() { }

    /**
     * 返回对象属性的值
     *
     * 不要直接调用此方法，因为它是一个PHP魔术方法。执行 `$value = $object->property;` 将被隐式调用。
     * 
     * @param string $name 属性名称
     * @return mixed 属性值
     * @throws UnknownPropertyException 属性没有被定义，导致的异常
     * @throws InvalidCallException 只写属性，导致的异常
     * @see __set()
     */
    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } elseif (method_exists($this, 'set' . $name)) {
            throw new InvalidCallException('Getting write-only property: ' . get_class($this) . '::' . $name);
        } else {
            throw new UnknownPropertyException('Getting unknown property: ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * 设置对象属性的值
     *
     * 不要直接调用此方法，因为它是一个PHP魔术方法。执行 `$object->property = $value;` 将被隐式调用。
     * 
     * @param string $name 属性或者事件名称
     * @param mixed $value 属性值
     * @throws UnknownPropertyException 属性没有被定义，导致的异常
     * @throws InvalidCallException 只读属性，导致的异常
     * @see __get()
     */
    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } elseif (method_exists($this, 'get' . $name)) {
            throw new InvalidCallException('Setting read-only property: ' . get_class($this) . '::' . $name);
        } else {
            throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * 检查属性是否被设置，即定义了该属性并且不为 `null`
     * 
     * 不要直接调用这个方法，因为它是一个PHP魔术方法。执行 `isset($object->property);` 将被隐式调用。
     *
     * 注意：如果属性没有被定义，将返回 `false`。
     * 
     * @param string $name 属性或者事件名称
     * @return bool 属性名称是否被定义 `(not null)`。
     * @see http://php.net/manual/en/function.isset.php
     */
    public function __isset($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter() !== null;
        } else {
            return false;
        }
    }

    /**
     * 将对象属性设置为空
     *
     * 不要直接调用这个方法，因为它是一个PHP魔术方法。执行 `unset($object->property);` 将被隐式调用。
     *
     * 注意：如果属性没有被定义，此方法将不做任何处理。
     * 如果此属性为只读属性，将会导致异常。
     * 
     * @param string $name 属性名称
     * @throws InvalidCallException 只读属性，导致的异常
     * @see http://php.net/manual/en/function.unset.php
     */
    public function __unset($name)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter(null);
        } elseif (method_exists($this, 'get' . $name)) {
            throw new InvalidCallException('Unsetting read-only property: ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * 调用不是类方法的方法
     *
     * 不要直接调用这个方法，因为它是一个PHP魔术方法。当调用未知方法时将隐式调用。
     * 
     * @param string $name 方法名称
     * @param array $params 方法参数
     * @throws UnknownMethodException 方法不存在时，导致的异常
     * @return mixed 返回方法执行后的值
     */
    public function __call($name, $params)
    {
        throw new UnknownMethodException('Calling unknown method: ' . get_class($this) . "::$name()");
    }

    /**
     * 返回一个值，该值表明属性是否已经被定义
     * 
     * 以下情况表明属性已经被定义：
     *
     * - 在类中具有与给定名称关联的 `getter` 或者 `setter` 方法（这种情况下，属性名称不区分大小写）；
     * - 在类中具有给定名称的成员变量（当 `$checkVars` 为 `true`）；
     * 
     * @param string $name 属性名称
     * @param bool $checkVars 是否将成员变量视为属性
     * @return bool 属性是否被定义
     * @see canGetProperty()
     * @see canSetProperty()
     */
    public function hasProperty($name, $checkVars = true)
    {
        return $this->canGetProperty($name, $checkVars) || $this->canSetProperty($name, false);
    }

    /**
     * 返回一个值，该值表明是否可以读取属性
     * 
     * 以下情况表明属性为可读：
     *
     * - 在类中具有与给定名称关联的 `getter`方法（这种情况下，属性名称不区分大小写）；
     * - 在类中具有给定名称的成员变量（当 `$checkVars` 为 `true`）；
     *
     * @param string $name 属性名称
     * @param bool $checkVars 是否将成员变量视为属性
     * @return bool 属性是否可读
     * @see canSetProperty()
     */
    public function canGetProperty($name, $checkVars = true)
    {
        return method_exists($this, 'get' . $name) || $checkVars && property_exists($this, $name);
    }

    /**
     * 返回一个值，该值表明是否可以设置属性
     * 
     * 以下情况表明属性为可写：
     *
     * - 在类中具有与给定名称关联的 `setter`方法（这种情况下，属性名称不区分大小写）；
     * - 在类中具有给定名称的成员变量（当 `$checkVars` 为 `true`）；
     *
     * @param string $name 属性名称
     * @param bool $checkVars 是否将成员变量视为属性
     * @return bool 属性是否可写
     * @see canGetProperty()
     */
    public function canSetProperty($name, $checkVars = true)
    {
        return method_exists($this, 'set' . $name) || $checkVars && property_exists($this, $name);
    }

    /**
     * 返回一个值，该值表明是否定义了给定名称的方法
     *
     * 默认实现是对PHP函数 `method_exists()` 的调用 。
     * 
     * 当实现了PHP魔术方法 `__call()` 时，可以重写此方法。
     * 
     * @param string $name 方法名称
     * @return bool 此方法是否被定义
     */
    public function hasMethod($name)
    {
        return method_exists($this, $name);
    }
}