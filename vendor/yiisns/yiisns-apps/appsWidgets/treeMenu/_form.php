<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.05.2016
 */
/* @var $this yii\web\View */
?>
<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Template')); ?>
    <?= $form->field($model, 'viewFile')->textInput(); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Filtration')); ?>
    <?= $form->field($model, 'enabledCurrentSite')->listBox(\yii\helpers\ArrayHelper::merge([null => '-'], \Yii::$app->appCore->booleanFormat()), ['size' => 1]); ?>
    <?= $form->field($model, 'active')->listBox(\yii\helpers\ArrayHelper::merge([null => '-'], \Yii::$app->appCore->booleanFormat()), ['size' => 1]); ?>

    <?= $form->fieldSelectMulti($model, 'tree_type_ids', \yii\helpers\ArrayHelper::map(
        \yiisns\kernel\models\TreeType::find()->all(), 'id', 'name'
    )); ?>

    <?= $form->fieldInputInt($model, 'level'); ?>
    <?= $form->fieldSelectMulti($model, 'site_codes', \yii\helpers\ArrayHelper::map(
        \yiisns\kernel\models\Site::find()->active()->all(),
        'code',
        'name'
    )); ?>
    <?= $form->field($model, 'treePid')->widget(
        \yiisns\apps\widgets\formInputs\selectTree\SelectTreeInputWidget::class
    ); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Sorting')); ?>
    <?= $form->fieldSelect($model, 'orderBy', (new \yiisns\kernel\models\Tree())->attributeLabels()); ?>
    <?= $form->fieldSelect($model, 'order', [
        SORT_ASC    => \Yii::t('yiisns/kernel', 'ASC (from lowest to highest)'),
        SORT_DESC   => \Yii::t('yiisns/kernel', 'DESC (from highest to lowest)'),
    ]); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Additionally')); ?>
    <?= $form->field($model, 'label')->textInput(); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Cache settings')); ?>
    <?= $form->fieldRadioListBoolean($model, 'enabledRunCache', \Yii::$app->appCore->booleanFormat()); ?>
    <?= $form->fieldInputInt($model, 'runCacheDuration'); ?>
<?= $form->fieldSetEnd(); ?>