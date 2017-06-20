<?php
use yii\helpers\Html;
use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model \yiisns\kernel\models\User */
/* @var $console \yiisns\apps\controllers\AdminUserController */
?>

<?php $form = \yiisns\admin\widgets\form\ActiveFormUseTab::begin(); ?>
<?php  ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'General information'))?>

    <?= $form->fieldRadioListBoolean($model, 'active'); ?>

    <?= $form->field($model, 'gender')->radioList([
        'men'   => \Yii::t('yiisns/kernel','Male'),
        'women' => \Yii::t('yiisns/kernel','Female'),
    ]); ?>

    <?= $form->field($model, 'image_id')->widget(
        \yiisns\apps\widgets\formInputs\StorageImage::className()
    ); ?>

    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'username')->textInput(['maxlength' => 25])->hint(\Yii::t('yiisns/kernel','The unique username. Used for authorization and to form links to personal cabinet.')); ?>
        </div>
        <div class="col-md-5">
            <?= $form->field($model, 'name')->textInput(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'email')->textInput(); ?>
            <? if (\Yii::$app->user->can(\yiisns\rbac\SnsManager::PERMISSION_USER_FULL_EDIT)) : ?>
                <?= $form->field($model, 'email_is_approved')->checkbox(\Yii::$app->formatter->booleanFormat); ?>
            <? endif; ?>
        </div>
        <div class="col-md-5">
            <?
\yiisns\admin\assets\JqueryMaskInputAsset::register($this);
$id = \yii\helpers\Html::getInputId($model, 'phone');
$this->registerJs(<<<JS
$("#{$id}").mask("+86 999 9999-9999");
JS
);
?>
            <?= $form->field($model, 'phone')->textInput([
                'placeholder' => '+86 999 9999-9999'
            ]); ?>
            <? if (\Yii::$app->user->can(\yiisns\rbac\SnsManager::PERMISSION_USER_FULL_EDIT)) : ?>
                <?= $form->field($model, 'phone_is_approved')->checkbox(\Yii::$app->formatter->booleanFormat); ?>
            <? endif; ?>
        </div>
    </div>
    
    <? if ($model->relatedProperties) : ?>
        <?= \yiisns\admin\widgets\BlockTitleWidget::widget([
            'content' => \Yii::t('yiisns/kernel', 'Additional properties')
        ]); ?>
        <? if ($properties = $model->relatedProperties) : ?>
            <? foreach ($properties as $property) : ?>
                <?= $property->renderActiveForm($form, $model)?>
            <? endforeach; ?>
        <? endif; ?>

    <? else : ?>
        <?/*= \Yii::t('yiisns/kernel','Additional properties are not set')*/?>
    <? endif; ?>


<?= $form->fieldSetEnd(); ?>

<? if (\Yii::$app->user->can(\yiisns\rbac\SnsManager::PERMISSION_USER_FULL_EDIT)) : ?>
    <?= $form->fieldSet(\Yii::t('yiisns/kernel','Role groups'))?>

        <? $this->registerCss(<<<CSS
    .sx-checkbox label
    {
        width: 100%;
    }
CSS
    )?>
        <?= $form->field($model, 'roleNames')->checkboxList(
            \yii\helpers\ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description'), [
                'class' => 'sx-checkbox'
            ]
        ); ?>

    <?= $form->fieldSetEnd(); ?>
<? endif; ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Password')); ?>

    <?= $form->field($passwordChange, 'new_password')->passwordInput() ?>
    <?= $form->field($passwordChange, 'new_password_confirm')->passwordInput() ?>

<?= $form->fieldSetEnd(); ?>

<?/*= $form->fieldSet(\Yii::t('yiisns/kernel','Additionally'))*/?><!--
    <?/*= $form->field($model, 'city')->textInput(); */?>
    <?/*= $form->field($model, 'address')->textInput(); */?>
    <?/*= $form->field($model, 'info')->textarea(); */?>
    <?/*= $form->field($model, 'status_of_life')->textarea(); */?>
--><?/*= $form->fieldSetEnd(); */?>

<? if (!$model->isNewRecord && class_exists('\yiisns\apps\authclient\models\UserAuthClient')) : ?>
    <?= $form->fieldSet(\Yii::t('yiisns/authclient', 'Social profiles'))?>
        <?= \yiisns\admin\widgets\RelatedModelsGrid::widget([
            'label'             => \Yii::t('yiisns/authclient', 'Social profiles'),
            'hint'              => '',
            'parentModel'       => $model,
            'relation'          => [
                'user_id' => 'id'
            ],
            'controllerRoute'   => 'authclient/admin-user-auth-client',
            'gridViewOptions'   => [
                'columns' => [
                    'displayName'
                ],
            ],
        ]); ?>
    <?= $form->fieldSetEnd(); ?>
<? endif; ?>

<?= $form->buttonsStandart($model); ?>
<?php \yiisns\admin\widgets\form\ActiveFormUseTab::end(); ?>