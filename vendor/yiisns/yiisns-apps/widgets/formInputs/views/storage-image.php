<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.09.2016
 */

/* @var $widget     \yiisns\apps\widgets\formInputs\StorageImage */
/* @var $this       yii\web\View */
/* @var $model      \yii\db\ActiveRecord */
$controller = \Yii::$app->createController('admin/admin-storage-files')[0];
?>
<?
    $this->registerCss(<<<CSS
.sx-fromWidget-storageImages
{}

    .sx-fromWidget-storageImages .sx-main-image img
    {
        max-width: 250px;
        border: 2px solid silver;
    }

    .sx-fromWidget-storageImages .sx-main-image img:hover
    {
        border: 2px solid #20a8d8;
    }

    .sx-fromWidget-storageImages .sx-controlls
    {
        margin-top: 3px;
    }


    .sx-fromWidget-storageImages .sx-image
    {
        float: left;
        margin-right: 15px;
        margin-bottom: 15px;
        box-shadow: 1px 2px 6px rgba(0, 0, 0, 0.42);
        padding: 10px;
        background: white;
    }

    .sx-fromWidget-storageImages .sx-group-images img
    {
        max-width: 100px;
        border: 1px solid silver;
        margin-bottom: 5px;
    }
    .sx-fromWidget-storageImages .sx-group-images img:hover
    {
        max-width: 100px;
        border: 1px solid #20a8d8;

    }

CSS
);

$this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.SingleUpload = sx.classes.Component.extend({

        execute: function()
        {
            var ajaxQuery = sx.ajax.preparePostQuery(this.get('backendUrl'), this.toArray());
            new sx.classes.AjaxHandlerStandartRespose(ajaxQuery);
            ajaxQuery.execute();
        }

    });
})(sx, sx.$, sx._);
JS
);
?>
<div class="sx-fromWidget-storageImages">
    <? \yiisns\admin\widgets\Pjax::begin([
        'id' => 'pjax-storage-images-widget-' . $widget->id,
        'blockPjaxContainer' => true,
    ]);?>


    <div class="sx-group-images">
        <div class="row col-md-12">
            <? if ($imageFile = $widget->image) : ?>
                <div class="sx-image">
                    <? if (!$widget->viewItemTemplate) : ?>
                        <a href="<?= $imageFile->src; ?>" class="sx-fancybox" data-pjax="0">
                            <img src="<?= \Yii::$app->imaging->getImagingUrl($imageFile->src, new \yiisns\apps\components\imaging\filters\Thumbnail()); ?>" />
                        </a>
                        <div class="sx-controlls">
                            <?
                            $controllerTmp = clone $controller;
                            $controllerTmp->setModel($imageFile);

                            echo \yiisns\admin\widgets\DropdownControllerActions::widget([
                                "controller"            => $controllerTmp,
                                "isOpenNewWindow"       => true,
                                "clientOptions"         =>
                                [
                                    'pjax-id' => 'pjax-storage-images-widget-' . $widget->id
                                ],
                            ]);
                            ?>
                        </div>
                    <? else : ?>
                        <?= $widget->renderItem($imageFile); ?>
                    <? endif; ?>

                </div>
            <? endif; ?>
        </div>
    </div>

    <? \yiisns\admin\widgets\Pjax::end(); ?>

    <div class="sx-controlls">
        <?= \yiisns\apps\widgets\StorageFileManager::widget([
            'clientOptions'     =>
            [
                'simpleUpload' =>
                [
                    'options' =>
                    [
                        'multiple' => true
                    ]
                ],

                'completeUploadFile' => new \yii\web\JsExpression(<<<JS
                function(data)
                {
                    var result = data.response;
                    if (result.success === true)
                    {

                        var SingleUpload = new sx.classes.SingleUpload( _.extend({$widget->getJsonString()}, {
                            'file_id' : result.file.id,
                        }) );

                        SingleUpload.execute();
                    }

                    $.pjax.reload('#pjax-storage-images-widget-{$widget->id}', {});
                }
JS
)
            ],
        ]); ?>
    </div>
</div>

