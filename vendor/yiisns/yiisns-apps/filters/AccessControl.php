<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.10.2016
 */
namespace yiisns\apps\filters;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\apps\helpers\UrlHelper;
use yii\web\User;
use yii\web\ForbiddenHttpException;

/**
 * Class AdminAccessControl
 * @package yiisns\apps\filters
 */
class AccessControl extends \yii\filters\AccessControl
{
    /**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     * @param User $user the current user
     * @throws ForbiddenHttpException if the user is already logged in.
     */
    protected function denyAccess($user)
    {
        $rr = new RequestResponse();

        if ($user->getIsGuest())
        {
            $authUrl = UrlHelper::construct(['/apps/auth/login'])->setCurrentRef()->createUrl();

            if (\Yii::$app->request->isAjax && !\Yii::$app->request->isPjax)
            {
                \Yii::$app->getResponse()->redirect($authUrl);
                $rr->redirect = $authUrl;
                return (array) $rr;
            } else
            {
                \Yii::$app->getResponse()->redirect($authUrl);
            }

        } else
        {
            throw new ForbiddenHttpException(\Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }
}