<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\base;

use Yii;

/**
 * Component是实现  `property`、`event` 和 `behavior` 特性的基类。
 *
 * 除了 `property` 功能，这是在它的父类 [[\yii\base\Object|\yii\base\Object]] 中实现的，组件提供了 `event` 和 `behavior` 的特性。
 *
 * 事件（`Event`）是在现有代码的某个地方注入（`inject`）自定义代码的一种途径。
 * 
 * 例如，评论对象可以在用户添加评论的时候触发 `add` 事件。可以编写自定义代码并附加到此事件，以便当事件被触发时，自定义代码将被执行。
 * 
 * 事件是由在其定义的类中的唯一名称标识，事件名称不区分大小写（case-insensitive）。

 * 一个或者多个PHP回调，被称之为事件处理程序（`event handlers`），可以被附加到事件。可以调用 [[trigger()]] 引发事件。
 * 
 * 当一个事件被引发，事件处理程序（`event handlers`）将按照它们附加的顺序自动执行。
 * 
 * 将事件处理程序附加到事件，调用 [[on()]]：
 * 
 * ```php
 * $post->on('update', function ($event) {
 *     // send email notification
 * });
 * ```
 *
 * 由上面的代码片段可以看出，一个匿名方法被附加到 `update` 事件。可以附加以下类型的事件处理程序（`event handlers`）：
 *
 * - 匿名方法附加（anonymous function）： `function ($event) { ... }`
 * - 对象方法附加（object method）： `[$object, 'handleAdd']`
 * - 静态方法附加（static class method）： `['Page', 'handleAdd']`
 * - 全局方法附加（global function）： `'handleAdd'`
 *
 * 事件处理程序（`event handlers`）的签名格式如下：
 *
 * ```php
 * function foo($event)
 * ```
 *
 * 其中事件是包含与事件关联的参数的事件 [[Event]] 对象。
 *
 * 也可以通过配置数组将事件处理程序（`event handlers`）附加到事件。语法如下：
 *
 * ```php
 * [
 *     'on add' => function ($event) { ... }
 * ]
 * ```
 *
 * 其中 `on add` 代表将事件处理程序（`event handlers`）以匿名方法附加到 `add`事件。
 *
 * 有时，当事件处理程序（`event handlers`）附加到事件时，你可能希望将额外的数据与事件处理程序（`event handlers`）关联，
 * 
 * 然后在调用处理程序时访问它，可以使用如下方式：
 * 
 * ```php
 * $post->on('update', function ($event) {
 *     // the data can be accessed via $event->data
 * }, $data);
 * ```
 *
 * 行为（`Behavior`）是 [[Behavior]] 或其子类的实例。一个组件可以附加一个或多个行为，
 * 
 * 当行为被附加到组件后它的公共属性和方法可以通过组件直接访问，就像组件本身拥有这些属性和方法。
 * 
 * 附加行为到组件，在 [[behaviors()]] 声明它，或者显式的调用 [[attachBehavior]]。[[behaviors()]]中声明的行为会自动附加到组件。
 * 
 * 也可以通过配置数组将行为附加到组件。语法如下：
 *
 * ```php
 * [
 *     'as tree' => [
 *         'class' => 'Tree',
 *     ],
 * ]
 * ```
 * 
 * 其中 `as tree` 代表将一个名称为 `tree` 的行为附加到组件，此数组将被传递给 [[\Yii::createObject()]] 创造行为对象。
 *
 * 有关组件的详细信息和使用信息，请参阅《[关于组件的指南文章](guide:concept-components)》。
 * 
 * @property Behavior[] $behaviors 附加到此组件的行为列表。 此属性为只读。
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Component extends Object
{
    /**
     * @var array 附加的事件处理程序 (event name => handlers)
     */
    private $_events = [];
    /**
     * @var Behavior[]|null 附加的行为 (behavior name => behavior)， 没有初始化时为 `null`。
     */
    private $_behaviors;


    /**
     * 返回组件属性的值
     * 
     * 此方法将按下列顺序检查并执行：
     *
     *  - 由 `getter` 定义的属性： 返回属性的值
     *  - 行为的属性：返回行为的属性值
     *
     * 不要直接调用此方法，因为它是一个PHP魔术方法。执行 `$value = $component->property;` 将被隐式调用。
     * 
     * @param string $name 属性名称
     * @return mixed 属性值或行为属性值
     * @throws UnknownPropertyException 属性没有被定义，导致的异常
     * @throws InvalidCallException 只写属性，导致的异常
     * @see __set()
     */
    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            // read property, e.g. getName()
            return $this->$getter();
        }

        // behavior property
        $this->ensureBehaviors();
        foreach ($this->_behaviors as $behavior) {
            if ($behavior->canGetProperty($name)) {
                return $behavior->$name;
            }
        }

        if (method_exists($this, 'set' . $name)) {
            throw new InvalidCallException('Getting write-only property: ' . get_class($this) . '::' . $name);
        }

        throw new UnknownPropertyException('Getting unknown property: ' . get_class($this) . '::' . $name);
    }

    /**
     * 设置组件属性的值
     * 
     * 此方法将按下列顺序检查并执行：
     *
     *  - 由 `setter` 定义的属性：设置属性的值
     *  - "`on xyz`" 格式的事件：附加事件处理程序到 "`xyz`" 事件
     *  - "`as xyz`" 格式的行为：附加 "`xyz`" 行为
     *  - 行为的属性：设置行为的属性值
     *
     * 不要直接调用此方法，因为它是一个PHP魔术方法。执行 `$component->property = $value;` 将被隐式调用。
     * 
     * @param string $name 属性或事件名称
     * @param mixed $value 属性值
     * @throws UnknownPropertyException 属性没有被定义，导致的异常
     * @throws InvalidCallException 只读属性，导致的异常
     * @see __get()
     */
    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            // set property
            $this->$setter($value);

            return;
        } elseif (strncmp($name, 'on ', 3) === 0) {
            // on event: attach event handler
            $this->on(trim(substr($name, 3)), $value);

            return;
        } elseif (strncmp($name, 'as ', 3) === 0) {
            // as behavior: attach behavior
            $name = trim(substr($name, 3));
            $this->attachBehavior($name, $value instanceof Behavior ? $value : Yii::createObject($value));

            return;
        }

        // behavior property
        $this->ensureBehaviors();
        foreach ($this->_behaviors as $behavior) {
            if ($behavior->canSetProperty($name)) {
                $behavior->$name = $value;
                return;
            }
        }

        if (method_exists($this, 'get' . $name)) {
            throw new InvalidCallException('Setting read-only property: ' . get_class($this) . '::' . $name);
        }

        throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $name);
    }

    /**
     * 检查属性是否被设置，即定义了该属性并且不为 `null`
     * 
     * 此方法将按下列顺序检查并执行：
     * 
     *  - 由`setter` 定义的属性：返回属性是否被设置
     *  - 行为的属性：返回属性是否被设置
     *  - 返回 `false` 表明属性不存在，即没有被定义
     *
     * 不要直接调用这个方法，因为它是一个PHP魔术方法。执行 `isset($component->property);` 将被隐式调用。
     * 
     * @param string $name 属性或事件名称
     * @return bool 给定名称的属性是否被设置
     * @see http://php.net/manual/en/function.isset.php
     */
    public function __isset($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter() !== null;
        }

        // behavior property
        $this->ensureBehaviors();
        foreach ($this->_behaviors as $behavior) {
            if ($behavior->canGetProperty($name)) {
                return $behavior->$name !== null;
            }
        }

        return false;
    }

    /**
     * 将组件属性设置为空
     *
     * 此方法将按下列顺序检查并执行：
     *
     *  - 由`setter` 定义的属性：将属性值设置为 `null`
     *  - 行为的属性：将属性值设置为 `null`
     *
     * 不要直接调用这个方法，因为它是一个PHP魔术方法。执行 `unset($component->property);` 将被隐式调用。
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
            return;
        }

        // behavior property
        $this->ensureBehaviors();
        foreach ($this->_behaviors as $behavior) {
            if ($behavior->canSetProperty($name)) {
                $behavior->$name = null;
                return;
            }
        }

        throw new InvalidCallException('Unsetting an unknown or read-only property: ' . get_class($this) . '::' . $name);
    }

    /**
     * 调用不是类方法的方法
     *
     * 此方法将检查所有附加的行为是否有给定名称的方法，如果可用将执行它。
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
        $this->ensureBehaviors();
        foreach ($this->_behaviors as $object) {
            if ($object->hasMethod($name)) {
                return call_user_func_array([$object, $name], $params);
            }
        }
        throw new UnknownMethodException('Calling unknown method: ' . get_class($this) . "::$name()");
    }

    /**
     * 此方法是在现有对象被克隆之后调用
     * 
     * 它将移除所有的行为，因为它们是依附在被克隆的对象上（`old object`）。
     */
    public function __clone()
    {
        $this->_events = [];
        $this->_behaviors = null;
    }

    /**
     * 返回一个值，该值表明属性是否已经在组件中被定义
     * 
     * 以下情况表明属性已经被定义：
     *
     * - 在类中具有与给定名称关联的 `getter` 或者 `setter` 方法（这种情况下，属性名称不区分大小写）；
     * - 在类中具有给定名称的成员变量（当 `$checkVars` 为 `true`）；
     * - 在附加的行为中具有给定名称的属性（当 `$checkBehaviors` 为 `true`）
     *
     * @param string $name 属性名称
     * @param bool $checkVars 是否将成员变量视为属性
     * @param bool $checkBehaviors 是否将行为属性视为该组件的属性
     * @return bool 属性是否被定义
     * @see canGetProperty()
     * @see canSetProperty()
     */
    public function hasProperty($name, $checkVars = true, $checkBehaviors = true)
    {
        return $this->canGetProperty($name, $checkVars, $checkBehaviors) || $this->canSetProperty($name, false, $checkBehaviors);
    }

    /**
     * 返回一个值，该值表明是否可以读取属性
     * 
     * 以下情况表明属性为可读：
     *
     * - 在类中具有与给定名称关联的 `getter` 方法（这种情况下，属性名称不区分大小写）；
     * - 在类中具有给定名称的成员变量（当 `$checkVars` 为 `true`）；
     * - 在附加的行为中具有给定名称的可读属性 （当 `$checkBehaviors` 为 `true`）.
     *
     * @param string $name 属性名称
     * @param bool $checkVars 是否将成员变量视为属性
     * @param bool $checkBehaviors 是否将行为属性视为该组件的属性
     * @return bool 属性是否可读
     * @see canSetProperty()
     */
    public function canGetProperty($name, $checkVars = true, $checkBehaviors = true)
    {
        if (method_exists($this, 'get' . $name) || $checkVars && property_exists($this, $name)) {
            return true;
        } elseif ($checkBehaviors) {
            $this->ensureBehaviors();
            foreach ($this->_behaviors as $behavior) {
                if ($behavior->canGetProperty($name, $checkVars)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * 返回一个值，该值表明是否可以设置属性
     *
     * 以下情况表明属性为可写：
     * 
     * - 在类中具有与给定名称关联的 `setter`方法（这种情况下，属性名称不区分大小写）；
     * - 在类中具有给定名称的成员变量（当 `$checkVars` 为 `true`）；
     * - 在附加的行为中具有给定名称的可写属性 （当 `$checkBehaviors` 为 `true`）.
     *
     * @param string $name 属性名称
     * @param bool $checkVars 是否将成员变量视为属性
     * @param bool $checkBehaviors 是否将行为属性视为该组件的属性
     * @return bool 属性是否可写
     * @see canGetProperty()
     */
    public function canSetProperty($name, $checkVars = true, $checkBehaviors = true)
    {
        if (method_exists($this, 'set' . $name) || $checkVars && property_exists($this, $name)) {
            return true;
        } elseif ($checkBehaviors) {
            $this->ensureBehaviors();
            foreach ($this->_behaviors as $behavior) {
                if ($behavior->canSetProperty($name, $checkVars)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * 返回一个值，该值表明是否定义了给定名称的方法
     * 
     * 以下情况表明方法已经被定义：
     *
     * - 类中具有指定名称的方法
     * - 附加行为中具有给定名称的方法 （当 `$checkBehaviors` 为  `true`）。
     *
     * @param string $name 方法名称
     * @param bool $checkBehaviors 是否将行为方法视为该组件的方法
     * @return bool 此方法是否被定义
     */
    public function hasMethod($name, $checkBehaviors = true)
    {
        if (method_exists($this, $name)) {
            return true;
        } elseif ($checkBehaviors) {
            $this->ensureBehaviors();
            foreach ($this->_behaviors as $behavior) {
                if ($behavior->hasMethod($name)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * 返回该组件将会表现的行为清单
     *
     * 子类可以重写此方法，以指定它们想要表现的行为。
     *
     * 此方法的返回值应该是行为名称索引的行为对象或配置的数组。行为配置可以是由指定行为类的字符串，也可以是如下结构的数组：
     *
     * ```php
     * 'behaviorName' => [
     *     'class' => 'BehaviorClass',
     *     'property1' => 'value1',
     *     'property2' => 'value2',
     * ]
     * ```
     *
     * 注意：行为类必须继承与 [[Behavior]]，行为可以使用给定名称或匿名方式附加。
     * 
     * 当一个名称作为数组的键，可以使用这个名称通过 [[getBehavior()]] 进行行为的检索或者通过 [[detachBehavior()]]进行行为的分离，
     * 不能检索或分离匿名行为。
     *
     * 此方法中声明的行为将自动（按需）附加到组件。
     *
     * @return array 行为配置
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * 返回一个值，该值表明是否有事件处理程序附加到给定名称的事件
     * 
     * @param string $name 事件名称
     * @return bool 是否有事件处理程序附加到事件
     */
    public function hasEventHandlers($name)
    {
        $this->ensureBehaviors();
        return !empty($this->_events[$name]) || Event::hasHandlers($this, $name);
    }

    /**
     * 附加事件处理程序到事件
     *
     * 事件处理程序必须是有效的PHP回调方法，例如：
     *
     * ```
     * function ($event) { ... }         // anonymous function
     * [$object, 'handleClick']          // $object->handleClick()
     * ['Page', 'handleClick']           // Page::handleClick()
     * 'handleClick'                     // global function handleClick()
     * ```
     *
     *  事件处理程序（`event handlers`）的签名格式如下：
     *
     * ```
     * function ($event)
     * ```
     *
     * 其中事件是包含与事件关联的参数的事件 [[Event]] 对象。
     * 
     * @param string $name 事件名称
     * @param callable $handler 事件处理程序
     * @param mixed $data 当事件被触发时，传递给事件处理程序的数据。调用事件处理程序，可以通过 [[Event::data]] 访问这些数据。
     * @param bool $append 是否将新事件处理程序追加到现有处理程序列表的结尾。如果为 `false` ，新的处理程序将被插入在现有的处理程序列表的开头。
     * @see off()
     */
    public function on($name, $handler, $data = null, $append = true)
    {
        $this->ensureBehaviors();
        if ($append || empty($this->_events[$name])) {
            $this->_events[$name][] = [$handler, $data];
        } else {
            array_unshift($this->_events[$name], [$handler, $data]);
        }
    }

    /**
     * 将现有的事件处理程序（`event handlers`）从该组件中移除
     * 
     * 此方法跟 [[on()]] 相反。
     * 
     * @param string $name 事件名称
     * @param callable $handler 需要移除的事件处理程序（`event handlers`），如果为 `null`， 附加到给定名称事件的所有事件处理程序将被移除
     * @return bool 发现和移除事件处理程序（`event handlers`）
     * @see on()
     */
    public function off($name, $handler = null)
    {
        $this->ensureBehaviors();
        if (empty($this->_events[$name])) {
            return false;
        }
        if ($handler === null) {
            unset($this->_events[$name]);
            return true;
        }

        $removed = false;
        foreach ($this->_events[$name] as $i => $event) {
            if ($event[0] === $handler) {
                unset($this->_events[$name][$i]);
                $removed = true;
            }
        }
        if ($removed) {
            $this->_events[$name] = array_values($this->_events[$name]);
        }
        return $removed;
    }

    /**
     * 触发事件
     * 
     * 此方法用来触发事件。它调用包括事件级处理程序在内的所有附加处理程序。
     * @param string $name 事件名称
     * @param Event $event 事件参数，如果没有设置 ，将创建一个默认的 [[Event]] 对象
     */
    public function trigger($name, Event $event = null)
    {
        $this->ensureBehaviors();
        if (!empty($this->_events[$name])) {
            if ($event === null) {
                $event = new Event;
            }
            if ($event->sender === null) {
                $event->sender = $this;
            }
            $event->handled = false;
            $event->name = $name;
            foreach ($this->_events[$name] as $handler) {
                $event->data = $handler[1];
                call_user_func($handler[0], $event);
                // stop further handling if the event is handled
                if ($event->handled) {
                    return;
                }
            }
        }
        // invoke class-level attached handlers
        Event::trigger($this, $name, $event);
    }

    /**
     * 返回行为对象的名称
     * @param string $name 行为名称
     * @return null|Behavior 行为对象，如果行为对象不存在，则为 `null`
     */
    public function getBehavior($name)
    {
        $this->ensureBehaviors();
        return isset($this->_behaviors[$name]) ? $this->_behaviors[$name] : null;
    }

    /**
     * 返回附加到组件的所有行为
     * 
     * @return Behavior[] 附加到该组件的行为列表
     */
    public function getBehaviors()
    {
        $this->ensureBehaviors();
        return $this->_behaviors;
    }

    /**
     * 附加一个行为到组件
     *
     * 此方法将根据给定的配置创建行为对象。然后，行为对象将通过调用 [[Behavior::attach()]] 方法附加到组件。
     * 
     * @param string $name 行为名称
     * @param string|array|Behavior $behavior 行为配置。 可以是以下形式：
     *
     *  - [[Behavior]] 对象
     *  - 指定名称的行为类
     *  - 对象配置数组将通过 [[Yii::createObject()]] 创建行为对象
     *
     * @return Behavior 行为对象
     * @see detachBehavior()
     */
    public function attachBehavior($name, $behavior)
    {
        $this->ensureBehaviors();
        return $this->attachBehaviorInternal($name, $behavior);
    }

    /**
     * 附加一组行为列表到组件
     * 
     * 每个行为都按其名称进行索引，且应该是[[Behavior]]对象，指定行为类的字符串或配置数组来创建行为。
     * 
     * @param array $behaviors 要附加到组件的行为列表
     * @see attachBehavior()
     */
    public function attachBehaviors($behaviors)
    {
        $this->ensureBehaviors();
        foreach ($behaviors as $name => $behavior) {
            $this->attachBehaviorInternal($name, $behavior);
        }
    }

    /**
     * 分离组件的行为
     * 
     * 行为的方法 [[Behavior::detach()]] 将被调用
     * 
     * @param string $name 行为的名称
     * @return null|Behavior 分离行为，如果行为不存在，则为 `null`
     */
    public function detachBehavior($name)
    {
        $this->ensureBehaviors();
        if (isset($this->_behaviors[$name])) {
            $behavior = $this->_behaviors[$name];
            unset($this->_behaviors[$name]);
            $behavior->detach();
            return $behavior;
        }

        return null;
    }

    /**
     * 分离组件的所有行为
     */
    public function detachBehaviors()
    {
        $this->ensureBehaviors();
        foreach ($this->_behaviors as $name => $behavior) {
            $this->detachBehavior($name);
        }
    }

    /**
     * 确保 [[behaviors()]] 中声明的行为被附加到该组件
     */
    public function ensureBehaviors()
    {
        if ($this->_behaviors === null) {
            $this->_behaviors = [];
            foreach ($this->behaviors() as $name => $behavior) {
                $this->attachBehaviorInternal($name, $behavior);
            }
        }
    }

    /**
     * 附加行为到组件
     * 
     * @param string|int $name 行为的名称。如果为整数，则表示该行为是匿名的。否则，有和任何现有的行为名称相同的将被移除。
     * 
     * @param string|array|Behavior $behavior 被附加的行为
     * @return Behavior 附加行为
     */
    private function attachBehaviorInternal($name, $behavior)
    {
        if (!($behavior instanceof Behavior)) {
            $behavior = Yii::createObject($behavior);
        }
        if (is_int($name)) {
            $behavior->attach($this);
            $this->_behaviors[] = $behavior;
        } else {
            if (isset($this->_behaviors[$name])) {
                $this->_behaviors[$name]->detach();
            }
            $behavior->attach($this);
            $this->_behaviors[$name] = $behavior;
        }

        return $behavior;
    }
}