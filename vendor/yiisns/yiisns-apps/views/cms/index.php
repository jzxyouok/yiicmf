<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 13.04.2016
 */
/* @var $this yii\web\View */
$this->title = 'CMF (content management framework, YiiCMF Yii2)';
?>

<div style="text-align: center; padding: 100px;">
    <p>Content management Framework: <?= \yii\helpers\Html::a("YiiSNS (Yii2)", \Yii::$app->appSettings->descriptor->homepage, [
        'target' => '_blank'
    ]); ?></p>
    <p>@author <?= \yii\helpers\Html::a('YiiSNS', 'http://www.yiisns.cn', [
        'target' => '_blank'
    ]); ?></p>
</div>