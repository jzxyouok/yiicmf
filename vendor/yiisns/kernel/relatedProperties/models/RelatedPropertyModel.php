<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 18.05.2016
 */
namespace yiisns\kernel\relatedProperties\models;

use yiisns\kernel\base\AppCore;
use yiisns\apps\helpers\StringHelper;
use yiisns\kernel\models\behaviors\SerializeBehavior;
use yiisns\kernel\models\Core;
use yiisns\kernel\relatedProperties\PropertyType;
use yiisns\kernel\relatedProperties\propertyTypes\PropertyTypeText;

use yii\base\DynamicModel;
use yii\base\Model;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/**
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name
 * @property string $code
 * @property integer $content_id
 * @property string $active
 * @property integer $priority
 * @property string $property_type
 * @property string $list_type
 * @property string $multiple
 * @property integer $multiple_cnt
 * @property string $with_description
 * @property string $searchable
 * @property string $filtrable
 * @property string $is_required
 * @property integer $version
 * @property string $component
 * @property string $component_settings
 * @property string $hint
 * @property string $smart_filtrable
 *
 * @property RelatedElementPropertyModel[]      $elementProperties
 * @property RelatedPropertyEnumModel[]         $enums
 *
 * @property PropertyType           $handler
 * @property mixed                  $defaultValue
 * @property bool                   $isRequired
 */
abstract class RelatedPropertyModel extends Core
{
    /**
     * @var RelatedPropertiesModel
     */
    public $relatedPropertiesModel = null;

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            SerializeBehavior::className() =>
            [
                'class' => SerializeBehavior::className(),
                'fields' => ['component_settings']
            ]
        ]);
    }

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_BEFORE_INSERT,    [$this, '_processBeforeSave']);
        $this->on(self::EVENT_BEFORE_UPDATE,    [$this, '_processBeforeSave']);
        $this->on(self::EVENT_BEFORE_DELETE,    [$this, '_processBeforeDelete']);
    }

    public function _processBeforeSave($e)
    {
        if ($handler = $this->handler)
        {
            $this->property_type    = $handler->code;
            $this->multiple         = $handler->isMultiple ? AppCore::BOOL_Y : AppCore::BOOL_N;
        }
    }

    public function _processBeforeDelete($e)
    {
        //TODO:: find all the elements associated with this feature and to remove them
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => \Yii::t('yiisns/kernel', 'ID'),
            'created_by' => \Yii::t('yiisns/kernel', 'Created By'),
            'updated_by' => \Yii::t('yiisns/kernel', 'Updated By'),
            'created_at' => \Yii::t('yiisns/kernel', 'Created At'),
            'updated_at' => \Yii::t('yiisns/kernel', 'Updated At'),
            'name' => \Yii::t('yiisns/kernel', 'Name'),
            'code' => \Yii::t('yiisns/kernel', 'Code'),
            'active' => \Yii::t('yiisns/kernel', 'Active'),
            'priority' => \Yii::t('yiisns/kernel', 'Priority'),
            'property_type' => \Yii::t('yiisns/kernel', 'Property Type'),
            'list_type' => \Yii::t('yiisns/kernel', 'List Type'),
            'multiple' => \Yii::t('yiisns/kernel', 'Multiple'),
            'multiple_cnt' => \Yii::t('yiisns/kernel', 'Multiple Cnt'),
            'with_description' => \Yii::t('yiisns/kernel', 'With Description'),
            'searchable' => \Yii::t('yiisns/kernel', 'Searchable'),
            'filtrable' => \Yii::t('yiisns/kernel', 'Filtrable'),
            'is_required' => \Yii::t('yiisns/kernel', 'Is Required'),
            'version' => \Yii::t('yiisns/kernel', 'Version'),
            'component' => \Yii::t('yiisns/kernel', 'Component'),
            'component_settings' => \Yii::t('yiisns/kernel', 'Component Settings'),
            'hint' => \Yii::t('yiisns/kernel', 'Hint'),
            'smart_filtrable' => \Yii::t('yiisns/kernel', 'Smart Filtrable'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'priority', 'multiple_cnt', 'version'], 'integer'],
            [['name', 'component'], 'required'],
            [['component_settings'], 'safe'],
            [['name', 'component', 'hint'], 'string', 'max' => 255],
            //[['code'], 'string', 'max' => 64],
            [['code'], function($attribute)
            {
                if(!preg_match('/^[a-zA-Z]{1}[a-zA-Z0-9]{1,255}$/', $this->$attribute))
                //if(!preg_match('/(^|.*\])([\w\.]+)(\[.*|$)/', $this->$attribute))
                {
                    $this->addError($attribute, \Yii::t('yiisns/kernel','Use only letters of the alphabet in lower or upper case and numbers, the first character of the letter (Example {code})',['code' => 'code1']));
                }
            }],

            [['active', 'property_type', 'list_type', 'multiple', 'with_description', 'searchable', 'filtrable', 'is_required', 'smart_filtrable'], 'string', 'max' => 1],
            ['code', 'default', 'value' => function($model, $attribute)
            {
                return "property" . StringHelper::ucfirst(md5(rand(1, 10) . time()));
            }],
            ['priority', 'default', 'value' => 500],
            [['active', 'searchable'], 'default', 'value' => AppCore::BOOL_Y],
            [['is_required', 'smart_filtrable', 'filtrable', 'with_description'], 'default', 'value' => AppCore::BOOL_N],
        ]);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    abstract public function getElementProperties();
    /*{
        return $this->hasMany(ContentElementProperty::className(), ['property_id' => 'id']);
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    abstract public function getEnums();
    /*{
        return $this->hasMany(ContentPropertyEnum::className(), ['property_id' => 'id']);
    }*/

    /**
     * @param ActiveForm $activeForm
     * @param \yiisns\kernel\relatedProperties\models\RelatedElementModel $model
     * @return mixed
     */
    public function renderActiveForm(ActiveForm $activeForm, $model = null)
    {
        $handler = $this->handler;

        if ($handler)
        {
            $handler->activeForm = $activeForm;
        } else
        {
            return false;
        }

        if ($model && !$this->relatedPropertiesModel)
        {
            $this->relatedPropertiesModel = $model->relatedPropertiesModel;
        }

        return $handler->renderForActiveForm();
    }

    protected $_handler = null;

    /**
     * @return PropertyType
     * @throws \yii\base\InvalidParamException
     */
    public function getHandler()
    {
        if ($this->_handler !== null)
        {
            return $this->_handler;
        }

        if ($this->component)
        {
            try
            {
                /**
                 * @var $component PropertyType
                 */
                $foundComponent = \Yii::$app->appCore->getRelatedHandler($this->component);
                $component = clone $foundComponent;
                //$component = \Yii::$app->appCore->createRelatedHandler($this->component);
                $component->property = $this;
                $component->load($this->component_settings, "");

                $this->_handler = $component;
                return $this->_handler;
            } catch (\Exception $e)
            {
                //\Yii::warning("Related property handler not found '{$this->component}' or load with errors: " . $e->getMessage(), self::className());
                $component = new PropertyTypeText();
                $component->property = $this;

                $this->_handler = $component;
                return $this->_handler;
            }

        }

        return null;
    }

    /**
     * @return bool
     */
    public function getIsRequired()
    {
        return (bool) $this->is_required == AppCore::BOOL_Y;
    }

    /**
     * @return $this
     */
    public function addRules()
    {
        if ($this->is_required == AppCore::BOOL_Y)
        {
            $this->relatedPropertiesModel->addRule($this->code, 'required');
        }

        $this->handler->addRules();

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->handler->defaultValue;
    }
}