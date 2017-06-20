<?php

use yii\helpers\Html;
use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use yiisns\kernel\models\Tree;

/* @var $this yii\web\View */
/* @var $model \yiisns\kernel\models\StorageFile */

?>

<? $this->registerCss(<<<CSS
    .sx-image-controll .sx-image img
    {
        max-height: 200px;
        border: 2px solid silver;
    }
CSS
); ?>

<div class="sx-image-controll">
<?php $form = ActiveForm::begin(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Main')); ?>
    <? if ($model->isImage()) : ?>
        <div class="sx-image">
            <img src="<?= $model->src; ?>" />
        </div>
    <? endif; ?>
    <div class=''>

    </div>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255])->hint(\Yii::t('yiisns/kernel', 'This name is usually needed for SEO, so that the file was found in the search engines')) ?>
    <?= $form->field($model, 'name_to_save')->textInput(['maxlength' => 255])->hint(\Yii::t('yiisns/kernel', 'Filename, when someone will be download it.')) ?>

<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Description')); ?>
    <?= $form->field($model, 'description_full')->widget(
        \yiisns\apps\widgets\formInputs\ckeditor\Ckeditor::className(),
        [
            'options'       => ['rows' => 20],
            'preset'        => 'full',
            'relatedModel'  => $model,
        ])
    ?>
    <?= $form->field($model, 'description_short')->widget(
        \yiisns\apps\widgets\formInputs\ckeditor\Ckeditor::className(),
        [
            'options'       => ['rows' => 6],
            'preset'        => 'full',
            'relatedModel'  => $model,
        ])
    ?>
<?= $form->fieldSetEnd() ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Additional Information')); ?>
    <?= $form->field($model, 'original_name')->textInput([
        'maxlength' => 255,
        'disabled' => 'disabled'
    ])->hint(\Yii::t('yiisns/kernel', 'Filename at upload time to the site')) ?>
    <?= $form->field($model, 'size')->textInput([
        'maxlength' => 255,
        'disabled' => 'disabled',
        'value' => \Yii::$app->formatter->asShortSize($model->size)
    ]); ?>
    <?= $form->field($model, 'mime_type')->textInput([
        'maxlength' => 255,
        'disabled' => 'disabled'
    ])->hint('Internet Media Types — ' . \Yii::t('yiisns/kernel', 'types of data which can be transmitted via the Internet using standard MIME.')); ?>
    <?= $form->field($model, 'extension')->textInput([
        'maxlength' => 255,
        'disabled' => 'disabled'
    ]); ?>
    <? if ($model->isImage()) : ?>
        <? if (!$model->image_height || !$model->image_width) : ?>
            <? $model->updateFileInfo(); ?>
        <? endif; ?>
        <div class="col-md-12">
            <div class="col-md-2">
            <?= $form->field($model, 'image_width')->textInput([
                'maxlength' => 255,
                'disabled' => 'disabled'
            ]); ?>
            </div>

            <div class="col-md-2">
            <?= $form->field($model, 'image_height')->textInput([
                'maxlength' => 255,
                'disabled' => 'disabled'
            ]); ?>
            </div>
        </div>
    <? endif; ?>



<?= $form->fieldSetEnd(); ?>


<? if ($model->isImage()) : ?>
    <?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Thumbnails')); ?>
        <p><?=\Yii::t('yiisns/kernel', 'This is an image in different places of the site displayed in different sizes.')?></p>

    <?= $form->fieldSetEnd(); ?>

    <?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Image editor')); ?>

    <?= $form->fieldSetEnd(); ?>
<? endif; ?>

<?= $form->buttonsCreateOrUpdate($model); ?>
<?php ActiveForm::end(); ?>
</div>