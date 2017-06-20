<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 02.06.2015
 */
/* @var $this yii\web\View */
/* @var $searchModel \yiisns\kernel\models\Search */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \yiisns\kernel\models\ContentElement */
$dataProvider->setSort(['defaultOrder' => ['priority' => SORT_ASC]]);
?>
<? $pjax = \yii\widgets\Pjax::begin(); ?>

    <?php echo $this->render('_search', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]); ?>

    <?= \yiisns\admin\widgets\GridViewStandart::widget([
        'dataProvider'      => $dataProvider,
        'filterModel'       => $searchModel,
        'autoColumns'       => false,
        'pjax'              => $pjax,
        'adminController'   => $controller,
        'columns' =>
        [
            [
                'class' => \yiisns\kernel\grid\ImageColumn2::className(),
            ],
            'name',
            'code',
            [
                'class'         => \yiisns\kernel\grid\BooleanColumn::className(),
                'attribute'     => "active"
            ],
            'priority',
        ]
    ]); ?>

<? \yii\widgets\Pjax::end(); ?>