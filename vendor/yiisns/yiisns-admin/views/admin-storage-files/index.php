
<?php
/**
 * index
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.10.2016
 * @since 1.0.0
 */

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\Game */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>


<? $pjax = \yiisns\admin\widgets\Pjax::begin(); ?>

<? $pjaxId = $pjax->id; ?>
<?= \yiisns\apps\widgets\StorageFileManager::widget([
    'clientOptions' =>
    [
        'completeUploadFile' => new \yii\web\JsExpression(<<<JS
        function(data)
        {
            $.pjax.reload('#{$pjaxId}', {});
        }
JS
)
    ],
]); ?>
<p></p>

    <?php echo $this->render('_search', [
        'searchModel'   => $searchModel,
        'dataProvider'  => $dataProvider
    ]); ?>

<?= \yiisns\admin\widgets\GridViewStandart::widget([

    'dataProvider'      => $dataProvider,
    'filterModel'       => $searchModel,
    'adminController'   => $controller,

    'pjax'              => $pjax,

    'pjaxOptions' => [
        'id' => 'sx-storage-files'
    ],

    'columns' => [

        [
            'class'     => \yii\grid\DataColumn::className(),
            'value'     => function(\yiisns\kernel\models\StorageFile $model)
            {
                if ($model->isImage())
                {

                    $smallImage = \Yii::$app->imaging->getImagingUrl($model->src, new \yiisns\apps\components\imaging\filters\Thumbnail());
                    return "<a href='" . $model->src . "' class='sx-fancybox' data-pjax='0' title='" . \Yii::t('yiisns/kernel','Increase') ."'>
                            <img src='" . $smallImage . "' style='max-width: 50px;'/>
                        </a>";
                }

                return \yii\helpers\Html::tag('span', $model->extension, ['class' => 'label label-primary', 'style' => 'font-size: 18px;']);
            },
            'format' => 'raw'
        ],

        'name',

        /*[
            'class'     => \yii\grid\DataColumn::className(),
            'value'     => function(\yiisns\kernel\models\StorageFile $model)
            {
                return \yii\helpers\Html::tag('pre', $model->src);
            },

            'format' => 'html',
            'attribute' => 'src'
        ],*/

        [
            'class'     => \yii\grid\DataColumn::className(),
            'value'     => function(\yiisns\kernel\models\StorageFile $model)
            {
                $model->cluster_id;
                $cluster = \Yii::$app->storage->getCluster($model->cluster_id);
                return $cluster->name;
            },

            'filter' => \yii\helpers\ArrayHelper::map(\Yii::$app->storage->getClusters(), 'id', 'name'),
            'format' => 'html',
            'attribute' => 'cluster_id',
        ],

        [
            'attribute' => 'mime_type',
            'filter' => \yii\helpers\ArrayHelper::map(\yiisns\kernel\models\StorageFile::find()->groupBy(['mime_type'])->all(), 'mime_type', 'mime_type'),
        ],

        [
            'attribute' => 'extension',
            'filter' => \yii\helpers\ArrayHelper::map(\yiisns\kernel\models\StorageFile::find()->groupBy(['extension'])->all(), 'extension', 'extension'),
        ],

        [
            'class' => \yiisns\kernel\grid\FileSizeColumnData::className(),
            'attribute' => 'size'
        ],

        ['class' => \yiisns\kernel\grid\CreatedAtColumn::className()],
        //['class' => \yiisns\kernel\grid\UpdatedAtColumn::className()],

        ['class' => \yiisns\kernel\grid\CreatedByColumn::className()],
        //['class' => \yiisns\kernel\grid\UpdatedByColumn::className()],

    ],

]); ?>

<? $pjax::end(); ?>