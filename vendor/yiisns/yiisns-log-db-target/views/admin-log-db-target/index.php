<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.06.2015
 */
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<? $pjax = \yii\widgets\Pjax::begin(); ?>

    <?php echo $this->render('_search', [
        'searchModel'   => $searchModel,
        'dataProvider'  => $dataProvider,
    ]); ?>

<?= \yiisns\admin\widgets\GridViewStandart::widget([
    'dataProvider'  => $dataProvider,
    'filterModel'   => $searchModel,
    'adminController'   => $controller,
    'pjax'   => $pjax,
    'columns' => [
        [
            'attribute' => 'level',
            'value'         => function($model)
            {
                return \yii\log\Logger::getLevelName($model->level);
            },
            'filter' => [
                \yii\log\Logger::LEVEL_ERROR => 'error',
                \yii\log\Logger::LEVEL_WARNING => 'warning',
                \yii\log\Logger::LEVEL_INFO => 'info',
                \yii\log\Logger::LEVEL_TRACE => 'trace',
                \yii\log\Logger::LEVEL_PROFILE_BEGIN => 'profile begin',
                \yii\log\Logger::LEVEL_PROFILE_END => 'profile end',
            ]
        ],
        [
            'attribute' => 'category'
        ],
        [
            'attribute' => 'prefix',
            'visible' => false
        ],
        [
            'class'         => \yiisns\kernel\grid\DateTimeColumnData::className(),
            'attribute'     => 'log_time'
        ],

        [
            'class'         => \yii\grid\DataColumn::className(),
            'value'         => function($model)
            {
                return "<pre><code>" . substr(\yii\helpers\Html::encode($model->message), 0, 200) . '</code></pre>';
            },
            'attribute'     => 'message',
            'format'        => 'raw'
        ],

    ],
]); ?>

<? \yii\widgets\Pjax::end(); ?>