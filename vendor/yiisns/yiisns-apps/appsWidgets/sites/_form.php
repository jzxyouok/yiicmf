<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.05.2016
 */
/* @var $this yii\web\View */
?>
<?= $form->fieldSet('Display'); ?>
    <?= $form->field($model, 'viewFile')->textInput(); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet('Filter'); ?>
    <?= $form->fieldSelect($model, 'active', \Yii::$app->appCore->booleanFormat()); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet('Sorting'); ?>
    <?= $form->fieldSelect($model, 'orderBy', (new \yiisns\kernel\models\Site())->attributeLabels()); ?>
    <?= $form->fieldSelect($model, 'order', [
        SORT_ASC    => "ASC (from lowest to highest)",
        SORT_DESC   => "DESC (from highest to lowest)",
    ]); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet('Further'); ?>
    <?= $form->field($model, 'label')->textInput(); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet('The cache settings'); ?>
    <?= $form->fieldRadioListBoolean($model, 'enabledRunCache', \Yii::$app->appCore->booleanFormat()); ?>
    <?= $form->fieldInputInt($model, 'runCacheDuration'); ?>
<?= $form->fieldSetEnd(); ?>