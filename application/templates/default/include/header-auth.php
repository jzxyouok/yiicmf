<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.03.2016
 */
/* @var $this \yii\web\View */
?>

<ul class="top-links list-inline pull-right">
<? if (\Yii::$app->user->isGuest) : ?>
    <li><a href="<?= \yiisns\apps\helpers\UrlHelper::construct('apps/auth/login')->setCurrentRef(); ?>"><i class="fa fa-user"></i> Authorization / Registration</a></li>
<? else : ?>
    <li class="text-welcome hidden-xs">
        Welcome to, <strong><?= \Yii::$app->user->identity->displayName; ?></strong>
    </li>
    <li>
        <a class="dropdown-toggle no-text-underline" data-toggle="dropdown" href="#"><i class="fa fa-user hidden-xs"></i> My Account</a>
        <ul class="dropdown-menu pull-right">
            <li><a tabindex="-1" href="#"><i class="fa fa-history"></i> ORDER HISTORY</a></li>
            <li class="divider"></li>
            <li><a tabindex="-1" href="#"><i class="fa fa-bookmark"></i> MY WISHLIST</a></li>
            <li><a tabindex="-1" href="#"><i class="fa fa-edit"></i> MY REVIEWS</a></li>
            <li><a tabindex="-1" href="<?= \Yii::$app->user->identity->getPageUrl('edit'); ?>"><i class="fa fa-cog"></i> Settings</a></li>
            <li class="divider"></li>
            <li><a href="<?= \yiisns\apps\helpers\UrlHelper::construct('apps/auth/logout')->setCurrentRef(); ?>" data-method="post"><span class="glyphicon glyphicon-off"></span> Exit</a></li>
        </ul>
    </li>
<? endif; ?>
</ul>