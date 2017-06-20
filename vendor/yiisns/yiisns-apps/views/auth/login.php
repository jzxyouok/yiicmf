<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.03.2016
 */
/* @var $this yii\web\View */
/* @var $model \yiisns\kernel\models\forms\LoginFormUsernameOrEmail */

use yii\helpers\Html;
use yiisns\apps\base\widgets\ActiveFormAjaxSubmit as ActiveForm;
use \yiisns\apps\helpers\UrlHelper;

$this->title = \Yii::t('yiisns/kernel', 'Authorization');
\Yii::$app->breadcrumbs->createBase()->append($this->title);
?>
<div class="row">
   <section id="sidebar-main" class="col-md-12">
        <div id="content">
            <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-6">

                    <?php $form = ActiveForm::begin([
                        'validationUrl' => UrlHelper::construct('apps/auth/login')->setSystemParam(\yiisns\kernel\helpers\RequestResponse::VALIDATION_AJAX_FORM_SYSTEM_NAME)->toString()
                    ]); ?>
                        <?= $form->field($model, 'identifier') ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>
                        <?= $form->field($model, 'rememberMe')->checkbox() ?>

                        <div class="form-group">
                            <?= Html::submitButton("<i class=\"glyphicon glyphicon-off\"></i> ".\Yii::t('yiisns/kernel', 'Log in'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                    <?= Html::a(\Yii::t('yiisns/kernel', 'Forgot your password?'), UrlHelper::constructCurrent()->setRoute('apps/auth/forget')->toString()) ?> |
                    <?= Html::a(\Yii::t('yiisns/kernel', 'Registration'), UrlHelper::constructCurrent()->setRoute('apps/auth/register')->toString()) ?>
                </div>

                <div class="col-lg-3">

                </div>
                <!--
                --><?/*= yii\authclient\widgets\AuthChoice::widget([
                     'baseAuthUrl' => ['site/auth']
                ]) */?>
            </div>
        </div>
   </section>
</div>