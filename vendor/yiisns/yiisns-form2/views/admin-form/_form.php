<?php

use yii\helpers\Html;
use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model \yiisns\form2\models\Form2Form */
/* @var $console \yiisns\admin\controllers\AdminUserController */
?>
<?php $form = ActiveForm::begin(); ?>
<?php  ?>
<?= $form->fieldSet( \Yii::t('yiisns/form2', 'General information'))?>
    <?= $form->field($model, 'name')->textInput(); ?>
    <?= $form->field($model, 'code')->textInput(); ?>
    <?= $form->field($model, 'description')->textarea(); ?>
<?= $form->fieldSetEnd(); ?>
<? if (!$model->isNewRecord) : ?>
    <?= $form->fieldSet( \Yii::t('yiisns/form2', 'Form elements'))?>
        <?= \yiisns\admin\widgets\RelatedModelsGrid::widget([
                'label'             => \Yii::t('yiisns/form2', 'Element properties'),
                'hint'              => \Yii::t('yiisns/form2', 'Each content on the site has its own set of properties, and then they are set'),
                'parentModel'       => $model,
                'relation'          => [
                    'form_id' => 'id'
                ],

                'controllerRoute'   => 'form2/admin-form-property',
                'gridViewOptions'   => [
                    'sortable' => true,
                    'columns' => [
                        [
                            'attribute'     => 'name',
                            'enableSorting' => false
                        ],

                        [
                            'class'         => \yiisns\kernel\grid\BooleanColumn::className(),
                            'attribute'     => 'active',
                            'falseValue'    => \yiisns\kernel\base\AppCore::BOOL_N,
                            'trueValue'     => \yiisns\kernel\base\AppCore::BOOL_Y,
                            'enableSorting' => false
                        ],

                        [
                            'attribute'     => 'code',
                            'enableSorting' => false
                        ],

                        [
                            'attribute'     => 'priority',
                            'enableSorting' => false
                        ],
                    ],
                ],
            ]); ?>
    <?= $form->fieldSetEnd(); ?>
    <?= $form->fieldSet(\Yii::t('yiisns/form2', 'Email Message'))?>
        <?= $form->field($model, 'emails')->textarea()
        ->hint(\Yii::t('yiisns/form2', 'You can specify multiple Email addresses (separated by commas), which will receive the notification and filling out this form.'))?>
    <?= $form->fieldSetEnd(); ?>
    <?= $form->fieldSet(\Yii::t('yiisns/form2', 'Phone Message'))?>
    <?= \yii\bootstrap\Alert::widget([
        'options' => [
          'class' => 'alert-info',
        ],
        'body' => \Yii::t('yiisns/form2', 'It works when connected to the center of sms notifications'),
    ]); ?>
    <?= $form->field($model, 'phones')->textarea()
        ->hint(\Yii::t('yiisns/form2', 'Phone Message'))?>
    <?= $form->fieldSetEnd(); ?>
<? endif; ?>
<?= $form->buttonsCreateOrUpdate($model); ?>
<?php ActiveForm::end(); ?>