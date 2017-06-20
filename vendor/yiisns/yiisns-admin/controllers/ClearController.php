<?php
/**
 * ClearController
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 08.11.2016
 * @since 1.0.0
 */
namespace yiisns\admin\controllers;

use yiisns\apps\helpers\UrlHelper;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\controllers\helpers\rules\NoModel;
use yiisns\sx\Dir;

use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class IndexController
 * @package yiisns\admin\controllers
 */
class ClearController extends AdminController
{
    public function init()
    {
        $this->name = \Yii::t('yiisns/kernel', 'Deleting temporary files');
        parent::init();
    }

    public function actions()
    {
        return
        [
            'index' =>
            [
                'class' => AdminAction::className(),
                'name' => \Yii::t('yiisns/kernel', 'Clearing temporary data'),
                'callback' => [$this, 'actionIndex'],
            ],
        ];
    }

    public function actionIndex()
    {
        $paths = ArrayHelper::getValue(\Yii::$app->appCore->tmpFolderScheme, 'runtime');

        $clearDirs = [];

        if ($paths)
        {
            foreach ($paths as $path)
            {
                $clearDirs[] = [
                    'label'         => 'Directory of runtime',
                    'dir'           => new Dir(\Yii::getAlias($path), false)
                ];

                $clearDirs[] = [
                    'label'         => 'Directory of logs',
                    'dir'           => new Dir(\Yii::getAlias($path . "/logs"), false)
                ];

                $clearDirs[] = [
                    'label'         => 'Directory of cache',
                    'dir'           => new Dir(\Yii::getAlias($path . "/cache"), false)
                ];

                $clearDirs[] = [
                    'label'         => 'Directory of debug',
                    'dir'           => new Dir(\Yii::getAlias($path . "/debug"), false)
                ];
            }
        }

        $rr = new RequestResponse();
        if ($rr->isRequestAjaxPost())
        {
            foreach ($clearDirs as $data)
            {
                $dir = ArrayHelper::getValue($data, 'dir');
                if ($dir instanceof Dir)
                {
                    if ($dir->isExist())
                    {
                        $dir->clear();
                    }
                }
            }
            \Yii::$app->db->getSchema()->refresh();
            \Yii::$app->cache->flush();
            \Yii::$app->appCore->generateTmpConfig();
            \Yii::$app->appCore->generateTmpConsoleConfig();

            $rr->success = true;
            $rr->message = \Yii::t('yiisns/kernel', 'Cache cleared');
            return $rr;
        }

        return $this->render('index', [
            'clearDirs' => $clearDirs,
        ]);
    }
}