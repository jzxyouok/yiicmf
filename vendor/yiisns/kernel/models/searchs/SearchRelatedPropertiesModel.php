<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.05.2016
 */
namespace yiisns\kernel\models\searchs;

use yiisns\kernel\models\Content;
use yiisns\kernel\models\ContentElement;
use yiisns\kernel\models\ContentElementProperty;
use yiisns\kernel\models\ContentProperty;
use yiisns\kernel\relatedProperties\models\RelatedPropertyModel;

use yii\base\DynamicModel;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveQueryInterface;
use yii\helpers\ArrayHelper;

/**
 * Class SearchRelatedPropertiesModel
 * @package yiisns\kernel\models\searchs
 */
class SearchRelatedPropertiesModel extends DynamicModel
{
    /**
     * @var Content
     */
    public $content = null;
    /**
     * @var ContentProperty[]
     */
    public $properties = [];

    /**
     * @var string
     */
    public $propertyElementClassName = '\yiisns\kernel\models\ContentElementProperty';

    /**
     * @param Content $content
     */
    public function initContent(Content $appcontent)
    {
        $this->content = $appcontent;

        /**
         * @var $prop ContentProperty
         */
        if ($props = $this->content->contentProperties)
        {
            $this->initProperties($props);
        }
    }


    public function initProperties($props = [])
    {
        foreach ($props as $prop)
        {
            if ($prop->property_type == \yiisns\kernel\relatedProperties\PropertyType::CODE_NUMBER)
            {
                $this->defineAttribute($this->getAttributeNameRangeFrom($prop->code), '');
                $this->defineAttribute($this->getAttributeNameRangeTo($prop->code), '');
                $this->addRule([$this->getAttributeNameRangeFrom($prop->code), $this->getAttributeNameRangeTo($prop->code)], 'safe');
            }
            $this->defineAttribute($prop->code, '');
            $this->addRule([$prop->code], 'safe');
            $this->properties[$prop->code] = $prop;
        }
    }

    /**
     * @param $code
     * @return ContentProperty
     */
    public function getProperty($code)
    {
        return ArrayHelper::getValue($this->properties, $code);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        $result = [];

        foreach ($this->attributes() as $code)
        {
            if ($property = $this->getProperty($code))
            {
                $result[$code] = $property->name;
            } else
            {
                $result[$code] = $code;
            }

        }

        return $result;
    }

    public $prefixRange = 'Sxrange';

    /**
     * @param $propertyCode
     * @return string
     */
    public function getAttributeNameRangeFrom($propertyCode)
    {
        return $propertyCode . $this->prefixRange . 'From';
    }

    /**
     * @param $propertyCode
     * @return string
     */
    public function getAttributeNameRangeTo($propertyCode)
    {
        return $propertyCode . $this->prefixRange . 'To';
    }


    /**
     * @param $propertyCode
     * @return bool
     */
    public function isAttributeRange($propertyCode)
    {
        if (strpos($propertyCode, $this->prefixRange))
        {
            return true;
        }

        return false;
    }


    /**
     * @param ActiveDataProvider $activeDataProvider
     */
    public function search(ActiveDataProvider $activeDataProvider, $tableName = 'content_element')
    {

        $classSearch = $this->propertyElementClassName;

        /**
         * @var $activeQuery ActiveQuery
         */
        $activeQuery = $activeDataProvider->query;
        $elementIdsGlobal = [];
        $applyFilters = false;

        foreach ($this->toArray() as $propertyCode => $value)
        {
            //TODO: add to validator related properties
            if ($propertyCode == 'properties')
            {
                continue;
            }

            if ($property = $this->getProperty($propertyCode))
            {
                if ($property->property_type == \yiisns\kernel\relatedProperties\PropertyType::CODE_NUMBER)
                {
                    $elementIds = [];

                    $query = $classSearch::find()->select(['element_id'])->where([
                        'property_id'   => $property->id
                    ])->indexBy('element_id');

                    if ($fromValue = $this->{$this->getAttributeNameRangeFrom($propertyCode)})
                    {
                        $applyFilters = true;

                        $query->andWhere(['>=', 'value_num', (float) $fromValue]);
                    }

                    if ($toValue = $this->{$this->getAttributeNameRangeTo($propertyCode)})
                    {

                        $applyFilters = true;

                        $query->andWhere(['<=', 'value_num', (float) $toValue]);
                    }

                    if (!$fromValue && !$toValue)
                    {
                        continue;
                    }

                    $elementIds = $query->all();

                } else
                {
                    if (!$value)
                    {
                        continue;
                    }

                    $applyFilters = true;

                    if ($property->property_type == \yiisns\kernel\relatedProperties\PropertyType::CODE_STRING)
                    {
                        $elementIds = $classSearch::find()->select(['element_id'])
                            ->where([
                                'property_id' => $property->id
                            ])
                            ->andWhere([
                                'like', 'value', $value
                            ])
                        ->indexBy('element_id')
                        ->all();

                    } else
                    {
                        $elementIds = $classSearch::find()->select(['element_id'])->where([
                            'value'         => $value,
                            'property_id'   => $property->id
                        ])
                        ->indexBy('element_id')
                        ->all();
                    }
                }

                $elementIds = array_keys($elementIds);

                \Yii::beginProfile('array_intersect');

                if (!$elementIds)
                {
                    $elementIdsGlobal = [];
                }

                if ($elementIdsGlobal)
                {
                    $elementIdsGlobal = array_intersect($elementIds, $elementIdsGlobal);
                } else
                {
                    $elementIdsGlobal = $elementIds;
                }

                \Yii::endProfile('array_intersect');

            }
        }

        if ($applyFilters)
        {
            $activeQuery->andWhere([$tableName . '.id' => $elementIdsGlobal]);
        }
    }
}