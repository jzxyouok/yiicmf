<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.09.2016
 */
namespace yiisns\kernel\grid;

use yii\grid\DataColumn;

/**
 * Class ImageColumn2
 * @package yiisns\kernel\grid
 */
class ImageColumn2 extends DataColumn
{
    public $filter          = false;
    public $maxWidth        = '50';
    public $relationName    = 'image';
    public $label           = 'image';
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->relationName && $file = $model->{$this->relationName})
        {
            $originalSrc    = $file->src;
            $src            = \Yii::$app->imaging->getImagingUrl($file->src, new \yiisns\apps\components\imaging\filters\Thumbnail());
        } else
        {
            $src            = \Yii::$app->appSettings->noImageUrl;
            $originalSrc    = $src;
        }

        return "<a href='" . $originalSrc . "' class='sx-fancybox sx-img-link-hover' title='" . \Yii::t('yiisns/kernel', 'Picture') . "' data-pjax='0'>
                    <img src='" . $src . "' style='width: " . $this->maxWidth . "px;' />
                </a>";
    }
}