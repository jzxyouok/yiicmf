<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.03.2016
 *
 * @var \yiisns\kernel\models\ContentElement $model
 *
 */
?>

<div class="row margin-bottom-20">
    <div class="col-sm-4 sm-margin-bottom-20">
        <? if ($model->image) : ?>
            <img src="<?= \Yii::$app->imaging->getImagingUrl($model->image->src,
            new \yiisns\apps\components\imaging\filters\Thumbnail([
                'w'    => 409,
                'h'    => 258,
            ])
        ) ?>" title="<?= $model->name; ?>" alt="<?= $model->name; ?>" class="img-responsive" />
        <? else: ?>
            <img src="<?= \yiisns\apps\helpers\Image::getCapSrc(); ?>" title="<?= $model->name; ?>" alt="<?= $model->name; ?>" class="img-responsive" />
        <? endif; ?>

    </div>
    <div class="col-sm-8 news-v3">
        <div class="news-v3-in-sm no-padding">
            <h2>
                <a href="<?= $model->url; ?>" title="<?= $model->name; ?>"><?= $model->name; ?></a>
            </h2>

            <ul class="list-inline posted-info">
                <? if ($model->createdBy) : ?>
                    <li><?=\Yii::t('yiisns/search', 'Added')?>: <a href="<?= $model->createdBy->getPageUrl(); ?>" title="<?= $model->createdBy->name; ?>"><?= $model->createdBy->name; ?></a></li>
                <? endif; ?>
                <? if ($model->tree) : ?>
                    <li><?=\Yii::t('yiisns/search', 'Category')?>: <a href="<?= $model->tree->url; ?>" title="<?= $model->tree->name; ?>"><?= $model->tree->name; ?></a></li>
                <? endif; ?>
                <li><?=\Yii::t('yiisns/search', 'Time of publication')?>: <?= \Yii::$app->formatter->asDate($model->published_at, 'full')?></li>
                <? if ($testValue = $model->relatedPropertiesModel->getAttribute('test')) : ?>
                    <li><?= $model->relatedPropertiesModel->getAttributeLabel('test'); ?>: <?= $testValue; ?></li>
                <? endif; ?>
            </ul>

            <p><?= $model->description_short; ?></p>
            <p><a href="<?= $model->url; ?>"><?=\Yii::t('yiisns/search', 'Read completely')?></a></p>

        </div>
    </div>
</div>

<div class="clearfix margin-bottom-20"><hr></div>