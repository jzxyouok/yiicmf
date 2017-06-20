<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.05.2016
 */
namespace yiisns\apps\appsWidgets\text;

use yiisns\apps\base\Widget;
use yiisns\apps\helpers\UrlHelper;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/**
 * Class TextWidget
 * 
 * @package yiisns\apps\appsWidgets\text
 */
class TextWidget extends Widget
{
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), ['name' => 'Text']);
    }

    public $text = '';

    protected $_obContent = '';

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'text' => 'Text'
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [['text', 'string']]);
    }

    public function renderConfigForm(ActiveForm $form)
    {
        echo $form->field($this, 'text')->widget(\yiisns\apps\widgets\formInputs\comboText\ComboTextInputWidget::className());
    }

    static public function begin($config = [])
    {
        parent::begin($config);
        
        ob_start();
        ob_implicit_flush(false);
    }

    public function run()
    {
        if ($this->_isBegin) {
            $this->_obContent = ob_get_clean();
            if (! $this->text) {
                $this->text = $this->_obContent;
            }
        }
        
        return parent::run();
    }

    /**
     *
     * @return array
     */
    public function getCallableData()
    {
        $attributes = parent::getCallableData();
        if (! $attributes['attributes']['text']) {
            $attributes['attributes']['text'] = $this->_obContent;
        }
        return $attributes;
    }

    protected function _run()
    {
        return $this->text;
    }
}