<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.03.2016
 */
/* @var $this yii\web\View */
/* @var $model \yiisns\kernel\models\forms\SignupForm */

use yii\helpers\Html;
use yiisns\apps\base\widgets\ActiveFormAjaxSubmit as ActiveForm;
use yiisns\apps\helpers\UrlHelper;
?>
<?= $this->render("_header", ['title' => 'Registration']); ?>
<div class="col-md-6 col-md-offset-3">

    <div class="box-static box-border-top padding-30">
        <div class="box-title margin-bottom-30">
            <h2 class="size-20">Registration</h2>
        </div>

        <?php $form = ActiveForm::begin([
            'validationUrl' => UrlHelper::construct('apps/auth/register')->setSystemParam(\yiisns\kernel\helpers\RequestResponse::VALIDATION_AJAX_FORM_SYSTEM_NAME)->toString()
        ]); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton("<i class=\"glyphicon glyphicon-off\"></i> Register", ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>
        <?= Html::a(\Yii::t('yiisns/kernel', 'Authorization'), UrlHelper::constructCurrent()->setRoute('apps/auth/login')->toString()) ?>

    </div>
</div>
<?= $this->render("_footer"); ?>