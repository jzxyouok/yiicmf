<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.04.2016
 */
namespace yiisns\kernel\relatedProperties\userPropertyTypes;

//use yiisns\kernel\models\ContentElement;
use yiisns\kernel\relatedProperties\models\RelatedPropertiesModel;
use yiisns\kernel\relatedProperties\PropertyType;

use yii\helpers\ArrayHelper;

/**
 * Class UserPropertyTypeSelectFile
 * @package yiisns\kernel\relatedProperties\userPropertyTypes
 */
class UserPropertyTypeSelectFile extends PropertyType
{
    public $code = self::CODE_STRING;
    
    public $name = '';

    public function init()
    {
        parent::init();

        if(!$this->name)
        {
            $this->name = \Yii::t('yiisns/kernel', 'Standard file selection');
        }
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),
        [
            'type'  => \Yii::t('yiisns/kernel', 'Type'),
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), []);
    }

    /**
     * @return \yii\widgets\ActiveField
     */
    public function renderForActiveForm()
    {
        $field = parent::renderForActiveForm();

        $field->widget(\yiisns\admin\widgets\formInputs\OneImage::className(),
        [
            'filesModel' => $this->property->relatedPropertiesModel->relatedElementModel
        ]);

        return $field;
    }


    /**
     * @var a file format settings, the default is in the same directory where the component.
     *
     * @return string
     */
    public function getConfigFormFile()
    {
        $class = new \ReflectionClass($this->className());
        return dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'views/_formUserPropertyTypeDate.php';
    }

    /**
     * @return $this
     */
    public function addRules()
    {
        $this->property->relatedPropertiesModel->addRule($this->property->code, 'string');

        return $this;
    }
}