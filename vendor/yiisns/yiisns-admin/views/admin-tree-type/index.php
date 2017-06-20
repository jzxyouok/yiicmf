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
?>

<? $pjax = \yiisns\admin\widgets\Pjax::begin(); ?>

    <?php echo $this->render('_search', [
        'searchModel'   => $searchModel,
        'dataProvider'  => $dataProvider
    ]); ?>

    <?= \yiisns\admin\widgets\GridViewStandart::widget([
        'dataProvider'      => $dataProvider,
        'filterModel'       => $searchModel,
        'pjax'              => $pjax,
        'adminController'   => \Yii::$app->controller,
        'settingsData' =>
        [
            'order' => SORT_ASC,
            'orderBy' => "priority",
        ],
        'columns'           =>
        [
            'name',
            'code',

            [
                'class'         => \yii\grid\DataColumn::className(),
                'label'         => \Yii::t('yiisns/kernel', 'Number of sections'),
                'value'     => function(\yiisns\kernel\models\TreeType $treeType)
                {
                    return $treeType->getTrees()->count();
                }
            ],

            [
                'class'         => \yiisns\kernel\grid\BooleanColumn::className(),
                'attribute'     => 'active'
            ],
            'priority',
        ]
    ]); ?>

<? $pjax::end(); ?>
