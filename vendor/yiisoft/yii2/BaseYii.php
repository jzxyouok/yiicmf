<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii;

use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\base\UnknownClassException;
use yii\log\Logger;
use yii\di\Container;

/**
 * 获取应用程序的启动时间戳。
 */
defined('YII_BEGIN_TIME') or define('YII_BEGIN_TIME', microtime(true));
/**
 * 该常量定义了框架的安装目录。
 */
defined('YII2_PATH') or define('YII2_PATH', __DIR__);
/**
 * 该常量定义了应用程序是否处于调试模式，默认为 `false`。
 */
defined('YII_DEBUG') or define('YII_DEBUG', false);
/**
 * 该常数定义应用程序运行的环境。默认为'prod'，表明是生产环境。
 * 可以在引导脚本中定义此常量。其值可能是 'prod'、'dev'、'test'、'staging' 等等
 */
defined('YII_ENV') or define('YII_ENV', 'prod');
/**
 * 该常量指明应用程序是否在生产环境中运行。
 */
defined('YII_ENV_PROD') or define('YII_ENV_PROD', YII_ENV === 'prod');
/**
 * 该常量指明应用程序是否在开发环境中运行。
 */
defined('YII_ENV_DEV') or define('YII_ENV_DEV', YII_ENV === 'dev');
/**
 * 该常量指明应用程序是否在测试环境中运行。
 */
defined('YII_ENV_TEST') or define('YII_ENV_TEST', YII_ENV === 'test');

/**
 * 该常量指明是否启用错误处理程序，默认为 `true`。
 */
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER', true);

