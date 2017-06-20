<?php
/**
 * HasRelatedPropertiesBehavior
 * 
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 18.05.2016
 */
namespace yiisns\kernel\models\behaviors;

use yiisns\kernel\relatedProperties\models\RelatedPropertiesModel;
use yiisns\kernel\relatedProperties\models\RelatedPropertyModel;
use yii\base\Behavior;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\ErrorHandler;

/**
 * Class HasRelatedPropertiesBehavior
 *
 * @package yiisns\kernel\models\behaviors
 */
class HasRelatedPropertiesBehavior extends Behavior
{
    /**
     *
     * @var string strong model (e.g. ContentElementProperty::className())
     */
    public $relatedElementPropertyClassName;

    /**
     *
     * @var string model properties (e.g. ContentProperty::className() )
     */
    public $relatedPropertyClassName;

    /**
     * The values of properties.
     *
     * @return ActiveQuery only the values of properties.
     */
    public function getRelatedElementProperties()
    {
        return $this->owner->hasMany($this->relatedElementPropertyClassName, [
            'element_id' => 'id'
        ]);
    }

    /**
     *
     * @return array
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_DELETE => '_deleteRelatedProperties'
        ];
    }

    /**
     * before removal of the model you want to delete related properties
     */
    public function _deleteRelatedProperties()
    {
        $rpm = $this->owner->relatedPropertiesModel;
        $rpm->delete();
    }

    /**
     *
     * all the properties for the model.
     * this may depend on the group elements, or the like, for example.
     *
     * @return ActiveQuery
     */
    public function getRelatedProperties()
    {
        $className = $this->relatedPropertyClassName;
        $find = $className::find()->orderBy([
            'priority' => SORT_ASC
        ]);
        ;
        $find->multiple = true;
        
        return $find;
    }

    /**
     *
     * @return RelatedPropertiesModel
     */
    public function createRelatedPropertiesModel()
    {
        return new RelatedPropertiesModel([], [
            'relatedElementModel' => $this->owner
        ]);
    }

    /**
     *
     * @var RelatedPropertiesModel
     */
    public $_relatedPropertiesModel = null;

    /**
     *
     * @return RelatedPropertiesModel
     */
    public function getRelatedPropertiesModel()
    {
        if ($this->_relatedPropertiesModel === null) {
            $this->_relatedPropertiesModel = $this->createRelatedPropertiesModel();
        }
        
        return $this->_relatedPropertiesModel;
    }
}