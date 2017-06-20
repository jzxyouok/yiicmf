<?php
/* @var $this yii\web\View */
/* @var $model \yiisns\kernel\models\ContentElement */
/* @var $relatedModel \yiisns\apps\relatedProperties\models\RelatedPropertiesModel */
?>
<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'SEO')); ?>
    <?= $form->field($model, 'meta_title')->textarea(); ?>
    <?= $form->field($model, 'meta_description')->textarea(); ?>
    <?= $form->field($model, 'meta_keywords')->textarea(); ?>
<?= $form->fieldSetEnd() ?>