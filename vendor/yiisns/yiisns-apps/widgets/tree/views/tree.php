<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 18.12.2016
 */
/* @var $this yii\web\View */
/* @var $widget \yiisns\apps\widgets\tree\TreeWidget */
$widget = $this->context;
?>
<div class="row">
    <div class="sx-container-tree col-md-12">
        <?= \yii\helpers\Html::beginTag("div", $widget->options); ?>
            <?= $widget->renderNodes($widget->models); ?>
        <?= \yii\helpers\Html::endTag("div"); ?>
    </div>
</div>