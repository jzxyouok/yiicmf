<?php

use yii\helpers\Html;
use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model \yiisns\kernel\models\Content */
?>


<?php $form = ActiveForm::begin(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Main')); ?>

    <?= \yiisns\admin\widgets\BlockTitleWidget::widget([
        'content' => \Yii::t('yiisns/kernel', 'Main')
    ]); ?>

    <? if ($content_type = \Yii::$app->request->get('content_type')) : ?>
        <?= $form->field($model, 'content_type')->hiddenInput(['value' => $content_type])->label(false); ?>
    <? else: ?>
        <div style="display: none;">
            <?= $form->fieldSelect($model, 'content_type', \yii\helpers\ArrayHelper::map(\yiisns\kernel\models\ContentType::find()->all(), 'code', 'name')); ?>
        </div>
    <? endif; ?>

    <?= $form->field($model, 'name')->textInput(); ?>
    <?= $form->field($model, 'code')->textInput()
        ->hint(\Yii::t('yiisns/kernel', 'The name of the template to draw the elements of this type will be the same as the name of the code.')); ?>

    <?= $form->field($model, 'viewFile')->textInput()
        ->hint(\Yii::t('yiisns/kernel', 'The path to the template. If not specified, the pattern will be the same code.')); ?>


    <?= $form->fieldRadioListBoolean($model, 'active'); ?>
    <?= $form->fieldRadioListBoolean($model, 'visible'); ?>


    <?= \yiisns\admin\widgets\BlockTitleWidget::widget([
        'content' => \Yii::t('yiisns/kernel', 'Link to section')
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->fieldSelect($model, 'default_tree_id', \yiisns\apps\helpers\TreeOptions::getAllMultiOptions(), [
                'allowDeselect' => true
            ]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->fieldRadioListBoolean($model, 'is_allow_change_tree'); ?>
        </div>
    </div>

    <?= $form->fieldSelect($model, 'root_tree_id', \yiisns\apps\helpers\TreeOptions::getAllMultiOptions(), [
        'allowDeselect' => true
    ])->hint(\Yii::t('yiisns/kernel', 'If it is set to the root partition, the elements can be tied to him and his sub.')); ?>

    <?= \yiisns\admin\widgets\BlockTitleWidget::widget([
        'content' => \Yii::t('yiisns/kernel', 'Relationship to other content')
    ]); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->fieldSelect($model, 'parent_content_id', \yiisns\kernel\models\Content::getDataForSelect(true, function(\yii\db\ActiveQuery $activeQuery) use ($model)
                {
                    if (!$model->isNewRecord)
                    {
                        $activeQuery->andWhere(['!=', 'id', $model->id]);
                    }
                }),
                [
                'allowDeselect' => true
                ]
            ); ?>
        </div>
        <div class="col-md-3">
            <?= $form->fieldRadioListBoolean($model, 'parent_content_is_required'); ?>
        </div>
        <div class="col-md-3">
            <?= $form->fieldSelect($model, 'parent_content_on_delete', \yiisns\kernel\models\Content::getOnDeleteOptions()); ?>
        </div>
    </div>
    <? if ($model->childrenContents) : ?>
        <p><b><?= \Yii::t('yiisns/kernel', 'Children content')?></b></p>
        <? foreach ($model->childrenContents as $contentChildren) : ?>
            <p><?= Html::a($contentChildren->name, \yiisns\apps\helpers\UrlHelper::construct(['/admin/admin-content/update', 'pk' => $contentChildren->id])->enableAdmin()->toString())?></p>
        <? endforeach;  ?>
    <? endif ; ?>
<?= $form->fieldSetEnd(); ?>
<? if (!$model->isNewRecord) : ?>
    <?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Properties')) ?>
        <?= \yiisns\admin\widgets\RelatedModelsGrid::widget([
            'label'             => \Yii::t('yiisns/kernel', 'Element properties'),
            'hint'              => \Yii::t('yiisns/kernel', 'Every content on the site has its own set of properties, its sets here'),
            'parentModel'       => $model,
            'relation'          => [
                'content_id' => 'id'
            ],
            'controllerRoute'   => 'admin/admin-content-property',

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

    <?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Access')); ?>
        <? \yii\bootstrap\Alert::begin([
            'options' => [
              'class' => 'alert-warning',
          ],
        ]); ?>
        <b><?= \Yii::t('yiisns/admin', 'Attention!'); ?></b> <?= \Yii::t('yiisns/admin', 'Access rights are saved in real time. Similarly, these settings are independent of the site or user.'); ?>
        <? \yii\bootstrap\Alert::end()?>

        <?= \yiisns\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
            'permissionName'        => $model->adminPermissionName,
            'label'                 => \Yii::t('yiisns/admin', 'Access to the administrative part'),
        ]); ?>



    <?= $form->fieldSetEnd(); ?>

    <?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Seo')); ?>
        <?= $form->field($model, 'meta_title_template')->textarea()->hint("Use view constructs { = model.name}"); ?>
        <?= $form->field($model, 'meta_description_template')->textarea(); ?>
        <?= $form->field($model, 'meta_keywords_template')->textarea(); ?>
    <?= $form->fieldSetEnd(); ?>

<? endif; ?>


<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Captions')); ?>
    <?= $form->field($model, 'name_one')->textInput(); ?>
    <?= $form->field($model, 'name_meny')->textInput(); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Additionally')); ?>

    <?= \yiisns\admin\widgets\BlockTitleWidget::widget([
        'content' => \Yii::t('yiisns/kernel', 'Access')
    ]); ?>
    <?= $form->fieldRadioListBoolean($model, 'access_check_element'); ?>

    <?= \yiisns\admin\widgets\BlockTitleWidget::widget([
        'content' => \Yii::t('yiisns/kernel', 'Additionally')
    ]); ?>
    <?= $form->fieldInputInt($model, 'priority'); ?>
    <?= $form->fieldRadioListBoolean($model, 'index_for_search'); ?>

<?= $form->fieldSetEnd(); ?>

<?= $form->buttonsCreateOrUpdate($model); ?>
<?php ActiveForm::end(); ?>