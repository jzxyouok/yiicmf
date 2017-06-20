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

<div class="headline"><h2><?= $widget->label; ?></h2></div>

<? echo \yii\widgets\ListView::widget([
    'dataProvider'      => $widget->dataProvider,
    'itemView'          => '_widget-item',
    'emptyText'          => '',
    'options'           =>
    [
        'tag'       => 'ul',
        'class'     => 'list-unstyled link-list',
    ],
    'itemOptions' => [
        'tag' => false
    ],
    'layout'            => "\n{items}{summary}\n<p class=\"row\">{pager}</p>"
])?>
