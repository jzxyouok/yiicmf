<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 24.06.2016
 */
/* @var $this yii\web\View */
/* @var string $packagistCode */
/* @var $packageModel PackageModel */
$packageModel = \yiisns\marketplace\models\PackageModel::fetchByCode('yiisns');  // 这里需要注意一下
?>

<div id="sx-search" style="margin-bottom: 10px;">
    <p><b><a data-pjax="0" target="_blank" href="<?= $packageModel->url; ?>"><?=\Yii::t('yiisns/marketplace','{yii} Version',['yii' => 'YiiSNS'])?></a>: </b> <?= \Yii::$app->appSettings->descriptor->version; ?></p>
    <p><b><?=\Yii::t('yiisns/marketplace', '{yii} Version',['yii' => 'Yii'])?>: </b> <?= Yii::getVersion(); ?></p>
</div>
<hr />
<p>
    Use the manual to update the project:
    <a href="http://dev.yiisns.cn/docs/dev/ustanovka-nastroyka-konfigurirov/obnovlenie" target="_blank">
        How do I update the YiiSNS?
    </a>
</p>
<p>
    Contact YiiSNS Developers: <a href="http://www.yiisns.cn/contacts" target="_blank"><?=\Yii::t('yiisns/marketplace', 'Connect with Developers'); ?></a>.
</p>