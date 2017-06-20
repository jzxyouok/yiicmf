<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 13.10.2015
 */
/* @var $this yii\web\View */
/* @var $widget \yiisns\kernel\shop\cmsWidgets\filters\ShopProductFiltersWidget */
?>

<?
$this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.FiltersForm = sx.classes.Component.extend({

        _init: function()
        {},

        _onDomReady: function()
        {
            var self = this;
            this.JqueryForm = $("#sx-filters-form");

            $("input, checkbox, select", this.JqueryForm).on("change", function()
            {
                self.JqueryForm.submit();
            });
        },

        _onWindowReady: function()
        {}
    });

    new sx.classes.FiltersForm();
})(sx, sx.$, sx._);
JS
)
?>
<? $form = \yiisns\apps\base\widgets\ActiveForm::begin([
    'options' =>
    [
        'id' => 'sx-filters-form',
        'data-pjax' => '1'
    ],
    'method' => 'get',
    'action' => "/" . \Yii::$app->request->getPathInfo(),
]); ?>
    <? if ($widget->searchModel) : ?>
        <? if (in_array('image', $widget->searchModelAttributes)) : ?>
            <?= $form->fieldSelect($widget->searchModel, 'image', [
                '' => \yiisns\apps\shop\Module::t('yiisns/kernel', 'Does not matter'),
                'Y' => \yiisns\apps\shop\Module::t('yiisns/kernel', 'With photo'),
                'N' => \yiisns\apps\shop\Module::t('yiisns/kernel', 'Without photo'),
            ]); ?>
        <? endif; ?>
    <? endif ; ?>
    <? if ($properties = $widget->searchRelatedPropertiesModel->properties) : ?>
        <? foreach ($properties as $property) : ?>
            <? if (in_array($property->code, $widget->realatedProperties)) : ?>
                <? if (in_array($property->property_type, [\yiisns\kernel\relatedProperties\PropertyType::CODE_ELEMENT, \yiisns\kernel\relatedProperties\PropertyType::CODE_LIST]) ) : ?>
                    <?= $form->field($widget->searchRelatedPropertiesModel, $property->code)->checkboxList(
                        $widget->getRelatedPropertyOptions($property)
                        , ['class' => 'sx-filters-checkbox-options']); ?>
                <? elseif ($property->property_type == \yiisns\kernel\relatedProperties\PropertyType::CODE_NUMBER) : ?>
                    <div class="form-group">
                        <label class="control-label"><?= $property->name; ?></label>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($widget->searchRelatedPropertiesModel, $widget->searchRelatedPropertiesModel->getAttributeNameRangeFrom($property->code) )->textInput([
                                    'placeholder' => 'от'
                                ])->label(false); ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($widget->searchRelatedPropertiesModel, $widget->searchRelatedPropertiesModel->getAttributeNameRangeTo($property->code) )->textInput([
                                    'placeholder' => 'до'
                                ])->label(false); ?>
                            </div>
                        </div>
                    </div>
                <? else : ?>
                    <? $propertiesValues = \yiisns\kernel\models\ContentElementProperty::find()->select(['value'])->where([
                        'property_id' => $property->id,
                        'element_id'  => $widget->elementIds
                    ])->all(); ?>

                    <? if ($propertiesValues) : ?>
                        <div class="row">
                            <div class="col-md-12">

                            <?= $form->field($widget->searchRelatedPropertiesModel, $property->code)->dropDownList(
                                \yii\helpers\ArrayHelper::merge(['' => ''], \yii\helpers\ArrayHelper::map(
                                    $propertiesValues, 'value', 'value'
                                )))
                            ; ?>

                            </div>
                        </div>
                    <? endif; ?>
                <? endif; ?>
            <? endif; ?>
        <? endforeach; ?>
    <? endif; ?>
    <button class="btn btn-primary"><?= \Yii::t('yiisns/kernel', 'Apply');?></button>
<? \yiisns\apps\base\widgets\ActiveForm::end(); ?>