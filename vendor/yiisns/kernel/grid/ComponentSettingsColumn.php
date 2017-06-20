<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 29.05.2016
 */
namespace yiisns\kernel\grid;

use yiisns\kernel\base\Component;
use yiisns\kernel\base\AppCore;
use yiisns\kernel\models\Site;
use yiisns\kernel\models\User;
use yii\grid\DataColumn;

/**
 * Class LongTextColumnData
 * @package yiisns\kernel\grid
 */
class ComponentSettingsColumn extends BooleanColumn
{
    /**
     * @var Component
     */
    public $component = null;

    public $label = 'The Settings';

    /**
     * @inheritdoc
     */
    public function getDataCellValue($model, $key, $index)
    {
        $settings = null;

        if ($this->component === null)
        {
            return $this->_result(AppCore::BOOL_N);
        }

        if ($model instanceof Site)
        {
            $settings = \yiisns\kernel\models\ComponentSettings::fetchByComponentSiteCode($this->component, $model->code);
        }

        if ($model instanceof User)
        {
            $settings = \yiisns\kernel\models\ComponentSettings::fetchByComponentUserId($this->component, $model->id);
        }

        if ($settings)
        {
            return $this->_result(AppCore::BOOL_Y);
        }

        return $this->_result(AppCore::BOOL_N);;
    }

    /**
     * @inheritdoc
     */
    protected function _result($value)
    {
        if ($this->trueValue !== true)
        {
            if ($value == $this->falseValue)
            {
                return $this->falseIcon;
            } else
            {
                return $this->trueIcon;
            }
        } else
        {
            if ($value !== null)
            {
                return $value ? $this->trueIcon : $this->falseIcon;
            }
            return $this->showNullAsFalse ? $this->falseIcon : $value;
        }
    }
}