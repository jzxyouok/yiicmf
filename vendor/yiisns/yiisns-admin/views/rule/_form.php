<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yiisns\kernel\models\AuthItem $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="auth-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'className')->textInput() ?>

    <div class="form-group">
        <?php
        echo Html::submitButton($model->isNewRecord ? \Yii::t('yiisns/kernel', 'Create') : \Yii::t('yiisns/kernel', 'Update'), [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])
        ?>
    </div>

<?php ActiveForm::end(); ?>
</div>
