<?php
use yii\helpers\Html;

use yii\widgets\ActiveForm;
/**
 * index
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 14.10.2014
 * @since 1.0.0
 */

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $personal bool */

$this->title = $model->getDisplayName();
?>

<?= \Yii::$app->view->render('_header', [
    'model'     => $model,
    'personal'  => $personal,
    'title'     => 'Management settings',
]); ?>


<div class="tab-v1">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#profile">Personal data</a></li>
        <li><a data-toggle="tab" href="#passwordTab">Change the password</a></li>
    </ul>
    <div class="tab-content">
        <div id="profile" class="profile-edit tab-pane fade in active">

            <? $modelForm = $model; ?>
            <? $form = \yiisns\apps\base\widgets\ActiveFormAjaxSubmit::begin([
                'validationUrl' => \yiisns\apps\helpers\UrlHelper::construct('apps/user/edit-info', ['username' => $model->username])->setSystemParam(\yiisns\kernel\helpers\RequestResponse::VALIDATION_AJAX_FORM_SYSTEM_NAME)->toString(),
                'action'        => \yiisns\apps\helpers\UrlHelper::construct('apps/user/edit-info', ['username' => $model->username])->toString(),

                'afterValidateCallback' => new \yii\web\JsExpression(<<<JS
    function(jForm, ajax)
    {
        var handler = new sx.classes.AjaxHandlerStandartRespose(ajax, {
            'enableBlocker' : true,
            'blockerSelector' : '#' + jForm.attr('id')
        });

        handler.bind('success', function(e, response)
        {});
    }
JS
)
            ]); ?>

                <?= $form->field($model, 'image_id')->widget(
                    \yiisns\apps\widgets\formInputs\StorageImage::className()
                ) ?>

                <?= $form->field($model, 'username')->textInput(['maxlength' => 12])->hint('A unique user name. is used for the authentication, for a reference to the private office.'); ?>
                <?= $form->field($model, 'name')->textInput(); ?>

                <?= $form->field($model, 'email')->textInput(); ?>
                <?= $form->field($model, 'phone')->textInput(); ?>

                <?= $form->field($model, 'gender')->radioList([
                    'men' => 'men',
                    'women' => 'women',
                ]); ?>
                <?= $form->field($model, 'city')->textInput(); ?>
                <?= $form->field($model, 'address')->textInput(); ?>
                <?= $form->field($model, 'info')->textarea(); ?>
                <?/*= $form->field($model, 'status_of_life')->textarea(); */?>

                <button class="btn btn-primary">Сохранить</button>
            <? \yiisns\apps\base\widgets\ActiveFormAjaxSubmit::end(); ?>

        </div>

        <div id="passwordTab" class="profile-edit tab-pane fade">
            <? $modelForm = new \yiisns\kernel\models\forms\PasswordChangeForm(); ?>
            <? $form = \yiisns\apps\base\widgets\ActiveFormAjaxSubmit::begin([
                'validationUrl' => \yiisns\apps\helpers\UrlHelper::construct('apps/user/change-password', ['username' => $model->username])->setSystemParam(\yiisns\kernel\helpers\RequestResponse::VALIDATION_AJAX_FORM_SYSTEM_NAME)->toString(),
                'action'        => \yiisns\apps\helpers\UrlHelper::construct('apps/user/change-password', ['username' => $model->username])->toString()
            ]); ?>
                <?= $form->field($modelForm, 'new_password')->passwordInput() ?>
                <?= $form->field($modelForm, 'new_password_confirm')->passwordInput() ?>
                <button class="btn btn-primary">Change</button>
            <? \yiisns\apps\base\widgets\ActiveFormAjaxSubmit::end(); ?>
        </div>

        <div id="settings" class="profile-edit tab-pane fade"></div>
    </div>
</div>
<?= $this->render('_footer'); ?>