<?php
use yii\helpers\Html;
use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use yiisns\kernel\models\Tree;
use yiisns\admin\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model Tree */
/* @var $handler \yiisns\kernel\relatedProperties\PropertyType */
?>
<?php $form = ActiveForm::begin([
    'id'                                            => 'sx-dynamic-form',
    'enableAjaxValidation'                          => false,
]); ?>

<? $this->registerJs(<<<JS

(function(sx, $, _)
{
    sx.classes.DynamicForm = sx.classes.Component.extend({

        _onDomReady: function()
        {
            var self = this;

            $("[data-form-reload=true]").on('change', function()
            {
                self.update();
            });
        },

        update: function()
        {
            _.delay(function()
            {
                var jForm = $("#sx-dynamic-form");
                jForm.append($('<input>', {'type': 'hidden', 'name' : 'sx-not-submit', 'value': 'true'}));
                jForm.submit();
            }, 200);
        }
    });

    sx.DynamicForm = new sx.classes.DynamicForm();
})(sx, sx.$, sx._);


JS
); ?>
<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Basic settings')) ?>
    <?= $form->field($model, 'active')->radioList(\Yii::$app->appCore->booleanFormat()) ?>
    <?= $form->field($model, 'is_required')->radioList(\Yii::$app->appCore->booleanFormat()) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'code')->textInput() ?>
    <?= $form->field($model, 'component')->listBox(array_merge(['' => ' — '], \Yii::$app->appCore->relatedHandlersDataForSelect), [
            'size' => 1,
            'data-form-reload' => 'true'
        ])
        ->label(\Yii::t('yiisns/kernel', 'Property type'))
        ;
    ?>
    <? if ($handler) : ?>
        <?= \yiisns\admin\widgets\BlockTitleWidget::widget(['content' => \Yii::t('yiisns/kernel', 'Settings')]); ?>
            <?= $handler->renderConfigForm($form); ?>
    <? endif; ?>
<?= $form->fieldSetEnd(); ?>
<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Additionally')) ?>
    <?= $form->field($model, 'hint')->textInput() ?>
    <?= $form->fieldInputInt($model, 'priority') ?>
    <?= $form->field($model, 'searchable')->radioList(\Yii::$app->appCore->booleanFormat()) ?>
    <?= $form->field($model, 'filtrable')->radioList(\Yii::$app->appCore->booleanFormat()) ?>
    <?/*= $form->field($model, 'with_description')->radioList(\Yii::$app->appCore->booleanFormat()) */?>
<? if ($content_id = \Yii::$app->request->get('content_id')) : ?>
    <?= $form->field($model, 'content_id')->hiddenInput(['value' => $content_id])->label(false); ?>
<? else: ?>
    <?= $form->field($model, 'content_id')->label(\Yii::t('yiisns/kernel', 'Content'))->widget(
        \yiisns\apps\widgets\formInputs\EditedSelect::className(), [
            'items' => \yii\helpers\ArrayHelper::map(
                 \yiisns\kernel\models\Content::find()->all(),
                 'id',
                 'name'
             ),
            'controllerRoute' => 'admin/admin-content',
        ]);
    ?>
<? endif; ?>
<?= $form->fieldSetEnd(); ?>
<?= $form->buttonsStandart($model); ?>
<?php ActiveForm::end(); ?>