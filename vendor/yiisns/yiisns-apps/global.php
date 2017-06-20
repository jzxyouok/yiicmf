<?php
/**
 * Defined global constants
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.02.2016
 * @since 1.0.0
 */
defined('APP_CONFIG_DIR') or die('Please specify the constant \'APP_CONFIG_DIR\' in index.php in your application.');

defined('ROOT_DIR') or die('Please specify the constant "ROOT_DIR" in index.php in your application.');

defined('VENDOR_DIR') or define('VENDOR_DIR', ROOT_DIR . '/vendor');

defined('COMMON_CONFIG_DIR') or define('COMMON_CONFIG_DIR', ROOT_DIR . '/common/config');

define("TMP_CONFIG_FILE_EXTENSIONS", VENDOR_DIR . '/yiisns/tmp-config-extensions.php' );

define("TMP_CONSOLE_CONFIG_FILE_EXTENSIONS", VENDOR_DIR . '/yiisns/tmp-console-config-extensions.php' );

defined('APP_ENV_GLOBAL_FILE') or define('APP_ENV_GLOBAL_FILE', ROOT_DIR . '/global.php');

$globalFileInited = APP_ENV_GLOBAL_FILE;
if (file_exists($globalFileInited))
{
    require $globalFileInited;
}

if (!defined('YII_ENV'))
{
    define('YII_ENV', 'prod');
}

define('COMMON_ENV_CONFIG_DIR', COMMON_CONFIG_DIR . '/env/' . YII_ENV);
define('APP_ENV_CONFIG_DIR',    APP_CONFIG_DIR . '/env/' . YII_ENV);

if (!defined('YII_DEBUG'))
{
    $envGlobal = COMMON_ENV_CONFIG_DIR . '/global.php';

    if (file_exists($envGlobal))
    {
        include $envGlobal;
    }
}

if (!defined('YII_DEBUG'))
{
    $envGlobal = COMMON_CONFIG_DIR . '/global.php';

    if (file_exists($envGlobal))
    {
        include $envGlobal;
    }
}

if (!defined('YII_DEBUG'))
{
    if (YII_ENV == 'prod')
    {
        defined('YII_DEBUG') or define('YII_DEBUG', false);
    } else
    {
        defined('YII_DEBUG') or define('YII_DEBUG', true);
    }
}