<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.03.2016
 */
namespace yiisns\admin\filters;

use yiisns\apps\helpers\UrlHelper;

use yiisns\kernel\helpers\RequestResponse;

use yii\web\User;
use yii\web\ForbiddenHttpException;

/**
 * Class AdminLastActivityAccessControl
 * 
 * @package yiisns\admin\filters
 */
class AdminLastActivityAccessControl extends \yii\filters\AccessControl
{
    /**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     * 
     * @param User $user the current user
     * @throws ForbiddenHttpException if the user is already logged in.
     */
    protected function denyAccess($user)
    {
        $rr = new RequestResponse();
        
        if (! $user->getIsGuest()) {
            $authUrl = UrlHelper::construct('admin/auth/blocked')->setCurrentRef()
                ->enableAdmin()
                ->createUrl();
            
            if (\Yii::$app->request->isAjax && ! \Yii::$app->request->isPjax) {
                $rr->redirect = $authUrl;
                return (array) $rr;
            } else {
                \Yii::$app->getResponse()->redirect($authUrl);
            }
        } else {
            throw new ForbiddenHttpException(\Yii::t('yii', \Yii::t('yiisns/kernel', 'You are not allowed to perform this action.')));
        }
    }
}