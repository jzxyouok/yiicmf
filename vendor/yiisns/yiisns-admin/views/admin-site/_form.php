<?php

use yii\helpers\Html;
use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use yiisns\kernel\models\Tree;

/* @var $this yii\web\View */
/* @var $model Tree */
?>


<?php $form = ActiveForm::begin(); ?>


<?= $form->fieldSet(\Yii::t('yiisns/kernel',"Main")); ?>

    <?= $form->field($model, 'image_id')->widget(
        \yiisns\apps\widgets\formInputs\StorageImage::className()
    ); ?>

    <?= $form->field($model, 'code')->textInput(); ?>


    <? if ($model->def === \yiisns\kernel\base\AppCore::BOOL_Y): ?>
        <?= $form->field($model, 'active')->hiddenInput()->hint(\Yii::t('yiisns/kernel','Site selected by default always active')); ?>
        <?= $form->field($model, 'def')->hiddenInput()->hint(\Yii::t('yiisns/kernel','This site is the site selected by default. If you want to change it, you need to choose a different site, the default site.')); ?>
    <? else : ?>
        <?= $form->fieldRadioListBoolean($model, 'active'); ?>
        <?= $form->fieldRadioListBoolean($model, 'def'); ?>
    <? endif; ?>


    <?= $form->field($model, 'name')->textarea(); ?>


    <?= $form->field($model, 'description')->textarea(); ?>
    <?= $form->field($model, 'server_name')->textInput(['maxlength' => 255]) ?>
    <?= $form->fieldInputInt($model, 'priority'); ?>

<?= $form->fieldSetEnd(); ?>

<? if (!$model->isNewRecord) : ?>
    <?= $form->fieldSet(\Yii::t('yiisns/kernel',"Domains")); ?>

        <?= \yiisns\admin\widgets\RelatedModelsGrid::widget([
            'label'             => "",
            'hint'              => "",
            'parentModel'       => $model,
            'relation'          => [
                'site_code' => 'code'
            ],

            'controllerRoute'   => 'admin/admin-site-domain',
            'gridViewOptions'   => [
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],
                    'domain',
                ],
            ],
        ]); ?>

    <?= $form->fieldSetEnd(); ?>
<? endif; ?>
<?= $form->buttonsStandart($model) ?>

<?php ActiveForm::end(); ?>