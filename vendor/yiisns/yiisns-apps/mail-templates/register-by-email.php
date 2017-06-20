<?php
use yiisns\mail\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $resetLink  */
?>

<?= Html::beginTag('h1'); ?>
    registration on the site <?= \Yii::$app->appSettings->appName ?>
<?= Html::endTag('h1'); ?>

<?= Html::beginTag('p'); ?>
    Hello!<br><br>You have successfully registered on the site <?= Html::a(\Yii::$app->name, \yii\helpers\Url::home(true)) ?>.<br>
<?= Html::endTag('p'); ?>

<?= Html::beginTag('p'); ?>
    To authorize on the site use the following data:
    <br>
    <b>Email: </b><?= $user->email; ?><br>
    <b>Password: </b><?= $password; ?><br>
    <?= Html::a("Authorization link", \yiisns\apps\helpers\UrlHelper::construct('apps/auth/login')
        ->setRef(
            \yiisns\apps\helpers\UrlHelper::construct('apps/profile')->enableAbsolute()->toString()
        )
        ->enableAbsolute()
        ->toString()
    ) ?>
<?= Html::endTag('p'); ?>