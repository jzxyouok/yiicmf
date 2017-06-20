<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 05.08.2016
 */
namespace yiisns\kernel\grid;

use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\ContentElement;
use yii\grid\DataColumn;
use yii\helpers\Html;

/**
 * Class ContentElementColumn
 * @package yiisns\kernel\grid
 */
class ContentElementColumn extends DataColumn
{
    public $filter      = false;

    public $attribute = 'element_id';

    public $relation = 'element';

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        /**
         * @var $element ContentElement
         */
        if ($this->relation)
        {
            $element = $model->{$this->relation};
            if (!$element)
            {
                return null;
            } else
            {
                return Html::a($element->name  . " [$element->id]", $element->url, [
                            'target'        => '_blank',
                            'data-pjax'     => 0,
                            'title'         => \Yii::t('yiisns/kernel', 'Look at the site (open in a new window)'),
                        ]) . ' ' .
                        Html::a('<span class="glyphicon glyphicon-pencil"></span>', UrlHelper::construct('/admin/admin-content-element/update', [
                            'content_id' => $element->content_id,
                            'pk' => $element->id,
                        ]), [
                            'data-pjax'     => 0,
                            'class'         => 'btn btn-xs btn-default',
                        ]);
            }
        }
        return null;
    }
}