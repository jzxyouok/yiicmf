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

<?= $form->fieldSet(\Yii::t('yiisns/form2', 'General information'))?>
    <?= $form->field($model, 'name')->textInput(); ?>
    <?= $form->field($model, 'code')->textInput(); ?>
    <?= $form->field($model, 'description')->textarea(); ?>
<?= $form->fieldSetEnd(); ?>


<?= $form->fieldSet(\Yii::t('yiisns/form2', 'Notification settings'))?>


<?= $form->fieldSetEnd(); ?>


<?= $form->fieldSet(\Yii::t('yiisns/form2', 'Form elements'))?>
    <?/*= \yiisns\admin\widgets\RelatedModelsGrid::widget([
        'label'             => 'Form elements',
        'hint'              => '',
        'parentModel'       => $model,
        'relation'          => [
            'form_id' => 'id'
        ],

        'sort'              => [
            'defaultOrder' =>
            [
                'priority' => SORT_DESC
            ]
        ],

        'controllerRoute'   => 'form/admin-form-field',
        'gridViewOptions'   => [

            'sortable' => true,
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],
                'attribute',
                'name',
                'label',
                'hint',
                [
                    'class' => \yiisns\kernel\grid\BooleanColumn::className(),
                    'attribute' => 'active'
                ],
            ],
        ],
    ]); */?>
<?= $form->fieldSetEnd(); ?>
<?= $form->buttonsCreateOrUpdate($model); ?>
<?php ActiveForm::end(); ?>

<!--<div class="row">
    <div class="col-md-12">
        <div class="" style="border: 1px solid rgba(32, 168, 216, 0.23); padding: 10px; margin-top: 10px;">
            <h2>This is how the form will look:</h2>
            <hr />
            <?/*= $model->render(); */?>
        </div>

    </div>
</div>
-->