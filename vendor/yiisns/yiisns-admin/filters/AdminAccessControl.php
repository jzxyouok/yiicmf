<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 31.05.2016
 */
namespace yiisns\admin\filters;

use yiisns\apps\helpers\UrlHelper;

use yiisns\kernel\helpers\RequestResponse;

use yii\web\User;
use yii\web\ForbiddenHttpException;

/**
 * Class AdminAccessControl
 * 
 * @package yiisns\admin\filters
 */
class AdminAccessControl extends \yii\filters\AccessControl
{
    /**
     * 拒绝用户的访问。
     * 默认的实现将重定向到登录页面，如果是访客;
     * 如果用户已经登录，则会抛出403 HTTP异常。
     * 
     * @param User $user 当前用户
     * @throws ForbiddenHttpException 如果用户已经登录
     */
    protected function denyAccess($user)
    {
        $rr = new RequestResponse();
        
        if ($user->getIsGuest()) {
            $authUrl = UrlHelper::construct('admin/auth')->setCurrentRef()
                ->enableAdmin()
                ->createUrl();
            
            if (\Yii::$app->request->isAjax && ! \Yii::$app->request->isPjax) {
                $rr->redirect = $authUrl;
                return (array) $rr;
            } else {
                \Yii::$app->getResponse()->redirect($authUrl);
            }
        } else {
            throw new ForbiddenHttpException(\Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }
}