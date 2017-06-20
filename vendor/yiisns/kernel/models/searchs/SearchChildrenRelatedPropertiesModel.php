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
class SearchChildrenRelatedPropertiesModel extends SearchRelatedPropertiesModel
{
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
                        "property_id"   => $property->id
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

                    $elementIds = $classSearch::find()->select(['element_id'])->where([
                        'value'         => $value,
                        'property_id'   => $property->id
                    ])->indexBy('element_id')->all();
                }

                $elementIds = array_keys($elementIds);

                if ($elementIds)
                {
                    $realElements = ContentElement::find()->where(['id' => $elementIds])->select(['id', 'parent_content_element_id'])->indexBy('parent_content_element_id')->groupBy(['parent_content_element_id'])->asArray()->all();
                    $elementIds = array_keys($realElements);
                }

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
            }
        }


        if ($applyFilters)
        {
            //$activeQuery->andWhere(['content_element.id' => $elementIdsGlobal]);
            $activeQuery->andWhere([$tableName . '.id' => $elementIdsGlobal]);
        }
    }
}