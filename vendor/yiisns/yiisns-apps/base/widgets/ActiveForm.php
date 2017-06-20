<?php
/**
 * ActiveForm
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 11.11.2016
 * @since 1.0.0
 */
namespace yiisns\apps\base\widgets;

use yiisns\kernel\base\AppCore;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveField;

/**
 * Class ActiveForm
 * @package yiisns\apps\base\widgets
 */
class ActiveForm extends \yii\widgets\ActiveForm
{
    /**
     * @param $model
     * @param $attribute
     * @param array $items
     * @param bool $enclosedByLabel
     * @param array $fieldOptions
     * @return ActiveField the created ActiveField object
     */
    public function fieldCheckboxBoolean($model, $attribute, $items = [], $enclosedByLabel = true, $fieldOptions = [])
    {
        return $this->field($model, $attribute, $fieldOptions)->checkbox(['uncheck' => AppCore::BOOL_N, 'value' => AppCore::BOOL_Y], $enclosedByLabel);
    }

    /**
     * @param $model
     * @param $attribute
     * @param array $items
     * @param bool $enclosedByLabel
     * @param array $fieldOptions
     * @return ActiveField the created ActiveField object
     */
    public function fieldRadioListBoolean($model, $attribute, $items = [], $options = [], $fieldOptions = [])
    {
        if (!$items)
        {
            $items = \Yii::$app->appCore->booleanFormat();
        }

        return $this->field($model, $attribute, $fieldOptions)->radioList($items, $options);
    }

    /**
     * @param $model
     * @param $attribute
     * @param array $config
     * @param array $fieldOptions
     * @return ActiveField the created ActiveField object
     */
    public function fieldInputInt($model, $attribute, $config = [], $fieldOptions = [])
    {
        //Html::addCssClass($config, "sx-input-int");
        $config['class'] = ArrayHelper::getValue($config, 'class') . 'form-control sx-input-int';

        $defaultConfig = [
            'type' => 'number'
        ];

        $config = ArrayHelper::merge($defaultConfig, (array) $config);
        return $this->field($model, $attribute, $fieldOptions)->textInput($config);
    }

    /**
     * @param $model
     * @param $attribute
     * @param $items
     * @param array $config
     * @param array $fieldOptions
     * @return ActiveField the created ActiveField object
     */
    public function fieldSelect($model, $attribute, $items, $config = [], $fieldOptions = [])
    {
        $config = ArrayHelper::merge(
            ['size' => 1],
            $config
        );
        return $this->field($model, $attribute, $fieldOptions)->listBox($items, $config);
    }

    /**
     * @param $model
     * @param $attribute
     * @param $items
     * @param array $config
     * @param array $fieldOptions
     * @return ActiveField
     */
    public function fieldSelectMulti($model, $attribute, $items, $config = [], $fieldOptions = [])
    {
        $config = ArrayHelper::merge(
            $config,
            [
                'multiple' => 'multiple',
                'size' => 5
            ]
        );
        return $this->fieldSelect($model, $attribute, $items, $config, $fieldOptions);
    }
}