<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 17.02.2016
 */
/* @var $this yii\web\View */
/* @var $widget \yiisns\admin\dashboards\ContentElementListDashboard */
$this->registerCss(<<<CSS
.sx-content-element-list .sx-table-additional
{
    padding: 0 15px;
}

.sx-content-element-list .sx-content-element-list-controlls
{
    padding-top: 0px;
    padding-bottom: 15px;
    padding-left: 15px;
    padding-right: 15px;
}
CSS
)
?>

<div class="row sx-content-element-list">
    <div class="col-md-12 col-lg-12">

        <?= \yiisns\admin\widgets\GridView::widget([
            'dataProvider'  => $widget->dataProvider,
            'filterModel'   => $widget->search->loadedModel,
            'columns' => [
                [
                    'class'                 => \yiisns\admin\grid\ActionColumn::className(),
                    'controller'            => \Yii::$app->createController('/admin/admin-content-element')[0],
                    'isOpenNewWindow'       => 1
                ],
                [
                    'class' => \yiisns\kernel\grid\ImageColumn2::className(),
                ],
                'name',

                [
                    'class'     => \yii\grid\DataColumn::className(),
                    'value'     => function(\yiisns\kernel\models\ContentElement $model)
                    {

                        return \yii\helpers\Html::a('<i class="glyphicon glyphicon-arrow-right"></i>', $model->absoluteUrl, [
                            'target' => '_blank',
                            'title' => \Yii::t('yiisns/kernel', 'Watch to site (opens new window)'),
                            'data-pjax' => '0',
                            'class' => 'btn btn-default btn-sm'
                        ]);

                    },
                    'format' => 'raw'
                ]
            ],
        ]); ?>

    </div>


    <? if (count($widget->content_ids) == 1) : ?>
    <?
        $contentId = array_shift($widget->content_ids);
        /**
         * @var $content \yiisns\kernel\models\Content
         */
        $content = \yiisns\kernel\models\Content::findOne($contentId)
    ?>
    <div class="col-md-12">
        <div class="sx-content-element-list-controlls">
            <a href="<?= \yiisns\apps\helpers\UrlHelper::construct(['/admin/admin-content-element', 'content_id' => $contentId])?>" data-pjax="0" class="btn btn-primary">
                <i class="glyphicon glyphicon-th-list"></i> <?/*= $content->name_meny */?> Все записи
            </a>

            <a href="<?= \yiisns\apps\helpers\UrlHelper::construct(['/admin/admin-content-element/create', 'content_id' => $contentId])?>" data-pjax="0" class="btn btn-primary">
                <i class="glyphicon glyphicon-plus"></i> <?/*= $content->name_meny */?> Добавить
            </a>
        </div>
    </div>
    <? endif; ?>
</div>