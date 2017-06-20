<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.03.2016
 */
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \yiisns\kernel\models\WidgetConfig */

?>

<?= $form->fieldSet(\Yii::t('yiisns/assets-auto', 'Main Settings')); ?>
    <?= $form->field($model, 'enabled')->radioList(\Yii::$app->formatter->booleanFormat)->hint('This option disables and enables the operation of the entire component. Turning off all other settings will not be taken into account.'); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/assets-auto', 'Js processing in html')); ?>
    <?= $form->field($model, 'jsCompress')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'jsCompressFlaggedComments')->radioList(\Yii::$app->formatter->booleanFormat); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/assets-auto', 'Css processing in html')); ?>
    <?= $form->field($model, 'cssCompress')->radioList(\Yii::$app->formatter->booleanFormat); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/assets-auto', 'Processing css files')); ?>
    <?= $form->field($model, 'cssFileCompile')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'cssFileRemouteCompile')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'cssFileCompress')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'cssFileBottom')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'cssFileBottomLoadOnJs')->radioList(\Yii::$app->formatter->booleanFormat); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/assets-auto', 'Processing js files')); ?>
    <?= $form->field($model, 'jsFileCompile')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'jsFileRemouteCompile')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'jsFileCompress')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'jsFileCompressFlaggedComments')->radioList(\Yii::$app->formatter->booleanFormat); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/assets-auto', 'HTML Processing')); ?>
    <?= $form->field($model, 'htmlCompress')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'htmlCompressExtra')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'htmlCompressNoComments')->radioList(\Yii::$app->formatter->booleanFormat); ?>
<?= $form->fieldSetEnd(); ?>