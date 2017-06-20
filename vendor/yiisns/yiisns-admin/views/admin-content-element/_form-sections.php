<?php
/* @var $this yii\web\View */
/* @var $model \yiisns\kernel\models\ContentElement */
/* @var $relatedModel \yiisns\apps\relatedProperties\models\RelatedPropertiesModel */
?>
<?= $form->fieldSet(\Yii::t('yiisns/kernel','Sections')); ?>
    <? if ($contentModel->root_tree_id) : ?>
        <? $rootTreeModels = \yiisns\kernel\models\Tree::findAll($contentModel->root_tree_id); ?>
    <? else : ?>
        <? $rootTreeModels = \yiisns\kernel\models\Tree::findRoots()->joinWith('siteRelation')->orderBy([\yiisns\kernel\models\Site::tableName() . '.priority' => SORT_ASC])->all(); ?>
    <? endif; ?>
    <? if ($contentModel->is_allow_change_tree == \yiisns\kernel\base\AppCore::BOOL_Y) : ?>
        <? if ($rootTreeModels) : ?>
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <?= $form->field($model, 'tree_id')->widget(
                        \yiisns\apps\widgets\formInputs\selectTree\SelectTreeInputWidget::class,
                        [
                            'multiple' => false,
                            'treeWidgetOptions' =>
                            [
                                'models' => $rootTreeModels
                            ]
                        ]
                    ); ?>
                </div>
            </div>
        <? endif; ?>
    <? endif; ?>

    <? if ($rootTreeModels) : ?>
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <?= $form->field($model, 'treeIds')->widget(
                    \yiisns\apps\widgets\formInputs\selectTree\SelectTreeInputWidget::class,
                    [
                        'multiple' => true,
                        'treeWidgetOptions' =>
                        [
                            'models' => $rootTreeModels
                        ]
                    ]
                ); ?>
            </div>
        </div>
    <? endif; ?>
<?= $form->fieldSetEnd()?>