<?php
/**
 * LongTextColumnData
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.10.2016
 * @since 1.0.0
 */
namespace yiisns\kernel\grid;

use yiisns\apps\helpers\StringHelper;
use yii\grid\DataColumn;

/**
 * Class LongTextColumnData
 * @package yiisns\kernel\grid
 */
class LongTextColumnData extends DataColumn
{
    public $maxLength = 200;
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $text = $model->{$this->attribute};
        return "<small>" . StringHelper::substr($text, 0, $this->maxLength) . ( (StringHelper::strlen($text) > $this->maxLength) ? " ..." : "" ) . "</small>";
    }
}