<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 18.05.2016
 */

namespace yiisns\kernel\relatedProperties\models;

use yiisns\kernel\models\behaviors\HasRelatedPropertiesBehavior;
use yiisns\kernel\models\behaviors\traits\HasRelatedPropertiesTrait;
use yiisns\kernel\models\Core;

use yii\web\ErrorHandler;

/**
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published_at
 * @property integer $published_to
 * @property integer $priority
 * @property string $active
 * @property string $name
 * @property string $code
 * @property string $description_short
 * @property string $description_full
 * @property string $files
 * @property integer $content_id
 * @property integer $tree_id
 * @property integer $show_counter
 * @property integer $show_counter_start
 */
abstract class RelatedElementModel extends Core
{
    use HasRelatedPropertiesTrait;

    /**
     * @return array
     */
    /*public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            HasRelatedPropertiesBehavior::className() =>
            [
                'class'                             => HasRelatedPropertiesBehavior::className(),
                'valuesRelatedPropertiesClassName'  => ContentElementProperty::className(),
                'relatedPropertiesClassName'        => ContentProperty::className(),
            ],
        ]);
    }*/
}