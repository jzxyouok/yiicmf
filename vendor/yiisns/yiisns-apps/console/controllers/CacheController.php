<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.03.2016
 */

namespace yiisns\apps\console\controllers;

use yiisns\apps\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;

/**
 * Allows you to flush cache.
 *
 * see list of available components to flush:
 *
 *     yii apps/cache
 *
 * flush particular components specified by their names:
 *
 *     yii apps/cache/flush first second third
 *
 * flush all cache components that can be found in the system
 *
 *     yii apps/cache/flush-all
 *
 *
 *     yii apps/cache/flush-runtimes
 *     yii apps/cache/flush-assets
 *     yii apps/cache/flush-tmp-config
 *
 * Note that the command uses cache components defined in your console application configuration file. If components
 * configured are different from web application, web application cache won't be cleared. In order to fix it please
 * duplicate web application cache components in console config. You can use any component names.
 *
 * @since 2.0
 */
class CacheController extends \yii\console\controllers\CacheController
{
    /**
     * Clear rintimes directories
     */
    public function actionFlushRuntimes()
    {
        $paths = ArrayHelper::getValue(\Yii::$app->appCore->tmpFolderScheme, 'runtime');


        $this->stdout("Clear runtimes directories\n", Console::FG_YELLOW);

        if ($paths)
        {
            foreach ($paths as $path)
            {
                $realPath = \Yii::getAlias($path);
                $this->stdout("\tClear runtime directory: {$realPath}\n");
                FileHelper::removeDirectory(\Yii::getAlias($path));
                FileHelper::createDirectory(\Yii::getAlias($path));
            }
        }

        //It is important to the proper configuration is cached differently
        \Yii::$app->appCore->generateTmpConsoleConfig();
        \Yii::$app->appCore->generateTmpConfig();
    }

    /**
     * Clear asstes directories
     */
    public function actionFlushAssets()
    {
        $paths = ArrayHelper::getValue(\Yii::$app->appCore->tmpFolderScheme, 'assets');
        $this->stdout("Clear assets directories\n", Console::FG_YELLOW);

        if ($paths)
        {
            foreach ($paths as $path)
            {
                $realPath = \Yii::getAlias($path);
                $this->stdout("\tClear asset directory: {$realPath}\n");
                FileHelper::removeDirectory(\Yii::getAlias($path));
                FileHelper::createDirectory(\Yii::getAlias($path));
            }
        }
    }

    public function actionFlushTmpConfig()
    {
        \Yii::$app->appCore->generateTmpConfig();
        \Yii::$app->appCore->generateTmpConsoleConfig();
        $this->stdout("Clear tmp config file success\n");
    }
}