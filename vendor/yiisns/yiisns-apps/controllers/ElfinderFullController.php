<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.04.2016
 */
namespace yiisns\apps\controllers;

use yiisns\rbac\SnsManager;

class ElfinderFullController extends ElfinderController
{
    public function init()
    {
        $this->roots = [];

        if (\Yii::$app->user->can(SnsManager::PERMISSION_ELFINDER_USER_FILES))
        {
            $this->roots[] =
            [
                'class' => 'yiisns\apps\helpers\elfinder\UserPath',
                'path'  => 'uploads/users/{id}',
                'name'  => \Yii::t('yiisns/kernel', 'Personal files'),
            ];
        }

        if (\Yii::$app->user->can(SnsManager::PERMISSION_ELFINDER_COMMON_PUBLIC_FILES))
        {
            $this->roots[] =
            [
                'path'  => 'uploads/inbox',
                'name'  => \Yii::t('yiisns/kernel', 'Common files'),
            ];
        }


        if (\Yii::$app->user->can(SnsManager::PERMISSION_ELFINDER_ADDITIONAL_FILES))
        {
            $this->roots[] =
            [
                'basePath'  =>  ROOT_DIR,
                'path'      => '/',
                'name'      => \Yii::t('yiisns/kernel', 'ROOT_DIR'),
            ];

            $this->roots[] =
            [
                'baseUrl'   =>'@web',
                'basePath'  =>'@webroot',
                'path'      => '/',
                'name'      => \Yii::t('yiisns/kernel', 'System Resource (robots.txt)'),
            ];
        }

        parent::init();

        \Yii::$app->toolbar->enabled = false;
    }
}