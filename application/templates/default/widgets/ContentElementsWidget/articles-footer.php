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


<!-- /Latest Blog Post -->
<h4 class="letter-spacing-1"><?= $widget->label; ?></h4>

<? echo \yii\widgets\ListView::widget([
    'dataProvider'      => $widget->dataProvider,
    'itemView'          => 'article-footer-item',
    'emptyText'          => '',
    'options'           =>
    [
        'tag'       => 'ul',
        'class'     => 'footer-posts list-unstyled',
    ],
    'itemOptions' => [
        'tag' => false
    ],
    'layout'            => "{items}"
])?>
