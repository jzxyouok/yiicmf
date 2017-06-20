<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 26.09.2016
 */
$imageFile = $model;
?>
<a href="<?= $imageFile->src; ?>" class="sx-fancybox" data-pjax="0">
    <img src="<?= \Yii::$app->imaging->getImagingUrl($imageFile->src, new \yiisns\apps\components\imaging\filters\Thumbnail()); ?>" />
</a>
<div class="sx-controlls">
    <?= \yii\helpers\Html::a('<i class="glyphicon glyphicon-circle-arrow-left"></i> '.\Yii::t('yiisns/kernel','Choose file'), $model->src, [
            'class' => 'btn btn-primary btn-xs',
            'onclick' => 'sx.SelectFile.submit("' . $model->src . '"); return false;',
            'data-pjax' => 0
        ]);?>
</div>