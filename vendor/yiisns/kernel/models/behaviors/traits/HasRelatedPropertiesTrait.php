<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 18.05.2016
 */
namespace yiisns\kernel\models\behaviors\traits;

use yiisns\kernel\relatedProperties\models\RelatedElementPropertyModel;
use yiisns\kernel\relatedProperties\models\RelatedPropertiesModel;
use yiisns\kernel\relatedProperties\models\RelatedPropertyModel;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @method ActiveQuery getRelatedElementProperties()
 * @method ActiveQuery getRelatedProperties()
 * @method RelatedPropertiesModel getRelatedPropertiesModel()
 *        
 * @property RelatedElementPropertyModel[] relatedElementProperties
 * @property RelatedPropertyModel[] relatedProperties
 * @property RelatedPropertiesModel relatedPropertiesModel
 */
trait HasRelatedPropertiesTrait
{
}