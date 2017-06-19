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
<section class="slice no-padding bg-white animate-hover-slide">
    <div class="wp-section work">
        <div class="container">


            <? if ($widget->label) : ?>
                <div class="section-title-wr">
                    <h3 class="section-title left">
                        <span><?= $widget->label; ?></span>
                    </h3>
                </div>

            <? endif; ?>

            <div class="row">
                <div id="ulSorList">

            <? if ($widget->enabledPjaxPagination = \yiisns\kernel\base\AppCore::BOOL_Y) : ?>
                <? \yiisns\admin\widgets\Pjax::begin(); ?>
            <? endif; ?>

            <? echo \yii\widgets\ListView::widget([
                'dataProvider'      => $widget->dataProvider,
                'itemView'          => 'publication-item',
                'emptyText'          => '',
                'options'           =>
                [
                ],
                'itemOptions' => [
                    'class'     => 'col-lg-3 col-md-3 col-sm-6',
                    'tag'       => 'div',
                ],
                'layout'            => "\n{items}\n<p class=\"row\">{pager}</p>"
            ])?>

            <? if ($widget->enabledPjaxPagination = \yiisns\kernel\base\AppCore::BOOL_Y) : ?>
                <? \yiisns\admin\widgets\Pjax::end(); ?>
            <? endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
