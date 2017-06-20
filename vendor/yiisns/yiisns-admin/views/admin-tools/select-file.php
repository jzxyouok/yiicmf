<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.04.2015
 */
/* @var $this yii\web\View */
/* @var $model \yii\db\ActiveRecord */

use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;
?>

<?
$this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.SelectFile = sx.classes.Component.extend({
        _init: function()
        {},

        _onDomReady: function()
        {
            this.GetParams              = sx.helpers.Request.getParams();
        },

        submit: function(file)
        {
            if (this.GetParams['CKEditorFuncNum'])
            {
                if (window.opener)
                {
                    if (window.opener.CKEDITOR)
                    {
                        window.opener.CKEDITOR.tools.callFunction(this.GetParams['CKEditorFuncNum'], file);
                        window.close();
                        return this;
                    }
                }
            }

            if (this.GetParams['callbackEvent'])
            {
                if (window.opener)
                {
                    if (window.opener.sx)
                    {
                        window.opener.sx.EventManager.trigger(this.GetParams['callbackEvent'], {
                            'file' : file
                        });

                        window.close();
                        return this;
                    }
                }
            }

            sx.alert(file);
            return this;
        }
    });

    sx.SelectFile = new sx.classes.SelectFile();

})(sx, sx.$, sx._);
JS
);
?>

<? $form = ActiveForm::begin([
    'usePjax' => false
]); ?>

<? if ($model) : ?>
    <?= $form->fieldSet(\Yii::t('yiisns/kernel','Files attached to records')); ?>

        <? \yii\bootstrap\Alert::begin(['options' => [
          'class' => 'alert-info',
        ]]); ?>
            <?=\Yii::t('yiisns/kernel','At this tab displays all the files and images that are tied to the current element.')?>
        <? \yii\bootstrap\Alert::end(); ?>


        <? foreach($model->getBehaviors() as $behavior) : ?>
            <? \yii\bootstrap\ActiveForm::begin(); ?>
            <? if ($behavior instanceof \yiisns\kernel\models\behaviors\HasStorageFile)  : ?>
                <? foreach($behavior->fields as $fieldName) : ?>

                    <?= $form->field($model, $fieldName)->widget(
                        \yiisns\apps\widgets\formInputs\StorageImage::className(),
                        [
                            'viewItemTemplate' => '@yiisns/admin/views/admin-tools/one-file'
                        ]
                    ); ?>

                <? endforeach; ?>

            <? elseif ($behavior instanceof \yiisns\kernel\models\behaviors\HasStorageFileMulti) : ?>
                <? foreach($behavior->relations as $relationName) : ?>

                    <?= $form->field($model, $relationName)->widget(
                        \yiisns\apps\widgets\formInputs\ModelStorageFiles::className(),
                        [
                            'viewItemTemplate' => '@yiisns/admin/views/admin-tools/one-file'
                        ]
                    ); ?>

                <? endforeach; ?>
            <? endif; ?>
            <? \yii\bootstrap\ActiveForm::end(); ?>
        <? endforeach; ?>


        <?/*= \yiisns\admin\widgets\StorageFilesForModel::widget([
            'model' => $model,
            'gridColumns' =>
            [

                [
                    'class'     => \yii\grid\DataColumn::className(),
                    'value'     => function(\yiisns\kernel\models\StorageFile $model)
                    {
                        return \yii\helpers\Html::a('<i class="glyphicon glyphicon-circle-arrow-left"></i> Выбрать файл', $model->src, [
                            'class' => 'btn btn-primary',
                            'onclick' => 'sx.SelectFile.submit("' . $model->src . '"); return false;',
                            'data-pjax' => 0
                        ]);
                    },
                    'format' => 'raw'
                ],

                [
                    'class'         => \yiisns\admin\grid\ActionColumn::className(),
                    'controller'    => \Yii::$app->createController('admin/admin-storage-files')[0],
                    'isOpenNewWindow'    => true
                ],

                [
                    'class'     => \yii\grid\DataColumn::className(),
                    'value'     => function(\yiisns\kernel\models\StorageFile $model)
                    {
                        if ($model->isImage())
                        {
                            \Yii::$app->view->registerCss(<<<CSS
        .sx-img-small {
            max-height: 50px;
        }
CSS
    );

                            $smallImage = \Yii::$app->imaging->getImagingUrl($model->src, new \yiisns\apps\components\imaging\filters\Thumbnail());

                            return "<a href='{$model->src}' data-pjax='0' class='sx-fancybox'>" . \yii\helpers\Html::img($smallImage, [
                                'width' => '50',
                                'class' => 'sx-img-small'
                            ]) . '</a>';
                        }

                        return \yii\helpers\Html::tag('span', $model->extension, ['class' => 'label label-primary', 'style' => 'font-size: 18px;']);
                    },
                    'format' => 'raw'
                ],



                [
                    'class'     => \yii\grid\DataColumn::className(),
                    'value'     => function(\yiisns\kernel\models\StorageFile $file)
                    {
                        if ($groups = $file->getFilesGroups())
                        {
                            $result = \yii\helpers\ArrayHelper::map($groups, "id", "name");

                            if ($result)
                            {
                                foreach ($result as $key => $name)
                                {
                                    $result[$key] = '<span class="label label-info"><i class="glyphicon glyphicon-tag"></i> ' . $name . '</span>';
                                }
                            }

                            return implode(' ', $result);
                        }
                    },
                    'format' => 'html',
                    'label' => 'Метки'
                ],

                'name',

                [
                    'attribute' => 'mime_type',
                    'filter' => \yii\helpers\ArrayHelper::map(\yiisns\kernel\models\StorageFile::find()->all(), 'mime_type', 'mime_type'),
                ],

                [
                    'attribute' => 'extension',
                    'filter' => \yii\helpers\ArrayHelper::map(\yiisns\kernel\models\StorageFile::find()->all(), 'extension', 'extension'),
                ],


                [
                    'class' => \yiisns\kernel\grid\FileSizeColumnData::className(),
                    'attribute' => 'size'
                ],
            ]
        ]); */?>
    <?= $form->fieldSetEnd(); ?>
