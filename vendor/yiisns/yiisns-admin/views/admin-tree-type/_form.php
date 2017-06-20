<?php

use yii\helpers\Html;
use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model \yii\db\ActiveRecord */
/* @var $console \yiisns\apps\controllers\AdminUserController */
?>


<?php $form = ActiveForm::begin(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel','Main')); ?>


    <?= $form->field($model, 'name')->textInput(); ?>
    <?= $form->field($model, 'code')
        ->hint(\Yii::t('yiisns/kernel', 'The name of the template to draw the elements of this type will be the same as the name of the code.')); ?>

    <?= $form->field($model, 'viewFile')->textInput()
            ->hint(\Yii::t('yiisns/kernel', 'The path to the template. If not specified, the pattern will be the same code.')); ?>

    <?= $form->fieldRadioListBoolean($model, 'active'); ?>
    <?= $form->fieldInputInt($model, 'priority'); ?>

    <?= $form->fieldRadioListBoolean($model, 'index_for_search'); ?>

    <?= $form->fieldSelect($model, 'default_children_tree_type', \yii\helpers\ArrayHelper::map(\yiisns\kernel\models\TreeType::find()->all(), 'id', 'name'), [
            'allowDeselect' => true
        ])->hint(\Yii::t('yiisns/kernel', 'If this parameter is not specified, the child partition is created of the same type as the current one.')); ?>

<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel','Captions')); ?>
    <?= $form->field($model, 'name_one')->textInput(); ?>
    <?= $form->field($model, 'name_meny')->textInput(); ?>
<?= $form->fieldSetEnd(); ?>

<? if (!$model->isNewRecord) : ?>
    <?= $form->fieldSet(\Yii::t('yiisns/kernel','Element properties')) ?>
        <?= \yiisns\admin\widgets\RelatedModelsGrid::widget([
            'label'             => \Yii::t('yiisns/kernel','Element properties'),
            'hint'              => \Yii::t('yiisns/kernel','Every content on the site has its own set of properties, its sets here'),
            'parentModel'       => $model,
            'relation'          => [
                'tree_type_id' => 'id'
            ],
            'controllerRoute'   => 'admin/admin-tree-type-property',
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
<? endif; ?>
<?= $form->buttonsCreateOrUpdate($model); ?>
<?php ActiveForm::end(); ?>
