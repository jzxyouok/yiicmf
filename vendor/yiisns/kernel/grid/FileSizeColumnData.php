<?php
/**
 * FileSizeColumnData
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 26.11.2016
 * @since 1.0.0
 */
namespace yiisns\kernel\grid;

use yii\grid\DataColumn;

/**
 * Class FileSizeData
 * @package yiisns\kernel\grid
 */
class FileSizeColumnData extends DataColumn
{
    public $filter = false;
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $size = $model->{$this->attribute};
        return \Yii::$app->formatter->asShortSize($size);
    }
}