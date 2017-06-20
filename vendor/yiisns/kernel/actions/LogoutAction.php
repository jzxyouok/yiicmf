<?php
/**
 * LogoutAction
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 05.11.2016
 * @since 1.0.0
 */
namespace yiisns\kernel\actions;

use yiisns\apps\helpers\UrlHelper;

use Yii;
use yii\base\Action;

/**
 * Class ErrorAction
 * 
 * @package yiisns\kernel\actions
 */
class LogoutAction extends Action
{
    /**
     *  用户退出动作
     */
    public function run()
    {
        Yii::$app->user->logout();
        if ($ref = UrlHelper::getCurrent()->getRef()) {
            return \Yii::$app->getResponse()->redirect($ref);
        } else {
            return \Yii::$app->getResponse()->redirect(\Yii::$app->getUser()
                ->getReturnUrl());
        }
    }
}