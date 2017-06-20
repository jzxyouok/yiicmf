<?php
/**
 * index
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.10.2014
 * @since 1.0.0
 */

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\Game */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<?= \yiisns\admin\widgets\GridViewHasSettings::widget([
    'dataProvider'  => $dataProvider,
    'filterModel'   => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'class'         => \yiisns\admin\grid\ActionColumn::className(),
            'controller'    => $controller
        ]

        /*['class' => \yiisns\kernel\grid\ImageColumn::className()]*/,

        'groupname',
        'description',


        ['class' => \yiisns\kernel\grid\CreatedAtColumn::className()],
        ['class' => \yiisns\kernel\grid\UpdatedAtColumn::className()],

        ['class' => \yiisns\kernel\grid\CreatedByColumn::className()],
        ['class' => \yiisns\kernel\grid\UpdatedByColumn::className()],

    ],
]); ?>
