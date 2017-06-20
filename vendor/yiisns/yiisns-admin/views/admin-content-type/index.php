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
                'value'     => function(\yiisns\kernel\models\ContentType $model)
                {
                    $contents = \yii\helpers\ArrayHelper::map($model->contents, 'id', 'name');
                    return implode(', ', $contents);
                },

                'label' => 'Контент',
            ],

            'priority',
        ]
    ]); ?>

<? $pjax::end(); ?>
