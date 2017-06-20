<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.03.2016
 */
use yii\helpers\Html;
use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;

/* @var $this yii\web\View */
/* @var $model \yiisns\kernel\models\WidgetConfig */
?>
<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Main Settings')); ?>

<?php //\yiisns\admin\widgets\BlockTitleWidget::widget(['content' => \Yii::t('yiisns/kernel', 'Main')])?>
    <?= $form->field($model, 'appName')->textInput(); ?>

    <?= $form->field($model, 'adminEmail')->textInput(); ?>

    <?=$form->field($model, 'noImageUrl')->widget(\yiisns\admin\widgets\formInputs\OneImage::className())->hint(\Yii::t('yiisns/kernel', 'This image is displayed when not found'));?>

<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'PasswordResetTokenExpire')); ?>
    <?= $form->fieldInputInt($model, 'passwordResetTokenExpire')->hint(\Yii::t('yiisns/kernel', 'Password token expires after this time')); ?>
<?= $form->fieldSetEnd(); ?>


<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Roles Settings')); ?>
    <?=$form->fieldSelectMulti($model, 'registerRoles', \yii\helpers\ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description')); ?>

<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Tree_max_code_length')); ?>
    <?= $form->field($model, 'tree_max_code_length'); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Element_max_code_length')); ?>
    <?= $form->field($model, 'element_max_code_length'); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Access Settings')); ?>
<?  
\yii\bootstrap\Alert::begin([
        'options' => [
            'class' => 'alert-warning'
        ]
    ]);
?>
<b><?= \Yii::t('yiisns/kernel', 'Notice!');?></b>
<?= \Yii::t('yiisns/kernel', 'Real time access, which does not depend on the same site or user'); ?>
<? \yii\bootstrap\Alert::end()?>

    <?=\yiisns\admin\widgets\BlockTitleWidget::widget(['content' => 'Aceess'])?>

    <?=\yiisns\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget(['permissionName' => \yiisns\rbac\SnsManager::PERMISSION_ELFINDER_USER_FILES,'label' => 'Access to personal files']);?>

    <?=\yiisns\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget(['permissionName' => \yiisns\rbac\SnsManager::PERMISSION_ELFINDER_COMMON_PUBLIC_FILES,'label' => 'Access to shared files']);?>

    <?=\yiisns\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget(['permissionName' => \yiisns\rbac\SnsManager::PERMISSION_ELFINDER_ADDITIONAL_FILES,'label' => 'Access to all files']);?>

<?= $form->fieldSetEnd(); ?>