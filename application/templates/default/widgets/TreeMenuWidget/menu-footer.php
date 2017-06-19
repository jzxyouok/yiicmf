<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.05.2016
 */
/* @var $this   yii\web\View */
/* @var $widget \yiisns\apps\appsWidgets\treeMenu\TreeMenuWidget */
/* @var $trees  \yiisns\kernel\models\Tree[] */
?>
<h4 ><?= $widget->label; ?></h4>
<ul class="footer-links list-unstyled">
    <? if ($trees = $widget->activeQuery->all()) : ?>
        <? foreach ($trees as $tree) : ?>
            <?= $this->render("_one-footer", [
                "widget"        => $widget,
                "model"         => $tree,
            ]); ?>
        <? endforeach; ?>
    <? endif; ?>
</ul>