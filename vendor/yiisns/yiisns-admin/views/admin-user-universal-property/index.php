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

    <?php /*echo $this->render('_search', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider
    ]); */?>

    <?= \yiisns\admin\widgets\GridViewStandart::widget([
        'dataProvider'  => $dataProvider,
        'filterModel'   => $searchModel,
        'adminController'   => $controller,
        'pjax'              => $pjax,
        'columns' => [
            'name',
            'code',
            [
                'class' => \yiisns\kernel\grid\BooleanColumn::className(),
                'falseValue' => \yiisns\kernel\base\AppCore::BOOL_N,
                'trueValue' => \yiisns\kernel\base\AppCore::BOOL_Y,
                'attribute' => 'active'
            ],
        ],
    ]); ?>

<? $pjax::end(); ?>
