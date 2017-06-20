<?php

use yii\helpers\Html;
use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model \yii\db\ActiveRecord */
/* @var $console \yiisns\apps\controllers\AdminUserController */
?>


<?php $form = ActiveForm::begin(); ?>
<?php  ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel','General information'))?>
    <?= $form->field($model, 'name')->textInput(); ?>
    <?= $form->field($model, 'code')->textInput(); ?>
    <?= $form->fieldInputInt($model, 'priority')->textInput(); ?>
<?= $form->fieldSetEnd(); ?>


<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Content'))?>
    <?= \yiisns\admin\widgets\RelatedModelsGrid::widget([
        'label'             => \Yii::t('yiisns/kernel',"Content"),
        'hint'              => '',
        'parentModel'       => $model,
        'relation'          => [
            'content_type' => 'code'
        ],
        'controllerRoute'   => 'admin/admin-content',
        'gridViewOptions'   => [
            'sortable' => true,
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],
                'name',
                'code',
                [
                    'class' => \yiisns\kernel\grid\BooleanColumn::className(),
                    'falseValue' => \yiisns\kernel\base\AppCore::BOOL_N,
                    'trueValue' => \yiisns\kernel\base\AppCore::BOOL_Y,
                    'attribute' => 'active'
                ],
            ],
        ],
    ]); ?>

<?= $form->fieldSetEnd(); ?>

<?= $form->buttonsCreateOrUpdate($model); ?>
<?php ActiveForm::end(); ?>