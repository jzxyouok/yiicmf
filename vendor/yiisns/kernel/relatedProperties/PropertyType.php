<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 18.05.2016
 */
namespace yiisns\kernel\relatedProperties;

use yiisns\kernel\base\AppCore;
use yiisns\kernel\base\Component;
use yiisns\kernel\base\ConfigFormInterface;
use yiisns\kernel\relatedProperties\models\RelatedElementModel;
use yiisns\kernel\relatedProperties\models\RelatedPropertiesModel;
use yiisns\kernel\relatedProperties\models\RelatedPropertyModel;

use yii\base\DynamicModel;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/**
 *
 * @property bool $isMultiple
 * @property mixed $defaultValue
 * @property string $stringValue Class PropertyType
 * @package yiisns\kernel\relatedProperties
 */
abstract class PropertyType extends Model implements ConfigFormInterface
{
    /**
     *
     * @var string
     */
    public $id;

    /**
     * The name of the handler
     *
     * @var string
     */
    public $name;

    /**
     * Object properties is bound to the current handler
     *
     * @var RelatedPropertyModel
     */
    public $property;

    /**
     * Object form which will be completed item
     *
     * @var ActiveForm
     */
    public $activeForm;

    /**
     * The configuration form for the current state of the component settings
     *
     * @param ActiveForm $form            
     */
    public function renderConfigForm(ActiveForm $form)
    {}

    /**
     * From the result of this function will depend on how the property values are stored in the database
     *
     * @return bool
     */
    public function getIsMultiple()
    {
        return false;
    }

    /**
     * Drawing form element
     *
     * @return \yii\widgets\ActiveField
     */
    public function renderForActiveForm()
    {
        $field = $this->activeForm->field($this->property->relatedPropertiesModel, $this->property->code);
        
        if (! $field) {
            return '';
        }
        
        return $field;
    }

    /**
     * Adding validation rules to the object RelatedPropertiesModel
     *     
     * @return $this
     */
    public function addRules()
    {
        $this->property->relatedPropertiesModel->addRule($this->property->code, 'safe');
        return $this;
    }

    /**
     * The default value for this property
     *     
     * @return null
     */
    public function getDefaultValue()
    {
        return null;
    }

    /**
     *
     * @return string
     */
    public function getStringValue()
    {
        $value = $this->property->relatedPropertiesModel->getAttribute($this->property->code);
        
        if (is_array($value)) {
            return Json::encode($value);
        } else {
            return (string) $value;
        }
    }

    /**
     * Conversion property value received from the database
     *
     * @param mixed $valueFromDb            
     *
     * @return mixed
     */
    public function initValue($valueFromDb)
    {
        /*
         * $valueFromDb = unserialize($valueFromDb);
         */
        return $valueFromDb;
    }

    /**
     * Converting the property value before saving to database
     *
     * @param mixed $value            
     *
     * @return mixed
     */
    public function beforeSaveValue($value)
    {
        /*
         * $value = serialize($value);
         */
        return $value;
    }

    /**
     * Fires before the removal of the property value of the element base
     *
     * @return $this
     */
    public function beforeDeleteValue()
    {
        /*
         * $value = $this->property->relatedPropertiesModel->getAttribute($this->property->code);
         * $valueToDb = serialize($value);
         * $this->property->relatedPropertiesModel->setAttribute($this->property->code, $valueToDb);
         */
        return $this;
    }
    
    const CODE_STRING = 'S';

    const CODE_NUMBER = 'N';

    const CODE_LIST = 'L';

    const CODE_FILE = 'F';

    const CODE_TREE = 'T';

    const CODE_ELEMENT = 'E';

    /**
     * @var type code properties
     */
    public $code;

    /**
     * @return string
     */
    public function getMultiple()
    {
        return $this->isMultiple ? AppCore::BOOL_Y : AppCore::BOOL_N;
    }
}