<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.03.2016
 *
 * @var \yiisns\kernel\models\ContentElement $model
 */
?>
<div class="row margin-bottom-20">

        <? if ($model->image->src) : ?>
    <div class="col-sm-4 sm-margin-bottom-20">
            <img src="<?= \yiisns\apps\helpers\Image::getSrc($model->image->src); ?><?/*= \Yii::$app->imaging->getImagingUrl($model->getMainImageSrc(),
            new \yiisns\apps\components\imaging\filters\Thumbnail([
                'w'    => 409,
                'h'    => 258,
            ])
        ) */?>" title="<?= $model->name; ?>" alt="<?= $model->name; ?>" class="img-responsive" />
    </div>
    <div class="col-sm-8 news-v3">
        <? else :?>
        <div class="col-sm-12 news-v3">
        <? endif; ?>
        <div class="news-v3-in-sm no-padding">
            <h2>
                <a href="<?= $model->url; ?>" title="<?= $model->name; ?>"><?= $model->name; ?></a>
            </h2>
            <!--<ul class="list-inline posted-info">
                <?/* if ($model->createdBy) : */?>
                    <li>Added By: <a href="<?/*= $model->createdBy->getPageUrl(); */?>" title="<?/*= $model->createdBy->name; */?>"><?/*= $model->createdBy->name; */?></a></li>
                <?/* endif; */?>
                <?/* if ($model->tree) : */?>
                    <li>Category: <a href="<?/*= $model->tree->url; */?>" title="<?/*= $model->tree->name; */?>"><?/*= $model->tree->name; */?></a></li>
                <?/* endif; */?>
                <li>Time of publication: <?/*= \Yii::$app->formatter->asDate($model->published_at, 'full')*/?></li>
                <?/* if ($testValue = $model->relatedPropertiesModel->getAttribute('test')) : */?>
                    <li><?/*= $model->relatedPropertiesModel->getAttributeLabel('test'); */?>: <?/*= $testValue; */?></li>
                <?/* endif; */?>
            </ul>-->

            <div class="news-v3-in-sm-p" ><?= $model->description_short; ?></div>
            <p><a href="<?= $model->url; ?>" data-pjax="0" class="btn btn-color">Learn More</a></p>

        </div>
    </div>
</div>

<div class="clearfix margin-bottom-20"><hr></div>