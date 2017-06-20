<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.06.2016
 */
/* @var $this yii\web\View */
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
    'adminController'   => $controller,
    'pjax'              => $pjax,
    'columns' => [
        [
            'attribute' => 'status',
            'class' => \yii\grid\DataColumn::className(),
            'filter' => \yiisns\form2\models\Form2FormSend::getStatuses(),
            'format' => 'raw',
            'value' => function(\yiisns\form2\models\Form2FormSend $model)
            {
                if ($model->status == \yiisns\form2\models\Form2FormSend::STATUS_NEW)
                {
                    $class = 'danger';
                } else if ($model->status == \yiisns\form2\models\Form2FormSend::STATUS_PROCESSED)
                {
                    $class = 'warning';
                } else if ($model->status == \yiisns\form2\models\Form2FormSend::STATUS_EXECUTED)
                {
                    $class = 'success';
                }

                return '<span class="label label-' . $class . '">' . \yii\helpers\ArrayHelper::getValue(\yiisns\form2\models\Form2FormSend::getStatuses(), $model->status) . '</span>';
            }
        ],

        [
            'class' => \yiisns\kernel\grid\DateTimeColumnData::className(),
            'attribute' => 'processed_at'
        ],

        [
            'class' => \yiisns\kernel\grid\UserColumnData::className(),
            'attribute' => 'processed_by'
        ],

        [
            'attribute' => 'form_id',
            'class' => \yii\grid\DataColumn::className(),
            'filter' => \yii\helpers\ArrayHelper::map(
                \yiisns\form2\models\Form2Form::find()->all(),
                'id',
                'name'
            ),
            'value' => function(\yiisns\form2\models\Form2FormSend $model)
            {
                return $model->form->name;
            }
        ],

        [
            'class' => \yiisns\kernel\grid\CreatedAtColumn::className(),
            'label' => 'Send'
        ],

        [
            'attribute' => 'site_code',
            'class' => \yii\grid\DataColumn::className(),
            'filter' => \yii\helpers\ArrayHelper::map(
                \yiisns\kernel\models\Site::find()->all(),
                'code',
                'name'
            ),
            'value' => function(\yiisns\form2\models\Form2FormSend $model)
            {
                return $model->site->name;
            }
        ],
        'comment'
    ],
]); ?>
<? $pjax::end(); ?>