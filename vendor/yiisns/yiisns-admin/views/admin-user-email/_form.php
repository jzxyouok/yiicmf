<?php
use yii\helpers\Html;
use yiisns\admin\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \yii\db\ActiveRecord */
?>
<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'value')->textInput(['maxlength' => 255]) ?>

    <? if (\Yii::$app->request->get('user_id')) : ?>
        <?= $form->field($model, 'user_id')->hiddenInput(['value' => \Yii::$app->request->get('user_id')])->label(false) ?>
    <? else: ?>
        <?= $form->fieldSelect($model, 'user_id', \yii\helpers\ArrayHelper::map(
            \yiisns\kernel\models\User::find()->active()->all(),
            'id',
            'displayName'
        ), [
            'allowDeselect' => true
        ]) ?>
    <? endif; ?>


    <?= $form->fieldRadioListBoolean($model, 'approved'); ?>
    <?= $form->fieldRadioListBoolean($model, 'def'); ?>

    <?= $form->buttonsCreateOrUpdate($model); ?>
<?php ActiveForm::end(); ?>
