<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.04.2016
 */
namespace yiisns\apps\helpers\elfinder;

use yiisns\rbac\SnsManager;
use Yii;

class UserPath extends \mihaildev\elfinder\UserPath
{
    public function isAvailable()
    {
        if (!\Yii::$app->user->can(SnsManager::PERMISSION_ELFINDER_USER_FILES))
        {
            return false;
        }

        return parent::isAvailable();
    }
}