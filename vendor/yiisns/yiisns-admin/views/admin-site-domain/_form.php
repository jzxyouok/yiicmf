<?php

use yii\helpers\Html;
use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use yiisns\kernel\models\Tree;

/* @var $this yii\web\View */
/* @var $model Tree */
?>
<?php $form = ActiveForm::begin(); ?>
    <?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Main')); ?>
            <? if ($code = \Yii::$app->request->get('site_code')) : ?>
                <?= $form->field($model, 'site_code')->hiddenInput(['value' => $code])->label(false); ?>
            <? else: ?>
                <?= $form->field($model, 'site_code')->widget(
                    \yii\widget\chosen\Chosen::className(), [
                        'items' => \yii\helpers\ArrayHelper::map(
                             \yiisns\kernel\models\Site::find()->all(),
                             'code',
                             'name'
                        ),
                ]);
            ?>
            <? endif; ?>
        <?= $form->field($model, 'domain')->textInput(); ?>
    <?= $form->fieldSetEnd(); ?>
<?= $form->buttonsStandart($model) ?>
<?php ActiveForm::end(); ?>