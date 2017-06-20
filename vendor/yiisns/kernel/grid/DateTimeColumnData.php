<?php
/**
 * DateTimeColumnData
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.10.2016
 * @since 1.0.0
 */
namespace yiisns\kernel\grid;

use yii\grid\DataColumn;

/**
 * Class DateTimeColumnData
 * @package yiisns\kernel\grid
 */
class DateTimeColumnData extends DataColumn
{
    public $filter = false;

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $timestamp = $model->{$this->attribute};
        return \Yii::$app->formatter->asDatetime($timestamp) . "<br /><small>" . \Yii::$app->formatter->asRelativeTime($timestamp) . "</small>";
    }
}