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
<? $pjax = \yiisns\admin\widgets\Pjax::begin(); ?>

    <?php echo $this->render('_search', [
        'searchModel'   => $searchModel,
        'dataProvider'  => $dataProvider
    ]); ?>

    <?= \yiisns\admin\widgets\GridViewStandart::widget([
        'dataProvider'      => $dataProvider,
        'filterModel'       => $searchModel,
        'adminController'   => $controller,
        'pjax'              => $pjax,
        'columns' => [
            'value',
            [
                'class'         => \yiisns\kernel\grid\UserColumnData::className(),
                'attribute'     => 'user_id',
            ],

            [
                'class' => \yiisns\kernel\grid\BooleanColumn::className(),
                'attribute' => 'approved',
            ],

            [
                'class' => \yiisns\kernel\grid\BooleanColumn::className(),
                'attribute' => 'def',
            ]
        ],
    ]); ?>

<? $pjax::end(); ?>