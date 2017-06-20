<?php
/* @var $this yii\web\View */
/* @var $model \yiisns\kernel\models\ContentElement */
/* @var $relatedModel \yiisns\apps\relatedProperties\models\RelatedPropertiesModel */
?>
<?= $form->fieldSet(\Yii::t('yiisns/kernel','In detal')); ?>
    <?= $form->field($model, 'image_full_id')->widget(
        \yiisns\apps\widgets\formInputs\StorageImage::className()
    ); ?>
    <?= $form->field($model, 'description_full')->widget(
        \yiisns\apps\widgets\formInputs\comboText\ComboTextInputWidget::className(),
        [
            'modelAttributeSaveType' => 'description_full_type',
        ]);
    ?>
<?= $form->fieldSetEnd() ?>