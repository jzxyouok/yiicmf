<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.03.2016
 */
/* @var $this yii\web\View */
/* @var $model \yiisns\kernel\models\forms\PasswordResetRequestFormEmailOrLogin */

use yii\helpers\Html;
use yiisns\apps\base\widgets\ActiveFormAjaxSubmit as ActiveForm;
use \yiisns\apps\helpers\UrlHelper;

?>

<?= $this->render('_header', ['title' => 'Recovery password']); ?>
<div class="col-md-6 col-md-offset-3">

    <div class="box-static box-border-top padding-30">
        <div class="box-title margin-bottom-30">
            <h2 class="size-20">Recovery password</h2>
        </div>

        <?php $form = ActiveForm::begin([
            'validationUrl' => UrlHelper::construct('apps/auth/forget')->setSystemParam(\yiisns\kernel\helpers\RequestResponse::VALIDATION_AJAX_FORM_SYSTEM_NAME)->toString()
        ]); ?>
            <?= $form->field($model, 'identifier') ?>

            <div class="form-group">
                <?= Html::submitButton(\Yii::t('yiisns/kernel', 'Send', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>
        <?= Html::a(\Yii::t('yiisns/kernel', 'authorization'), UrlHelper::constructCurrent()->setRoute('apps/auth/login')->toString()) ?> |
        <?= Html::a(\Yii::t('yiisns/kernel', 'registration'), UrlHelper::constructCurrent()->setRoute('apps/auth/register')->toString()) ?>

    </div>
</div>
<?= $this->render("_footer"); ?>