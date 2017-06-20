<?php

use yii\helpers\Html;
use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use yiisns\kernel\models\Tree;

/* @var $this yii\web\View */
/* @var $model \yiisns\kernel\models\Lang */
?>


<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'image_id')->widget(
    \yiisns\apps\widgets\formInputs\StorageImage::className()
); ?>
<?= $form->field($model, 'code')->textInput(); ?>
<?= $form->fieldRadioListBoolean($model, 'active')->hint(\Yii::t('yiisns/kernel', 'On the site must be included at least one language')); ?>
<?= $form->field($model, 'name')->textarea(); ?>
<?= $form->field($model, 'description')->textarea(); ?>
<?= $form->fieldInputInt($model, 'priority'); ?>

<?= $form->buttonsStandart($model) ?>

<?php ActiveForm::end(); ?>