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
use \yiisns\apps\helpers\UrlHelper;

$this->title = \Yii::t('yiisns/kernel', 'Registration');
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
                        'validationUrl' => UrlHelper::construct('apps/auth/register')->setSystemParam(\yiisns\kernel\helpers\RequestResponse::VALIDATION_AJAX_FORM_SYSTEM_NAME)->toString()
                    ]); ?>
                        <?= $form->field($model, 'username') ?>
                        <?= $form->field($model, 'email') ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <div class="form-group">
                            <?= Html::submitButton("<i class=\"glyphicon glyphicon-off\"></i> ".\Yii::t('yiisns/kernel', 'Sign up'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                    <?= Html::a(\Yii::t('yiisns/kernel', 'Authorization'), UrlHelper::constructCurrent()->setRoute('apps/auth/login')->toString()) ?>
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