<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 02.06.2016
 */
namespace yiisns\kernel\grid;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\jui\Sortable;
use yii\widgets\Pjax;

/**
 * Class GridViewSortableTrait
 * @package yiisns\admin\traits
 */
trait GridViewPjaxTrait
{
    public $pjaxClassName    = 'yii\widgets\Pjax';
    /**
     * @var bool
     */
    public $enabledPjax     = true;
    /**
     * @var array
     */
    public $pjaxOptions     = [];

    public $pjax;

    protected $_pjaxCreated = false;

    public function pjaxBegin()
    {
        if ($this->enabledPjax)
        {
            if (!$this->pjax)
            {
                $this->_pjaxCreated = true;

                $pjaxClassName = $this->pjaxClassName;

                $this->pjax = $pjaxClassName::begin(ArrayHelper::merge([
                    'id' => 'sx-pjax-grid-' . $this->id,
                ], $this->pjaxOptions));
            }
        }
    }

    public function pjaxEnd()
    {
        if ($this->enabledPjax && $this->_pjaxCreated)
        {
            $pjaxClassName = $this->pjax->className();
            $pjaxClassName::end();
        }
    }
}