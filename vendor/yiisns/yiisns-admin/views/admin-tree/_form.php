<?php

use yiisns\kernel\models\Tree;
use yii\helpers\Html;
use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;

/* @var $this yii\web\View */
/* @var $model Tree */
?>

<div class="sx-box sx-p-10 sx-bg-primary" style="margin-bottom: 10px;">
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                <? if ($model->parents) : ?>
                    <? foreach ($model->parents as $tree) : ?>
                        <a href="<?= $tree->url ?>" target="_blank" title="<?=\Yii::t('yiisns/kernel','Watch to site (opens new window)')?>">
                            <?= $tree->name ?>
                            <? if ($tree->level == 0) : ?>
                                [<?= $tree->site->name; ?>]
                            <? endif;  ?>
                        </a>
                        /
                    <? endforeach; ?>
                <? endif; ?>
                <a href="<?= $model->url ?>" target="_blank" title="<?=Yii::t('yiisns/kernel', 'Watch to site (opens new window)')?>">
                    <?= $model->name; ?>
                </a>
            </div>
            <div class="pull-right">

            </div>
        </div>
    </div>
</div>

<?php $form = ActiveForm::begin(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Main')); ?>

    <?= $form->fieldRadioListBoolean($model, 'active'); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'name_hidden')->textInput(['maxlength' => 255])
                ->hint(\Yii::t('yiisns/kernel', 'Not displayed on the site')) ?>
        </div>
    </div>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 255])
        ->hint(\Yii::t('yiisns/kernel', \Yii::t('yiisns/kernel', 'This affects the address of the page, be careful when editing.'))); ?>

    <?= Html::checkbox('isLink', (bool) ($model->redirect || $model->redirect_tree_id), [
        'value'     => '1',
        'label'     => \Yii::t('yiisns/kernel', 'This section is a link'),
        'class'     => 'smartCheck',
        'id'        => 'isLink',
    ]); ?>

    <div data-listen="isLink" data-show="0" class="sx-hide">
        <?= $form->field($model, 'tree_type_id')->widget(
            \yii\widget\chosen\Chosen::className(), [
                    'items' => \yii\helpers\ArrayHelper::map(
                         \yiisns\kernel\models\TreeType::find()->active()->all(),
                         'id',
                         'name'
                     ),
            ])->label('Section type')->hint(\Yii::t('yiisns/kernel', 'On selected type of partition can depend how it will be displayed.'));
        ?>

        <?= $form->field($model, 'view_file')->textInput()
            ->hint('@app/views/template-name || template-name'); ?>

    </div>

    <div data-listen='isLink' data-show='1' class="sx-hide">
        <?= \yiisns\admin\widgets\BlockTitleWidget::widget([
            'content' => \Yii::t('yiisns/kernel', 'Redirect')
        ]); ?>
        <?= $form->field($model, 'redirect_code', [])->radioList([
                301 => 'Permanent redirection [301]',
                302 => 'Temporary redirection [302]'
            ])
            ->label(\Yii::t('yiisns/kernel', 'Redirect Code')) ?>
        <div class="row">
            <div class="col-md-5">
                <?= $form->field($model, 'redirect', [])->textInput(['maxlength' => 500])->label(\Yii::t('yiisns/kernel','Redirect'))
                    ->hint(\Yii::t('yiisns/kernel', 'Specify an absolute or relative URL for redirection, in the free form.')) ?>
            </div>
            <div class="col-md-7">
                <?= $form->field($model, 'redirect_tree_id')->widget(
                    \yiisns\apps\widgets\formInputs\selectTree\SelectTree::className(),
                    [
                        'attributeSingle' => 'redirect_tree_id',
                        'mode' => \yiisns\apps\widgets\formInputs\selectTree\SelectTree::MOD_SINGLE
                    ]
                ) ?>
            </div>
        </div>
    </div>
    <? if ($model->relatedPropertiesModel->properties) : ?>

        <?= \yiisns\admin\widgets\BlockTitleWidget::widget([
            'content' => \Yii::t('yiisns/kernel', 'Additional properties')
        ]); ?>

        <? foreach ($model->relatedPropertiesModel->properties as $property) : ?>
            <?= $property->renderActiveForm($form); ?>
        <? endforeach; ?>

    <? else : ?>
        <?/*= \Yii::t('yiisns/kernel','Additional properties are not set')*/?>
    <? endif; ?>

<?= $form->fieldSetEnd() ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Announcement')); ?>

    <?= $form->field($model, 'image_id')->widget(
        \yiisns\apps\widgets\formInputs\StorageImage::className()
    ); ?>

    <div data-listen="isLink" data-show="0" class="sx-hide">
        <?= $form->field($model, 'description_short')->widget(
            \yiisns\apps\widgets\formInputs\comboText\ComboTextInputWidget::className(),
            [
                'modelAttributeSaveType' => 'description_short_type',
            ]);
        ?>

        <?/*= $form->field($model, 'description_short')->widget(
        \yiisns\apps\widgets\formInputs\comboText\ComboTextInputWidget::className(),
        [
            'modelAttributeSaveType' => 'description_short_type',
            'ckeditorOptions' => [

                'preset'        => 'full',
                'relatedModel'  => $model,
            ],
            'codemirrorOptions' =>
            [
                'preset'    => 'php',
                'assets'    =>
                [
                    \yii\widget\codemirror\CodemirrorAsset::THEME_NIGHT
                ],

                'clientOptions'   =>
                [
                    'theme' => 'night',
                ],
            ]
        ])
        */?>

    </div>
