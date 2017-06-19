<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.05.2016
 */
/* @var $this   yii\web\View */
/* @var $widget \yiisns\apps\appsWidgets\breadcrumbs\BreadcrumbsWidget */

?>
<? if (\Yii::$app->breadcrumbs->parts) : ?>
    <? $count = count(\Yii::$app->breadcrumbs->parts); ?>
    <? $counter = 0; ?>
    <ol class="breadcrumb pull-right">
        <? foreach (\Yii::$app->breadcrumbs->parts as $data) : ?>
            <? $counter ++; ?>
            <? if ($counter == $count): ?>
                <li class="active"><?= $data['name']; ?></li>
            <? else : ?>
                <li><a href="<?= $data['url']; ?>" title="<?= $data['name']; ?>"><?= $data['name']; ?></a></li>
            <? endif;?>
        <? endforeach; ?>
    </ol>
<? endif;?>