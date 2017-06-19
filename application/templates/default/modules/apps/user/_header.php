<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.03.2016
 */
/* @var $this yii\web\View */
/* @var $model \common\models\User */

use yii\helpers\Html;
use yiisns\apps\base\widgets\ActiveFormAjaxSubmit as ActiveForm;
use yiisns\apps\helpers\UrlHelper;

//$this->title = $model->getDisplayName() . ' / ' . $title;
$this->title = $model->username;
\Yii::$app->breadcrumbs->createBase()->append([
    'name' => $model->displayName,
    'url'  => $model->getPageUrl()
]);
?>

<?= $this->render('@template/include/breadcrumbs', [
    'model' => $model
])?>

<!--=== Content Part ===-->
<div class="container content profile sx-profile">
    <div class="row">
        <div class="col-md-3 md-margin-bottom-40">
            <? if ($model->image) : ?>
                <img class="img-responsive profile-img margin-bottom-20" src="<?= \yiisns\apps\helpers\Image::getSrc($model->image->src); ?>" alt="">
            <? else : ?>
                <img class="img-responsive profile-img margin-bottom-20" src="<?= \yiisns\apps\helpers\Image::getSrc(); ?>" alt="">
            <? endif; ?>

            <ul class="list-group sidebar-nav-v1 margin-bottom-40" id="sidebar-nav-1">

                <li class="list-group-item <?= \Yii::$app->controller->action->id == 'view' ? "active": ""?>">
                    <a href="<?= $model->getPageUrl('view')?>"><i class="glyphicon glyphicon-calendar"></i> Profile</a>
                </li>

                <? if (!\Yii::$app->user->isGuest && \Yii::$app->user->identity->id == $model->id) : ?>

                    <li class="list-group-item <?= \Yii::$app->controller->action->id == 'edit' ? "active": ""?>">
                        <a href="<?= $model->getPageUrl('edit')?>"><i class="fa fa-cog"></i> Settings</a>
                    </li>

                    <li class="list-group-item">
                        <a href="<?= \yiisns\apps\helpers\UrlHelper::construct('apps/auth/logout')->setRef('/'); ?>" data-method="post"><i class="glyphicon glyphicon-off"></i> Exit</a>
                    </li>

                <? endif; ?>

            </ul>


        </div>


        <div class="col-md-9">
            <div class="profile-body">

                <?/* \yiisns\admin\widgets\Pjax::begin([
                    'linkSelector' => '.sx-profile a',
                    'blockContainer' => '.profile-body'
                ]); */?>


