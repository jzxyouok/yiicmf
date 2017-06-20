<?php
use yiisns\apps\mail\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $resetLink  */
if (!$resetLink)
{
    $resetLink = \yiisns\apps\helpers\UrlHelper::construct('admin/auth/reset-password', ['token' => $user->password_reset_token])->enableAbsolute()->enableAdmin();
}
?>

<?= Html::beginTag('h1'); ?>
    Reminder password for <?= \Yii::$app->appSettings->appName ?>
<?= Html::endTag('h1'); ?>

<?= Html::beginTag('p'); ?>
    Hello!<br><br>I received a request to change my password on the site<?= Html::a(\Yii::$app->name, \yii\helpers\Url::home(true)) ?>.<br>
    <?= Html::a("Follow the link", $resetLink) ?> And we will send you a new password.<br>If you did not request a password change, simply ignore this email.
<?= Html::endTag('p'); ?>
