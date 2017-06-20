<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 18.06.2016
 */
namespace yiisns\apps\console\controllers;

use yiisns\apps\components\AppSettings;
use yiisns\kernel\models\Agent;
use yiisns\kernel\models\SearchPhrase;
use yiisns\kernel\models\StorageFile;
use yiisns\sx\Dir;

use Yii;
use yii\base\Event;
use yii\console\Controller;
use yii\console\controllers\HelpController;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\helpers\FileHelper;

/**
 *
 * @package yiisns\kernel\console\controllers
 */
class UtilsController extends Controller
{
    public function actionAllCmd()
    {
        /**
         * @var $controllerHelp HelpController
         */
        $controllerHelp = \Yii::$app->createController('help')[0];
        $commands = $controllerHelp->getCommands();

        foreach ($controllerHelp->getCommands() as $controller)
        {
            $subController = \Yii::$app->createController($controller)[0];
            $actions = $controllerHelp->getActions($subController);

            if ($actions)
            {
                foreach ($actions as $actionId)
                {
                    $commands[] = $controller . "/" . $actionId;
                }
            }
        };

        $this->stdout(implode("\n", $commands));
    }

    public function actionClearAllThumbnails()
    {
        /**
         * @var $files StorageFile[]
         */
        if ($files = StorageFile::find()->all())
        {
            foreach ($files as $file)
            {
                $file->deleteTmpDir();
            }
        }
    }
}