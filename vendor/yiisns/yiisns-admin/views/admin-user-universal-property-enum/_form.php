<?php
use yii\helpers\Html;
use yiisns\admin\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \yii\db\ActiveRecord */
?>
<?php $form = ActiveForm::begin(); ?>

    <? if ($form_id = \Yii::$app->request->get('property_id')) : ?>
        <?= $form->field($model, 'property_id')->hiddenInput(['value' => $form_id])->label(false); ?>
    <? else: ?>
        <?= $form->field($model, 'property_id')->widget(
        \yii\widget\chosen\Chosen::className(), [
                'items' => \yii\helpers\ArrayHelper::map(
                     \yiisns\kernel\models\UserUniversalProperty::find()->all(),
                     'id',
                     'name'
                ),
        ]);
    ?>
    <? endif; ?>
    <?= $form->field($model, 'value')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'code')->textInput(['maxlength' => 32]) ?>
    <?= $form->buttonsCreateOrUpdate($model); ?>
<?php ActiveForm::end(); ?>