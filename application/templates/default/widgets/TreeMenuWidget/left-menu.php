<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.05.2016
 */
/* @var $this   yii\web\View */
/* @var $widget \yiisns\apps\appsWidgets\treeMenu\TreeMenuWidget */
/* @var $models  \yiisns\kernel\models\Tree[] */
?>
<div class="side-nav-head">
    <button class="fa fa-bars"></button>
    <h4><?= $widget->label; ?></h4>
</div>

<? if ($models = $widget->activeQuery->all()) : ?>
<ul class="list-group list-group-bordered list-group-noicon uppercase">
    <? foreach ($models as $model) : ?>
        <?= $this->render("_one-left", [
            "widget"        => $widget,
            "model"         => $model,
        ]); ?>
    <? endforeach; ?>
    </ul>
<? endif; ?>
