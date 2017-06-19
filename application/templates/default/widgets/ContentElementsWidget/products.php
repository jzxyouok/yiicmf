<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.05.2016
 */
/* @var $this   yii\web\View */
/* @var $widget \yiisns\apps\appsWidgets\contentElements\ContentElementsWidget */
?>
<? if ($widget->label) : ?>
    <h1 class="size-17 margin-bottom-20"><?= $widget->label; ?></h1>
<? endif; ?>

<? if ($widget->enabledPjaxPagination = \yiisns\kernel\base\AppCore::BOOL_Y) : ?>
    <? \yiisns\admin\widgets\Pjax::begin(); ?>
<? endif; ?>

<? echo \yii\widgets\ListView::widget([
    'dataProvider'      => $widget->dataProvider,
    'itemView'          => 'product-item',
    'emptyText'          => '',
    'options'           =>
    [
        'class'   => 'shop-item-list row list-inline nomargin',
        'tag'   => 'ul',
    ],
    'itemOptions' => [
        'tag' => false
    ],
    'layout'            => "\n{items}{$summary}\n<p class=\"row\">{pager}</p>"
])?>

<? if ($widget->enabledPjaxPagination = \yiisns\kernel\base\AppCore::BOOL_Y) : ?>
    <? \yiisns\admin\widgets\Pjax::end(); ?>
<? endif; ?>