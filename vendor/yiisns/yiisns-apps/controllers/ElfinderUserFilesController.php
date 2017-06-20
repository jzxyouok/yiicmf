<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.04.2016
 */
namespace yiisns\apps\controllers;

use yiisns\rbac\SnsManager;

class ElfinderUserFilesController extends ElfinderController
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

        parent::init();

        \Yii::$app->toolbar->enabled = false;
    }
}