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

<?= $form->fieldSet(\Yii::t('yiisns/admin', 'Main')); ?>
    <?= $form->fieldRadioListBoolean($model, 'enableCustomConfirm') ?>
    <?= $form->fieldRadioListBoolean($model, 'enableCustomPromt') ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/admin', 'Language settings')); ?>
    <?= $form->fieldSelect($model, 'languageCode', \yii\helpers\ArrayHelper::map(
        \yiisns\kernel\models\Lang::find()->active()->all(),
        'code',
        'name'
    )); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/admin', 'Setting tables')); ?>
    <?= $form->fieldRadioListBoolean($model, 'enabledPjaxPagination', \Yii::$app->appCore->booleanFormat()); ?>
    <?= $form->fieldInputInt($model, 'pageSize'); ?>
    <?= $form->fieldInputInt($model, 'pageSizeLimitMin'); ?>
    <?= $form->fieldInputInt($model, 'pageSizeLimitMax'); ?>
    <?= $form->field($model, 'pageParamName')->textInput(); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/admin', 'Setting the visual editor')); ?>
    <?= $form->fieldSelect($model, 'ckeditorPreset', \yii\ckeditor\CKEditorPresets::allowPresets()); ?>
    <?= $form->fieldSelect($model, 'ckeditorSkin', \yii\ckeditor\CKEditorPresets::skins()); ?>
    <?= $form->fieldInputInt($model, 'ckeditorHeight'); ?>
    <?= $form->fieldRadioListBoolean($model, 'ckeditorCodeSnippetGeshi')->hint(\Yii::t('yiisns/admin', 'It will be activated this plugin') . ' http://ckeditor.com/addon/codesnippetgeshi'); ?>
    <?= $form->fieldSelect($model, 'ckeditorCodeSnippetTheme', [
        'monokai_sublime' => 'monokai_sublime',
        'default' => 'default',
        'arta' => 'arta',
        'ascetic' => 'ascetic',
        'atelier-dune.dark' => 'atelier-dune.dark',
        'atelier-dune.light' => 'atelier-dune.light',
        'atelier-forest.dark' => 'atelier-forest.dark',
        'atelier-forest.light' => 'atelier-forest.light',
        'atelier-heath.dark' => 'atelier-heath.dark',
        'atelier-heath.light' => 'atelier-heath.light',
        'atelier-lakeside.dark' => 'atelier-lakeside.dark',
        'atelier-lakeside.light' => 'atelier-lakeside.light',
    ])->hint('https://highlightjs.org/static/demo/ - ' . \Yii::t('yiisns/admin', 'topics')); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/admin', 'Security')); ?>
    <?= $form->fieldInputInt($model, 'blockedTime')->hint(\Yii::t('yiisns/admin', 'If a user, for a specified time, not active in the admin panel, it will be prompted for a password')); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/admin', 'Access')); ?>

    <?= \yiisns\admin\widgets\BlockTitleWidget::widget(['content' => 'Main']); ?>

    <?= \yiisns\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
        'permissionName'        => \yiisns\rbac\SnsManager::PERMISSION_ADMIN_ACCESS,
        'label'                 => \Yii::t('yiisns/admin', 'Access to the administrate area'),
    ]); ?>

    <?= \yiisns\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
        'permissionName'        => \yiisns\rbac\SnsManager::PERMISSION_EDIT_VIEW_FILES,
        'label'                 => \Yii::t('yiisns/admin', 'The ability to edit view files'),
    ]); ?>

    <?= \yiisns\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
        'permissionName'        => "admin/admin-settings",
        'label'                 => \Yii::t('yiisns/admin', 'The ability to edit settings'),
    ]); ?>

    <?= \yiisns\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
        'permissionName'        => \yiisns\rbac\SnsManager::PERMISSION_ADMIN_DASHBOARDS_EDIT,
        'label'                 => \Yii::t('yiisns/admin', 'Access to edit dashboards'),
    ]); ?>

    <?= \yiisns\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
        'permissionName'        => \yiisns\rbac\SnsManager::PERMISSION_USER_FULL_EDIT,
        'label'                 => \Yii::t('yiisns/admin', 'The ability to manage user groups'),
    ]); ?>


    <?= \yiisns\admin\widgets\BlockTitleWidget::widget(['content' => \Yii::t('yiisns/admin',"Control recodrs")]); ?>

    <?= \yiisns\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
        'permissionName'        => \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_CREATE,
        'label'                 => \Yii::t('yiisns/admin', 'The ability to manage user groups'),
    ]); ?>

    <?= \yiisns\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
        'permissionName'        => \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_UPDATE,
        'label'                 => \Yii::t('yiisns/admin', 'The ability to update records'),
    ]); ?>

    <?= \yiisns\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
        'permissionName'        => \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_UPDATE_ADVANCED,
        'label'                 => \Yii::t('yiisns/admin', 'The ability to update service information at records'),
    ]); ?>

    <?= \yiisns\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
        'permissionName'        => \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_DELETE,
        'label'                 => \Yii::t('yiisns/admin', 'Ability to delete records'),
    ]); ?>

    <?= \yiisns\admin\widgets\BlockTitleWidget::widget(['content' => \Yii::t('yiisns/admin','Control only own records')]); ?>

    <?= \yiisns\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
        'permissionName'        => \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_UPDATE_OWN,
        'label'                 => \Yii::t('yiisns/admin', 'The ability to update their records'),
    ]); ?>

    <?= \yiisns\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
        'permissionName'        => \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_UPDATE_ADVANCED_OWN,
        'label'                 => \Yii::t('yiisns/admin', 'The ability to update service information at records'),
    ]); ?>

    <?= \yiisns\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
        'permissionName'        => \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_DELETE_OWN,
        'label'                 => \Yii::t('yiisns/admin', 'Ability to delete own records'),
    ]); ?>
<?= $form->fieldSetEnd(); ?>