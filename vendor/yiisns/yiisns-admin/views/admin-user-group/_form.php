<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yiisns\kernel\models\Tree;

/* @var $this yii\web\View */
/* @var $model Tree */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'groupname')->textInput(['maxlength' => 12]) ?>
<?= $form->field($model, 'description')->textarea() ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('yiisns/kernel', 'Create') : Yii::t('yiisns/kernel', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>