<? endif; ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel','File manager')); ?>
    <?
        echo \mihaildev\elfinder\ElFinder::widget([
            'controller'       => 'apps/elfinder-full',
            //'filter'           => 'image',
            'callbackFunction' => new \yii\web\JsExpression('function(file, id){
                sx.SelectFile.submit(file.url);
            }'),
            'frameOptions' => [
                'style' => 'width: 100%; height: 800px;'
            ]
        ]);
    ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'File storage')); ?>


        <?

            $search = new \yiisns\kernel\models\Search(\yiisns\kernel\models\StorageFile::className());
            $dataProvider = $search->getDataProvider();

            $dataProvider->sort->defaultOrder = [
                'created_at' => SORT_DESC
            ];

        ?>
        <?= \yiisns\apps\widgets\StorageFileManager::widget([
            'clientOptions' =>
            [
                'completeUploadFile' => new \yii\web\JsExpression(<<<JS
                function(data)
                {
                    _.delay(function()
                    {
                        $.pjax.reload('#sx-storage-files', {});
                    }, 500)

                }
JS
        )
            ],
        ]); ?>
        <p></p>
        <? $dataProvider->pagination->defaultPageSize = 10; ?>
        <?= \yiisns\admin\widgets\GridViewHasSettings::widget([

            'dataProvider'  => $dataProvider,
            'filterModel'   => $search->getLoadedModel(),

            'pjaxOptions' => [
                'id' => 'sx-storage-files'
            ],

            'columns' => [

                [
                    'class'     => \yii\grid\DataColumn::className(),
                    'value'     => function(\yiisns\kernel\models\StorageFile $model)
                    {
                        return \yii\helpers\Html::a('<i class="glyphicon glyphicon-circle-arrow-left"></i> '.\Yii::t('yiisns/kernel','Choose file'), $model->src, [
                            'class' => 'btn btn-primary',
                            'onclick' => 'sx.SelectFile.submit("' . $model->src . '"); return false;',
                            'data-pjax' => 0
                        ]);
                    },
                    'format' => 'raw'
                ],

                [
                    'class'         => \yiisns\admin\grid\ActionColumn::className(),
                    'controller'    => \Yii::$app->createController('admin/admin-storage-files')[0],
                    'isOpenNewWindow'    => true
                ],

                [
                    'class'     => \yii\grid\DataColumn::className(),
                    'value'     => function(\yiisns\kernel\models\StorageFile $model)
                    {
                        if ($model->isImage())
                        {

                            $smallImage = \Yii::$app->imaging->getImagingUrl($model->src, new \yiisns\apps\components\imaging\filters\Thumbnail());
                            return "<a href='" . $model->src . "' data-pjax='0' class='sx-fancybox' title='".\Yii::t('yiisns/kernel','Increase')."'>
                                    <img src='" . $smallImage . "' />
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

<?= $form->fieldSetEnd(); ?>


<hr />
<?= \yii\helpers\Html::a("<i class='glyphicon glyphicon-question-sign'></i>", "#", [
    'class' => 'btn btn-default',
    'onclick' => "sx.dialog({'title' : '".\Yii::t('yiisns/kernel','Help')."', 'content' : '#sx-help'}); return false;"
]);?>
<div style="display: none;" id="sx-help">
    <?\Yii::t('yiisns/kernel','Help in the process of writing ...')?>
</div>

<? ActiveForm::end(); ?>
