<?php
use yii\helpers\Html;
use yiisns\admin\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \yii\db\ActiveRecord */
?>
<?php $form = ActiveForm::begin(); ?>

<?
\yiisns\admin\assets\JqueryMaskInputAsset::register($this);
$id = \yii\helpers\Html::getInputId($model, 'value');
$this->registerJs(<<<JS
$("#{$id}").mask("+86 999 9999-9999");
JS
);
?>
    <?= $form->field($model, 'value')->textInput([
        'placeholder' => '+86 999 9999-9999'
    ])->hint('Phone number format: +86 999 9999-9999'); ?>

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

    <?= $form->buttonsCreateOrUpdate($model); ?>
<?php ActiveForm::end(); ?>