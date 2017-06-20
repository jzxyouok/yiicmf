<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.10.2016
 * @since 1.0.0
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
    'dataProvider'  => $dataProvider,
    'filterModel'   => $searchModel,
    'adminController' => $controller,
    'settingsData' =>
    [
        'orderBy' => ''
    ],
    'pjax'              => $pjax,
    'columns' => [
        'name',
        'description',
        [
            'attribute' => 'ruleName',
            /*'filter'    => \yii\helpers\ArrayHelper::map(
                \Yii::$app->appSettings->findUser()->all(),
                'id',
                'name'
            )*/
        ]
    ],
]); ?>
<? $pjax::end(); ?>