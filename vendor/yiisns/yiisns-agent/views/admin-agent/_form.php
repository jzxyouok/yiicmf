<?php

use yii\helpers\Html;
use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model \yiisns\kernel\models\Agent */
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->fieldSet(Yii::t('yiisns/agent', 'Main')); ?>

    <?= $form->field($model, 'next_exec_at')->widget(
        \kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
    ]); ?>
    <?= $form->fieldRadioListBoolean($model, 'active'); ?>
    <?= $form->field($model, 'name')->textarea(); ?>
    <?= $form->field($model, 'description')->textarea(); ?>
    <?= $form->fieldInputInt($model, 'priority'); ?>
    <?= $form->fieldRadioListBoolean($model, 'is_period'); ?>
    <?= $form->fieldInputInt($model, 'agent_interval'); ?>

<?= $form->fieldSetEnd(); ?>

<?= $form->buttonsCreateOrUpdate($model); ?>
<?php ActiveForm::end(); ?>
