<?php
/* @var $this yii\web\View */
/* @var $model \yiisns\kernel\models\ContentElement */
/* @var $relatedModel \yiisns\apps\relatedProperties\models\RelatedPropertiesModel */
?>
<?= $form->fieldSet(\Yii::t('yiisns/kernel','Main')); ?>
    <?= $form->fieldRadioListBoolean($model, 'active'); ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'published_at')->widget(\kartik\datecontrol\DateControl::classname(), [
                //'displayFormat' => 'php:d-M-Y H:i:s',
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
            ]); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'published_to')->widget(\kartik\datecontrol\DateControl::classname(), [
                //'displayFormat' => 'php:d-M-Y H:i:s',
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
            ]); ?>
        </div>
    </div>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'code')->textInput(['maxlength' => 255])->hint(\Yii::t('yiisns/kernel',"This parameter affects the address of the page")); ?>
    <?= $form->fieldInputInt($model, 'priority'); ?>

    <? if ($contentModel->parent_content_id) : ?>

        <?= $form->field($model, 'parent_content_element_id')->widget(
            \yiisns\admin\widgets\formInputs\ContentElementInput::className()
        )->label($contentModel->parentContent->name_one) ?>
    <? endif; ?>

    <? if ($model->relatedPropertiesModel->properties) : ?>
        <?= \yiisns\admin\widgets\BlockTitleWidget::widget([
            'content' => \Yii::t('yiisns/kernel', 'Additional properties')
        ]); ?>
        <? foreach ($model->relatedPropertiesModel->properties as $property) : ?>
            <?= $property->renderActiveForm($form)?>
        <? endforeach; ?>

    <? else : ?>
        <?/*= \Yii::t('yiisns/kernel','Additional properties are not set')*/?>
    <? endif; ?>
<?= $form->fieldSetEnd()?>
