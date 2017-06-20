<?php
/* @var $this yii\web\View */
/* @var $model \yiisns\kernel\models\ContentElement */
/* @var $relatedModel \yiisns\apps\relatedProperties\models\RelatedPropertiesModel */
?>
<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Announcement')); ?>
    <?= $form->field($model, 'image_id')->widget(
        \yiisns\apps\widgets\formInputs\StorageImage::className()
    ); ?>
    <?= $form->field($model, 'description_short')->widget(
        \yiisns\apps\widgets\formInputs\comboText\ComboTextInputWidget::className(),
        [
            'modelAttributeSaveType' => 'description_short_type',
        ]);
    ?>
<?= $form->fieldSetEnd() ?>