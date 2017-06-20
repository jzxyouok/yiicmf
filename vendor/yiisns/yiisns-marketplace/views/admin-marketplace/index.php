<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 24.06.2016
 */
/* @var $this yii\web\View */
/* @var $model Extension */

ini_set('memory_limit', '256M');
set_time_limit(0);

use \yiisns\marketplace\models\PackageModel;
use \yiisns\marketplace\models\Extension;

$self = $this;
$models = Extension::fetchAllWhithMarketplace();

$self = $this;
?>

<? if (@$message) : ?>
    <?
        \yii\bootstrap\Alert::begin([
            'options' => [
              'class' => 'alert-info',
          ]
        ]);
    ?>
        <?= $message; ?>
    <? \yii\bootstrap\Alert::end(); ?>
<? endif; ?>
<? if ($models) :  ?>
    <?= \yiisns\admin\widgets\GridView::widget([
        'dataProvider' => (new \yii\data\ArrayDataProvider([
            'allModels' => $models,
            'pagination' => [
                'defaultPageSize' => 200
            ]
        ])),
        //'layout' => "{summary}\n{items}\n{pager}",
        'columns' =>
        [
            [
                'class' => \yii\grid\DataColumn::className(),
                'value' => function(Extension $model) use ($self)
                {
                    return $self->render('_image-column', [
                        'model' => $model
                    ]);

                },
                'format' => 'raw'
            ],

            [
                'class' => \yii\grid\DataColumn::className(),
                'value' => function(Extension $model) use ($self)
                {
                    return $model->version;
                },

                'format' => 'raw',
                'attribute' => 'version'
            ],
        ]
    ])?>
<? endif; ?>