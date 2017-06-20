<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 18.03.2016
 */
namespace yiisns\apps\widgets;

use yiisns\apps\base\widgets\ActiveFormAjaxSubmit;
use yii\widget\chosen\Chosen;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class ActiveForm
 * 
 * @package yiisns\apps\widgets
 */
class ActiveFormModelPropertyValues extends ActiveFormAjaxSubmit
{
    /**
     *
     * @var Model
     */
    public $modelWithProperties;

    public function __construct($config = [])
    {
        $this->validationUrl = \yiisns\apps\helpers\UrlHelper::construct('apps/model-properties/validate')->toString();
        $this->action = \yiisns\apps\helpers\UrlHelper::construct('apps/model-properties/submit')->toString();
        
        $this->enableAjaxValidation = true;
        
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
        
        echo \yii\helpers\Html::hiddenInput("sx-model-value", $this->modelWithProperties->id);
        echo \yii\helpers\Html::hiddenInput("sx-model", $this->modelWithProperties->className());
    }

    /**
     *
     * @param $model
     * @param $attribute
     * @param $items
     * @param array $config            
     * @param array $fieldOptions            
     * @return \yiisns\apps\base\widgets\ActiveField
     */
    public function fieldSelect($model, $attribute, $items, $config = [], $fieldOptions = [])
    {
        $config = ArrayHelper::merge([
            'allowDeselect' => false
        ], $config, [
            'items' => $items
        ]);
        
        foreach ($config as $key => $value) {
            if (property_exists(Chosen::className(), $key) === false) {
                unset($config[$key]);
            }
        }
        
        return $this->field($model, $attribute, $fieldOptions)->widget(Chosen::className(), $config);
    }
}