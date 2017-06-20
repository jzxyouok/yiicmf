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
        'name',
        'code',
        [
            'attribute' => 'emails',
            'class' => \yii\grid\DataColumn::className(),
            'format' => 'raw',
            'value' => function(\yiisns\form2\models\Form2Form $model)
            {
                return $model->emails;
            }
        ],

        [
            'attribute' => 'phones',
            'class' => \yii\grid\DataColumn::className(),
            'format' => 'raw',
            'value' => function(\yiisns\form2\models\Form2Form $model)
            {
                return $model->phones;
            }
        ],

        [
            'label' => \Yii::t('yiisns/form2', 'Number of fields in the form'),
            'class' => \yii\grid\DataColumn::className(),
            'format' => 'raw',
            'value' => function(\yiisns\form2\models\Form2Form $model)
            {
                return count($model->createModelFormSend()->relatedPropertiesModel->attributeLabels());
            }
        ],

        [
            'label' => \Yii::t('yiisns/form2', 'Number of posts'),
            'class' => \yii\grid\DataColumn::className(),
            'format' => 'raw',
            'value' => function(\yiisns\form2\models\Form2Form $model)
            {
                return \yii\helpers\Html::a(count($model->form2FormSends), \yiisns\apps\helpers\UrlHelper::construct('/form2/admin-form-send', [
                    'Form2FormSend' =>
                    [
                        'form_id' => $model->id
                    ]
                ])->enableAdmin()->toString());
            }
        ],
    ],
]); ?>
<? $pjax::end(); ?>