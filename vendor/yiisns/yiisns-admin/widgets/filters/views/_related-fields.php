
<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 22.05.2016
 */
/* @var $this yii\web\View */
/* @var $widget \yiisns\admin\widgets\filters\AdminFiltersForm */
/* @var $model \yiisns\kernel\models\ContentElement */
/* @var $searchRelpatedPropertiesModel \yiisns\kernel\models\searchs\SearchRelatedPropertiesModel */
$widget = $this->context;
$form = $widget;
?>

<? foreach ($searchRelatedPropertiesModel->properties as $property) : ?>
<?/* foreach ($model->relatedPropertiesModel->toArray($model->relatedPropertiesModel->attributes()) as $name => $value) : */?>
    <?
        //$property = $model->relatedPropertiesModel->getRelatedProperty($name);
        $name = $property->code;
        $filter = '';
    ?>
    <? if ($property->filtrable == 'Y') : ?>
        <? if ($property->property_type == \yiisns\kernel\relatedProperties\PropertyType::CODE_STRING) :?>
            <?= $form->field($searchRelatedPropertiesModel, $name); ?>
        <? endif; ?>
        <? if ($property->property_type == \yiisns\kernel\relatedProperties\PropertyType::CODE_NUMBER) :?>
            <?= $form->field($searchRelatedPropertiesModel, $searchRelatedPropertiesModel->getAttributeNameRangeFrom($name))->label($searchRelatedPropertiesModel->getAttributeLabel($name) . ' (от)'); ?>
            <?= $form->field($searchRelatedPropertiesModel, $searchRelatedPropertiesModel->getAttributeNameRangeTo($name))->label($searchRelatedPropertiesModel->getAttributeLabel($name) . ' (до)'); ?>
        <? endif; ?>
        <? if ($property->property_type == \yiisns\kernel\relatedProperties\PropertyType::CODE_LIST) :?>
            <?
            $items = \yii\helpers\ArrayHelper::merge(['' => ''], \yii\helpers\ArrayHelper::map(
                $property->enums, 'id', 'value'
            ));
            echo $form->field($searchRelatedPropertiesModel, $name)->dropDownList($items);?>
        <? endif; ?>
        <? if ($property->property_type == \yiisns\kernel\relatedProperties\PropertyType::CODE_ELEMENT) :?>
           <?
                $propertyType = $property->handler;
                $options = \yiisns\kernel\models\ContentElement::find()->active()->andWhere([
                    'content_id' => $propertyType->content_id
                ])->all();

                $items = \yii\helpers\ArrayHelper::merge(['' => ''], \yii\helpers\ArrayHelper::map(
                    $options, 'id', 'name'
                ));

                echo $form->field($searchRelatedPropertiesModel, $name)->dropDownList($items);
            ?>
        <? endif; ?>
    <? endif; ?>
<? endforeach; ?>