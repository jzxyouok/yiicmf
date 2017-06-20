<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 12.03.2016
 */
/* @var $this yii\web\View */
/* @var $widget \yiisns\admin\widgets\RelatedModelsGrid */
/* @var $controller \yiisns\admin\controllers\AdminModelEditorController */
use \yiisns\admin\widgets\Pjax;
$controller = \Yii::$app->createController($widget->controllerRoute)[0];

?>

<?/* Pjax::begin([
    'id' => $pjaxId,
]); */?>

<? if ($widget->label) : ?>
    <label><?= $widget->label; ?></label>
<? endif;?>

<? if ($widget->hint) : ?>
    <p><small><?= $widget->hint; ?></small></p>
<? endif;?>
<div>

    <? $onclick = new \yii\web\JsExpression(<<<JS
        new sx.classes.RelationModelsGrid({
            'createUrl': '{$createUrl}',
            'pjaxId': '{$pjaxId}',
        }); return false;
JS
    ); ?>

    <? $add = \Yii::t('yiisns/kernel', 'Add');?>
    <?= \yiisns\admin\widgets\GridViewHasSettings::widget(\yii\helpers\ArrayHelper::merge([
        'settingsData' =>
        [
             'namespace' => $widget->namespace
        ],
        'beforeTableLeft' => <<<HTML
        <a class="btn btn-default btn-sm" onclick="{$onclick}"><i class="glyphicon glyphicon-plus"></i>{$add}</a>
HTML

    ], $gridOptions)); ?>

    <?

        $this->registerJs(<<<JS
        (function(sx, $, _)
        {
            sx.classes.RelationModelsGrid = sx.classes.Component.extend({

                _init: function()
                {
                    var self = this;
                    var window = new sx.classes.Window(this.get('createUrl'));
                    window.bind("close", function()
                    {
                        $.pjax.reload('#' + self.get('pjaxId'), {});
                    });

                    window.open();
                }
            });
        })(sx, sx.$, sx._);
JS
);
    ?>

</div>

<?/* Pjax::end(); */?>