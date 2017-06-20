<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 24.06.2016
 */
/* @var $this yii\web\View */
/* @var $packageModel PackageModel */

use yiisns\marketplace\models\PackageModel;
use yiisns\marketplace\models\Extension;
$self = $this;
?>
<? if ($code = \Yii::$app->request->get("code")) : ?>
    <div class="sx-box sx-p-10 sx-mb-10">

        <? if ($packageModel = PackageModel::fetchByCode($code)) : ?>

             <?= $this->render('catalog-package', [
                'packageModel' => $packageModel
            ])?>

        <? else: ?>
            <?= \Yii::t('yiisns/marketplace', 'The extension is not found') ?>
        <? endif; ?>
    </div>
<? else : ?>
    <? \yii\bootstrap\Alert::begin([
        'options' => [
          'class' => 'alert-info',
      ]
    ]); ?>
        <p><?= \Yii::t('yiisns/marketplace', 'You can choose the suitable solution for your project and install it.') ?></p>
        <p><?= \Yii::t('yiisns/marketplace', 'Future versions will be integrated {market} here. For now, simply click the link below.',['market' => \Yii::t('yiisns/marketplace', 'Marketplace')])?></p>
    <? \yii\bootstrap\Alert::end(); ?>

    <div class="sx-marketplace">
        <a href="http://marketplace.yiisns.cn" target="_blank">marketplace.yiisns.cn</a> — <?=\Yii::t('yiisns/marketplace', 'catalog of available solutions')?>
    </div>
<?
$this->registerCss(<<<CSS
.sx-marketplace
{
    text-align: center;
    font-size: 30px;
    color: #e74c3c;
}
    .sx-marketplace a
    {
        font-size: 30px;
        color: #e74c3c;
    }
CSS
);
?>
<? endif; ?>