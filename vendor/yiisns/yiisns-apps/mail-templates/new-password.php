<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
?>

<h1 style="color:#1D5800;font-size:32px;font-weight:normal;margin-bottom:13px;margin-top:20px;">New password for <?= \Yii::$app->appSettings->appName; ?></h1>

<p style="font:Arial,Helvetica,sans-serif;">
    Hello!<br><br>To authorize on the site <?= Html::a(\Yii::$app->appSettings->appName, \yii\helpers\Url::home(true)) ?> Use the new password.<br>
    <b><?= $password ?></b>
</p>