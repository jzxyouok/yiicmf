<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016 YiiSNS
 * @date 30.05.2016
 */
namespace yiisns\admin\controllers;

use yiisns\apps\helpers\UrlHelper;

use yiisns\kernel\models\Search;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\controllers\helpers\rules\NoModel;
use yiisns\sx\Dir;
use yiisns\sx\File;

use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class InfoController
 * 
 * @package yiisns\admin\controllers
 */
class InfoController extends AdminController
{
    public function init()
    {
        $this->name = \Yii::t('yiisns/kernel', 'Information about the system');
        
        parent::init();
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => AdminAction::className(),
                'name' => \Yii::t('yiisns/kernel', 'General information'),
                'viewParams' => $this->indexData()
            ]
        ];
    }

    public function indexData()
    {
        return [
            'phpVersion' => PHP_VERSION,
            'yiiVersion' => \Yii::getVersion(),
            'application' => [
                'yii' => \Yii::getVersion(),
                'name' => \Yii::$app->appSettings->appName,
                'env' => YII_ENV,
                'debug' => YII_DEBUG
            ],
            'php' => [
                'version' => PHP_VERSION,
                'xdebug' => extension_loaded('xdebug'),
                'apc' => extension_loaded('apc'),
                'memcache' => extension_loaded('memcache'),
                'xcache' => extension_loaded('xcache'),
                'imagick' => extension_loaded('imagick'),
                'gd' => extension_loaded('gd')
            ],
            'extensions' => $this->getExtensions()
        ];
    }

    public function actionPhp()
    {
        phpinfo();
        die();
    }

    /**
     * 
     * @return \yii\web\Response
     */
    public function actionUpdateModulesFile()
    {
        if (\Yii::$app->appCore->generateTmpConfig() && \Yii::$app->appCore->generateTmpConsoleConfig()) {
            \Yii::$app->session->setFlash('success', \Yii::t('yiisns/kernel', 'File, automatic paths to the modules successfully updated'));
        } else {
            \Yii::$app->session->setFlash('error', \Yii::t('yiisns/kernel', 'File, automatic paths to the modules are not updated'));
        }
        
        return $this->redirect(\Yii::$app->request->getReferrer());
    }

    /**
     * 
     * @return \yii\web\Response
     */
    public function actionWriteEnvGlobalFile()
    {
        $env = (string) \Yii::$app->request->get('env');
        if (! $env) {
            \Yii::$app->session->setFlash('error', \Yii::t('yiisns/kernel', 'Not Specified Places to record'));
            return $this->redirect(\Yii::$app->request->getReferrer());
        }
        
        $content = <<<PHP
<?php
defined('YII_ENV') or define('YII_ENV', '{$env}');
PHP;
        
        $file = new File(APP_ENV_GLOBAL_FILE);
        if ($file->write($content)) {
            \Yii::$app->session->setFlash('success', \Yii::t('yiisns/kernel', 'File successfully created and written'));
        } else {
            \Yii::$app->session->setFlash('error', \Yii::t('yiisns/kernel', 'Failed to write file'));
        }
        
        return $this->redirect(\Yii::$app->request->getReferrer());
    }

    public function actionRemoveEnvGlobalFile()
    {
        $file = new File(APP_ENV_GLOBAL_FILE);
        if ($file->remove()) {
            \Yii::$app->session->setFlash('success', \Yii::t('yiisns/kernel', 'File deleted successfully'));
        } else {
            \Yii::$app->session->setFlash('error', \Yii::t('yiisns/kernel', 'Could not delete the file'));
        }
        
        return $this->redirect(\Yii::$app->request->getReferrer());
    }

    /**
     * Returns data about extensions
     *
     * @return array
     */
    public function getExtensions()
    {
        $data = [];
        foreach (\Yii::$app->extensions as $extension) {
            $data[$extension['name']] = $extension['version'];
        }       
        return $data;
    }
}