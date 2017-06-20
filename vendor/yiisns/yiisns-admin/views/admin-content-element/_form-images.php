<?php
/* @var $this yii\web\View */
/* @var $model \yiisns\kernel\models\ContentElement */
/* @var $relatedModel \yiisns\apps\relatedProperties\models\RelatedPropertiesModel */
?>
<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Images/Files')); ?>
    <?= $form->field($model, 'images')->widget(
        \yiisns\apps\widgets\formInputs\ModelStorageFiles::className()
    ); ?>
    <?= $form->field($model, 'files')->widget(
        \yiisns\apps\widgets\formInputs\ModelStorageFiles::className()
    ); ?>
<?= $form->fieldSetEnd()?>