<?= $form->fieldSetEnd() ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel','In detal')); ?>

    <?= $form->field($model, 'image_full_id')->widget(
        \yiisns\apps\widgets\formInputs\StorageImage::className()
    ); ?>

<div data-listen="isLink" data-show="0" class="sx-hide">

    <?= $form->field($model, 'description_full')->widget(
        \yiisns\apps\widgets\formInputs\comboText\ComboTextInputWidget::className(),
        [
            'modelAttributeSaveType' => 'description_full_type',
        ]);
    ?>

</div>
<?= $form->fieldSetEnd() ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel','SEO')); ?>
    <?= $form->field($model, 'meta_title')->textarea(); ?>
    <?= $form->field($model, 'meta_description')->textarea(); ?>
    <?= $form->field($model, 'meta_keywords')->textarea(); ?>
<?= $form->fieldSetEnd() ?>


<?= $form->fieldSet(\Yii::t('yiisns/kernel','Images')); ?>

    <?= $form->field($model, 'images')->widget(
        \yiisns\apps\widgets\formInputs\ModelStorageFiles::className()
    ); ?>

<?= $form->fieldSetEnd()?>


<?= $form->fieldSet(\Yii::t('yiisns/kernel','Files')); ?>

    <?= $form->field($model, 'files')->widget(
        \yiisns\apps\widgets\formInputs\ModelStorageFiles::className()
    ); ?>

<?= $form->fieldSetEnd()?>

<!--
<?/*= $form->fieldSet(\Yii::t('yiisns/kernel', 'Additionally')) */?>

    <?/*= $form->field($model, 'tree_menu_ids')->label(\Yii::t('yiisns/kernel','Marks'))->widget(
        \yiisns\apps\widgets\formInputs\EditedSelect::className(), [
            'items' => \yii\helpers\ArrayHelper::map(
                 \yiisns\kernel\models\TreeMenu::find()->all(),
                 "id",
                 "name"
             ),
            'multiple' => true,
            'controllerRoute' => 'admin/admin-tree-menu',
        ]

        )->hint(\Yii::t('yiisns/kernel', 'You can link the current section to a few marks, and according to this, section will be displayed in different menus for example.'));
    */?>

--><?/*= $form->fieldSetEnd() */?>


<?
/*$columnsFile = \Yii::getAlias('@yiisns/admin/views/admin-content-element/_columns.php');*/
/**
 * @var $content \yiisns\kernel\models\Content
 */
?>
<?/* if ($contents = \yiisns\kernel\models\Content::find()->active()->all()) : */?><!--
    <?/* foreach ($contents as $content) : */?>
        <?/*= $form->fieldSet($content->name) */?>


            <?/*= \yiisns\admin\widgets\RelatedModelsGrid::widget([
                'label'             => $content->name,
                'hint'              => \Yii::t('yiisns/kernel',"Showing all elements of type '{name}' associated with this section. Taken into account only the main binding.",['name' => $content->name]),
                'parentModel'       => $model,
                'relation'          => [
                    'tree_id'       => 'id',
                    'content_id'    => $content->id
                ],

                'sort'              => [
                    'defaultOrder' =>
                    [
                        'priority' => 'published_at'
                    ]
                ],

                'controllerRoute'   => 'admin/admin-content-element',
                'gridViewOptions'   => [
                    'columns' => (array) include $columnsFile
                ],
            ]); */?>

        <?/*= $form->fieldSetEnd() */?>
    <?/* endforeach; */?>
--><?/* endif; */?>

<?= $form->buttonsCreateOrUpdate($model); ?>

<? $this->registerJs(<<<JS
    (function(sx, $, _)
    {
        sx.createNamespace('classes', sx);

        sx.classes.SmartCheck = sx.classes.Component.extend({

            _init: function()
            {},

            _onDomReady: function()
            {
                var self = this;

                this.JsmartCheck = $('.smartCheck');

                self.updateInstance($(this.JsmartCheck));

                this.JsmartCheck.on("change", function()
                {
                    self.updateInstance($(this));
                });
            },

            updateInstance: function(JsmartCheck)
            {
                if (!JsmartCheck instanceof jQuery)
                {
                    throw new Error('1');
                }

                var id  = JsmartCheck.attr('id');
                var val = Number(JsmartCheck.is(":checked"));

                if (!id)
                {
                    return false;
                }

                if (val == 0)
                {
                    $('#tree-redirect').val('');
                    $('#tree-redirect_tree_id').val('');
                }

                $('[data-listen="' + id + '"]').hide();
                $('[data-listen="' + id + '"][data-show="' + val + '"]').show();

            },
        });

        new sx.classes.SmartCheck();
    })(sx, sx.$, sx._);
JS
);
?>
<?php ActiveForm::end(); ?>