/**
 * BaseYii是YiiFramework的核心辅助类。
 *
 * 不要直接使用BaseYii。相反，使用其子类 [[\Yii]] 可以替代BaseYii。
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BaseYii
{
    /**
     * @var array 使用Yii自动加载机制加载类地图。
     * 
     * 该数组的键是类名（无反斜杠开头），与数组值对应的类文件路径（或路径的别名）。此属性主要影响[[autoload()]]如何工作。
     * 
     * @see autoload()
     */
    public static $classMap = [];
    /**
     * @var \yii\console\Application|\yii\web\Application 应用程序实例
     */
    public static $app;
    /**
     * @var array 注册路径别名
     * @see getAlias()
     * @see setAlias()
     */
    public static $aliases = ['@yii' => __DIR__];
    /**
     * @var Container 由 [[createObject()]] 使用的依赖注入（DI）容器，可以使用 [[Container::set()]] 创建所需要依赖的类及其初始属性值。
     * 
     * @see createObject()
     * @see Container
     */
    public static $container;


    /**
     * 返回一个字符串，表明框架的当前版本。
     * @return string 框架的当前版本
     */
    public static function getVersion()
    {
        return '2.0.11.2';
    }

    /**
     * 将路径别名转换为实际路径
     *
     * 转换是按照以下步骤完成的：
     *
     * 1. 如果给定别名没有以 '@' 开始，则无任何变化的返回；
     * 2. 否则，查找与给定别名的开头部分匹配的最长注册别名。
     *    如果存在，则将给定别名的匹配部分与相应的注册路径进行替换。
     * 3. 根据 `$throwException` 参数抛出异常或者返回 `false` 。
     *
     * 例如：默认情况下 '@yii' 注册为Yii框架目录的别名，因此被转换成  `/path/to/yii`。 别名 `@yii/web` 将被转换成 `/path/to/yii/web`。
     *
     * 如果注册了两个别名分  `@foo` 和 `@foo/bar`。这里 `@foo/bar/config` 将使用 `@foo/bar` （而不是 `@foo`）取代与之注册路径的相应部分，这是因为最长的别名优先。
     *
     * 然而，如果别名要转换的是 `@foo/barbar/config`，然后 `@foo` 将代替 `@foo/bar` ，因为别名是以`'/'`作为边界特征。
     * 
     * 请注意：此方法不检查返回的路径是否存在。
     * 
     * 示例代码如下：
     * 
     * ```php
     * use Yii;
     * 
     * Yii::setAlias('app', 'G:/wwwroot/vendor');
     * Yii::setAlias('app/web', 'G:/wwwroot');
     * 
     * echo Yii::getAlias('@app/web/index');     //返回真实路径为：'G:/wwwroot/index'
     * ```
     *
     * @param string $alias 需要被转换的路径别名
     * @param bool $throwException 如果给定的别名无效，是否引发异常。如果为 `false`，并给出无效别名，则将返回 `false`
     * @return string|bool 与别名对应的路径，如果别名未被注册，则为 `false`
     * @throws InvalidParamException 当 `$throwException` 为 `true` 时，如果别名无效。导致的异常
     * @see setAlias()
     */
    public static function getAlias($alias, $throwException = true)
    {
        if (strncmp($alias, '@', 1)) {
            // not an alias
            return $alias;
        }

        $pos = strpos($alias, '/');
        $root = $pos === false ? $alias : substr($alias, 0, $pos);

        if (isset(static::$aliases[$root])) {
            if (is_string(static::$aliases[$root])) {
                return $pos === false ? static::$aliases[$root] : static::$aliases[$root] . substr($alias, $pos);
            }

            foreach (static::$aliases[$root] as $name => $path) {
                if (strpos($alias . '/', $name . '/') === 0) {
                    return $path . substr($alias, strlen($name));
                }
            }
        }

        if ($throwException) {
            throw new InvalidParamException("Invalid path alias: $alias");
        }

        return false;
    }

    /**
     * 返回给定别名的根别名部分
     * 
     * 根别名是已经通过 [[setAlias()]] 注册过的别名。如果给定别名匹配多个根别名，则返回最长的别名。
     * 
     * 示例代码如下：
     * 
     * ```php
     * use Yii;
     * 
     * Yii::setAlias('app', 'G:/wwwroot/vendor');
     * Yii::setAlias('app/web', 'G:/wwwroot');
     * 
     * echo Yii::getRootAlias('@app/web/index');  //返回根别名为：'@app/web'
     * ```
     * 
     * 以上代码中定义了两个别名分别是 `@app` 和 `@app/web`，由于最长别名优先原则，`@app/web/index` 的根别名则返回  `@app/web`。
     * 
     * @param string $alias 给定别名
     * @return string|bool 根别名，如果未找到根别名，则返回 `false`
     */
    public static function getRootAlias($alias)
    {
        $pos = strpos($alias, '/');
        $root = $pos === false ? $alias : substr($alias, 0, $pos);

        if (isset(static::$aliases[$root])) {
            if (is_string(static::$aliases[$root])) {
                return $root;
            }

            foreach (static::$aliases[$root] as $name => $path) {
                if (strpos($alias . '/', $name . '/') === 0) {
                    return $name;
                }
            }
        }

        return false;
    }

    /**
     * 注册别名路径
     *
     * 路径别名是表示一个长路径（a file path, a URL, etc.）的短名称。
     * 
     * 例如：使用 `@yii` 的别名表示YiiFramework目录的路径。
     *
     * 路径别名必须以字符 `@` 开始，以便它可以很容易地区别于非别名路径。
     *
     * 请注意，此方法不检查给定路径是否存在。它所做的就是将别名与路径关联起来。
     *
     * 在给定的路径中，任何结尾的 `/`和 `\`字符将被去除。
     *
     * @param string $alias 别名（例如 `@yii`）。 必须以 `@` 字符开始，它可能包含 `/` ，当通过 [[getAlias()]] 时作为边界
     * @param string $path 与别名对应的路径。 如果为 `null`，别名将被删除。尾部的`/`和 `\`字符将被去除，这个可以是：
     * 
     * - a directory or a file path （例如： `/tmp`, `/tmp/main.txt`）
     * - a URL （例如： `http://www.yiiframework.com`）
     * - a path alias （例如： `@yii/base`）。在这种情况下，路径别名将首先通过调用 [[getAlias()]] 转化为实际路径。
     *
     * @throws InvalidParamException 如果 `$path` 不是一个有效的别名
     * @see getAlias()
     */
    public static function setAlias($alias, $path)
    {
        if (strncmp($alias, '@', 1)) {
            $alias = '@' . $alias;
        }
        $pos = strpos($alias, '/');
        $root = $pos === false ? $alias : substr($alias, 0, $pos);
        if ($path !== null) {
            $path = strncmp($path, '@', 1) ? rtrim($path, '\\/') : static::getAlias($path);
            if (!isset(static::$aliases[$root])) {
                if ($pos === false) {
                    static::$aliases[$root] = $path;
                } else {
                    static::$aliases[$root] = [$alias => $path];
                }
            } elseif (is_string(static::$aliases[$root])) {
                if ($pos === false) {
                    static::$aliases[$root] = $path;
                } else {
                    static::$aliases[$root] = [
                        $alias => $path,
                        $root => static::$aliases[$root],
                    ];
                }
            } else {
                static::$aliases[$root][$alias] = $path;
                krsort(static::$aliases[$root]);
            }
        } elseif (isset(static::$aliases[$root])) {
            if (is_array(static::$aliases[$root])) {
                unset(static::$aliases[$root][$alias]);
            } elseif ($pos === false) {
                unset(static::$aliases[$root]);
            }
        }
    }

    /**
     * 类自动加载器
     * 
     * 当PHP遇到一个未知类时，该方法会自动调用。该方法将尝试根据以下过程来包含类文件：
     *
     * 1. 在 [[classMap]] 中进行搜索查找;
     * 2. 如果该类的命名空间（例如：`yii\base\Component`） ，它将尝试包含文件与相应的路径别名（例如：`@yii/base/Component.php`）。
     * 
     * 自动加载器允许加载按照[PSR-4 standard](http://www.php-fig.org/psr/psr-4/)，拥有顶级命名空间或子命名空间定义为路径别名的类。
     *
     * 例如： 当别名`@yii` 和 `@yii/bootstrap` 同时被定义，在 `yii\bootstrap` 命名空间的类将用`@yii/bootstrap` 别名指向该目录
     *
     * 参见 [guide section on autoloading](guide:concept-autoloading).
     *
     * @param string $className 没有 `\` 的完全限定名
     * @throws UnknownClassException 如果类在类文件中不存在，导致的异常
     */
    public static function autoload($className)
    {
        if (isset(static::$classMap[$className])) {
            $classFile = static::$classMap[$className];
            if ($classFile[0] === '@') {
                $classFile = static::getAlias($classFile);
            }
        } elseif (strpos($className, '\\') !== false) {
            $classFile = static::getAlias('@' . str_replace('\\', '/', $className) . '.php', false);
            if ($classFile === false || !is_file($classFile)) {
                return;
            }
        } else {
            return;
        }

        include($classFile);

        if (YII_DEBUG && !class_exists($className, false) && !interface_exists($className, false) && !trait_exists($className, false)) {
            throw new UnknownClassException("Unable to find '$className' in file: $classFile. Namespace missing?");
        }
    }

    /**
     * 使用给定的配置创建对象
     *
     * 可以将此方法视为 `new` 运算符的增强版本。该方法支持创建基于类名、配置数组、匿名函数的对象。
     *
     * 示例代码如下：
     *
     * ```php
     * // 使用类名创建对象
     * $object = Yii::createObject('yii\db\Connection');
     *
     * // 使用配置数组创建对象
     * $object = Yii::createObject([
     *     'class' => 'yii\db\Connection',
     *     'dsn' => 'mysql:host=127.0.0.1;dbname=demo',
     *     'username' => 'root',
     *     'password' => '',
     *     'charset' => 'utf8',
     * ]);
     *
     * // 创建具有两个参数的构造函数的对象
     * $object = \Yii::createObject('MyClass', [$param1, $param2]);
     * ```
     *
     * 使用[[\yii\di\Container|dependency injection container]]，该方法还可以识别相关依赖对象，实例化他们并将它们注入到新创建的对象。
     *
     * @param string|array|callable $type 对象类型，可以用下列其中一种形式指定：
     *
     * - a string: 表示要创建对象的类名
     * - a configuration array: 数组必须包含一个 `class` 元素，代表要创建的对象的类，其余的 `name-value` 对将用于初始化相应的对象属性
     * - a PHP callable: 无论是匿名方法还是代表类方法的数组（例如：`[$class or $object, $method]`），这种回调都将返回一个创建对象的实例。
     *
     * @param array $params 构造函数参数
     * @return object 创建的对象
     * @throws InvalidConfigException 配置无效，导致的异常
     * @see \yii\di\Container
     */
    public static function createObject($type, array $params = [])
    {
        if (is_string($type)) {
            return static::$container->get($type, $params);
        } elseif (is_array($type) && isset($type['class'])) {
            $class = $type['class'];
            unset($type['class']);
            return static::$container->get($class, $params, $type);
        } elseif (is_callable($type, true)) {
            return static::$container->invoke($type, $params);
        } elseif (is_array($type)) {
            throw new InvalidConfigException('Object configuration must be an array containing a "class" element.');
        }

        throw new InvalidConfigException('Unsupported configuration type: ' . gettype($type));
    }

    private static $_logger;

    /**
     * 获取 `logger` 对象
     * @return 日志消息记录器
     */
    public static function getLogger()
    {
        if (self::$_logger !== null) {
            return self::$_logger;
        }

        return self::$_logger = static::createObject('yii\log\Logger');
    }

    /**
     * 设置 `logger` 对象
     * @param Logger $logger `logger` 对象
     */
    public static function setLogger($logger)
    {
        self::$_logger = $logger;
    }

    /**
     * 记录跟踪消息
     * 
     * 跟踪消息主要用于开发目的，查看一些代码工作的执行流程。
     * 
     * @param string|array $message 需要记录的消息，这可以是一个简单的字符串或更复杂的数据结构，例如数组
     * @param string $category 日志消息的类别
     */
    public static function trace($message, $category = 'application')
    {
        if (YII_DEBUG) {
            static::getLogger()->log($message, Logger::LEVEL_TRACE, $category);
        }
    }

    /**
     * 记录错误消息
     * 
     * 错误消息，通常是记录一个应用程序在执行过程中发生不可恢复的错误时的消息。
     * 
     * @param string|array $message 需要记录的消息，这可以是一个简单的字符串或更复杂的数据结构，例如数组
     * @param string $category 日志消息的类别
     */
    public static function error($message, $category = 'application')
    {
        static::getLogger()->log($message, Logger::LEVEL_ERROR, $category);
    }

    /**
     * 记录警告消息
     * 
     * 当出现错误时任然能够继续执行时，通常会记录警告消息。
     * 
     * @param string|array $message 需要记录的消息，这可以是一个简单的字符串或更复杂的数据结构，例如数组
     * @param string $category 日志消息的类别
     */
    public static function warning($message, $category = 'application')
    {
        static::getLogger()->log($message, Logger::LEVEL_WARNING, $category);
    }

    /**
     * 记录普通消息
     * 
     * 通常记录应用程序重要的信息 （例如：管理员登录情况）。
     * 
     * @param string|array $message 需要记录的消息，这可以是一个简单的字符串或更复杂的数据结构，例如数组
     * @param string $category 日志消息的类别
     */
    public static function info($message, $category = 'application')
    {
        static::getLogger()->log($message, Logger::LEVEL_INFO, $category);
    }

    /**
     * 标记用于分析的代码块的开头
     * 
     * 必须与调用的 [[endProfile]] 类别名称相匹配。
     * 
     * `begin-` 和 `end-` 的调用必须正确嵌套。例如：
     *
     * ```php
     * \Yii::beginProfile('block1');
     * // some code to be profiled
     *     \Yii::beginProfile('block2');
     *     // some other code to be profiled
     *     \Yii::endProfile('block2');
     * \Yii::endProfile('block1');
     * ```
     * @param string $token 代码块的令牌
     * @param string $category 日志消息的类别
     * @see endProfile()
     */
    public static function beginProfile($token, $category = 'application')
    {
        static::getLogger()->log($token, Logger::LEVEL_PROFILE_BEGIN, $category);
    }

    /**
     * 标记用于分析的代码块的结尾
     * 
     * 必须与前一次调用的 [[beginProfile]] 类别名称相匹配。
     * 
     * @param string $token 代码块的令牌
     * @param string $category 日志消息的类别
     * @see beginProfile()
     */
    public static function endProfile($token, $category = 'application')
    {
        static::getLogger()->log($token, Logger::LEVEL_PROFILE_END, $category);
    }

    /**
     * 返回一个HTML链接，用于在网页上显示 `Powered by XXX` 信息
     * @return string 一个HTML链接，用于在网页上显示 `Powered by XXX` 信息
     * 
     */
    public static function powered()
    {
        return \Yii::t('yii', 'Powered by {yii}', [
            'yii' => '<a href="http://www.yiiframework.com/" rel="external">' . \Yii::t('yii',
                    'Yii Framework') . '</a>'
        ]);
    }

    /**
     * 将文本消息转换为指定语言的消息
     *
     * 这是 [[\yii\i18n\I18N::translate()]] 的快捷方式。
     * 
     * 将根据消息类别进行翻译，目标语言将被使用。
     *
     * 可以将参数添加到将在翻译后替换相应值的翻译消息中。参数名称周围使用大括号的格式，如下面示例所示：
     *
     * ```php
     * $username = 'Alexander';
     * echo \Yii::t('app', 'Hello, {username}!', ['username' => $username]);
     * ```
     *
     * 更多的格式化消息支持参数是使用[PHP intl extensions](http://www.php.net/manual/en/intro.intl.php) ，详细描述，请参见 [[\yii\i18n\I18N::translate()]]。
     *
     * @param string $category 消息类别
     * @param string $message 将被翻译的消息
     * @param array $params 该参数将被用来取代消息中的相应的占位符
     * @param string $language 目标语言代码 （例如：`en-US`, `zh-cn`）。如果不存在（为 `null`），将使用当前语言[[\yii\base\Application::language|application language]]
     * @return string 目标语言消息
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        if (static::$app !== null) {
            return static::$app->getI18n()->translate($category, $message, $params, $language ?: static::$app->language);
        }

        $placeholders = [];
        foreach ((array) $params as $name => $value) {
            $placeholders['{' . $name . '}'] = $value;
        }

        return ($placeholders === []) ? $message : strtr($message, $placeholders);
    }

    /**
     * 使用初始值配置对象
     * 
     * @param object $object 需要配置的对象
     * @param array $properties 以 `name-value` 对给出的属性初始值
     * @return object 对象本身
     */
    public static function configure($object, $properties)
    {
        foreach ($properties as $name => $value) {
            $object->$name = $value;
        }

        return $object;
    }

    /**
     * 返回对象的公共成员变量
     * 
     * 通过该方法可以得到一个对象的公共成员变量，它不同于 `get_object_vars()`，因为如果它在对象本身里面，后者将返回所有的变量包括私有的和受保护的变量。
     * 
     * @param object $object 需要处理的对象
     * @return array 对象的公共成员变量
     */
    public static function getObjectVars($object)
    {
        return get_object_vars($object);
    }
}