<?php
use yiisns\mail\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $resetLink  */
?>

<?= Html::beginTag('h1'); ?>
    Testing the sending of letters from the site <?= \Yii::$app->appSettings->appName ?>
<?= Html::endTag('h1'); ?>

<?= Html::beginTag('p'); ?>
    Hello!<br><br>Sending is done from the site <?= Html::a(\Yii::$app->name, \yii\helpers\Url::home(true)) ?>.<br>
    You can simply delete this email.
<?= Html::endTag('p'); ?>