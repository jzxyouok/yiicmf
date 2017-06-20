<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.06.2016
 */
/* @var $this yii\web\View */
/* @var $model \yiisns\kernel\models\Extension */
?>

<? if ($model->marketplacePackage) : ?>
    <?= $this->render('_package-column', [
        'model' => $model->marketplacePackage
    ]); ?>
<? else : ?>
    <div>
        <p>
            <a data-pjax="0" href="<?= $model->getPackagistUrl(); ?>" class="btn btn-default btn-xs" target="_blank" title="<?=\Yii::t('yiisns/marketplace', 'Watch to {site} (opens in new window)', ['site' => 'Packagist.org'])?>">
                <?= $model->name; ?>
                <i class="glyphicon glyphicon-search"></i>
            </a>
        </p>
    </div>
<? endif; ?>