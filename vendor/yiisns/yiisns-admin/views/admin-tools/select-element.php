<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.04.2015
 */
/* @var $this yii\web\View */
/* @var $model \yii\db\ActiveRecord */

use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;
?>

<?
$this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.SelectCmsElement = sx.classes.Component.extend({

        _onDomReady: function()
        {
            this.GetParams              = sx.helpers.Request.getParams();

            $('table tr').on('dblclick', function()
            {
                $(".sx-row-action", $(this)).click();
            });
        },

        submit: function(data)
        {
            if (this.GetParams['callbackEvent'])
            {
                if (window.opener)
                {
                    if (window.opener.sx)
                    {
                        window.opener.sx.EventManager.trigger(this.GetParams['callbackEvent'], data);
                        return this;
                    }
                } else if (window.parent)
                {
                    if (window.parent.sx)
                    {
                        window.parent.sx.EventManager.trigger(this.GetParams['callbackEvent'], data);
                        return this;
                    }
                }
            }

            return this;
        }
    });

    sx.SelectCmsElement = new sx.classes.SelectCmsElement();

})(sx, sx.$, sx._);
JS
);
?>

<? $content_id = \Yii::$app->request->get('content_id'); ?>

<? if (!\Yii::$app->request->get('content_id')) : ?>
    <? if ($content = \yiisns\kernel\models\Content::find()->orderBy("priority ASC")->one()) : ?>
        <? $content_id = $content->id; ?>
    <? endif; ?>
<? endif; ?>

<? if ($content_id) : ?>

    <?

    $dataProvider = new \yii\data\ActiveDataProvider([
        'query' => \yiisns\kernel\models\ContentElement::find()
    ]);


    $search         = new \yiisns\kernel\models\Search(\yiisns\kernel\models\ContentElement::className());
    $dataProvider   = $search->search(\Yii::$app->request->queryParams);
    $searchModel    = $search->loadedModel;


    $dataProvider->setSort(['defaultOrder' => ['published_at' => SORT_DESC]]);
    if ($content_id = \Yii::$app->request->get('content_id'))
    {
        $dataProvider->query->andWhere(['content_id' => $content_id]);
    }


    $autoColumns = [];
    $model = \yiisns\kernel\models\ContentElement::find()->where(['content_id' => $content_id])->one();



    if (is_array($model) || is_object($model))
    {
        foreach ($model as $name => $value) {
            $autoColumns[] = [
                'attribute' => $name,
                'visible' => false,
                'format' => 'raw',
                'class' => \yii\grid\DataColumn::className(),
                'value' => function($model, $key, $index) use ($name)
                {
                    if (is_array($model->{$name}))
                    {
                        return implode(",", $model->{$name});
                    } else
                    {
                        return $model->{$name};
                    }
                },
            ];
        }

        $searchRelatedPropertiesModel = new \yiisns\kernel\models\searchs\SearchRelatedPropertiesModel();
        $searchRelatedPropertiesModel->initContent($model->content);
        $searchRelatedPropertiesModel->load(\Yii::$app->request->get());
        $searchRelatedPropertiesModel->search($dataProvider);

         /**
         * @var $model \yiisns\kernel\models\ContentElement
         */
        if ($model->relatedPropertiesModel)
        {
            foreach ($model->relatedPropertiesModel->toArray($model->relatedPropertiesModel->attributes()) as $name => $value) {

                $property = $model->relatedPropertiesModel->getRelatedProperty($name);
                $filter = '';

                if ($property->property_type == \yiisns\kernel\relatedProperties\PropertyType::CODE_ELEMENT)
                {
                    $propertyType = $property->handler;
                        $options = \yiisns\kernel\models\ContentElement::find()->active()->andWhere([
                            'content_id' => $propertyType->content_id
                        ])->all();

                        $items = \yii\helpers\ArrayHelper::merge(['' => ''], \yii\helpers\ArrayHelper::map(
                            $options, 'id', 'name'
                        ));

                    $filter = \yii\helpers\Html::activeDropDownList($searchRelatedPropertiesModel, $name, $items, ['class' => 'form-control']);

                } else if ($property->property_type == \yiisns\kernel\relatedProperties\PropertyType::CODE_LIST)
                {
                    $items = \yii\helpers\ArrayHelper::merge(['' => ''], \yii\helpers\ArrayHelper::map(
                        $property->enums, 'id', 'value'
                    ));

                    $filter = \yii\helpers\Html::activeDropDownList($searchRelatedPropertiesModel, $name, $items, ['class' => 'form-control']);

                } else if ($property->property_type == \yiisns\kernel\relatedProperties\PropertyType::CODE_STRING)
                {
                    $filter = \yii\helpers\Html::activeTextInput($searchRelatedPropertiesModel, $name, [
                        'class' => 'form-control'
                    ]);
                }
                else if ($property->property_type == \yiisns\kernel\relatedProperties\PropertyType::CODE_NUMBER)
                {
                    $filter = "<div class='row'><div class='col-md-6'>" . \yii\helpers\Html::activeTextInput($searchRelatedPropertiesModel, $searchRelatedPropertiesModel->getAttributeNameRangeFrom($name), [
                                    'class' => 'form-control',
                                    'placeholder' => 'от'
                                ]) . "</div><div class='col-md-6'>" .
                                    \yii\helpers\Html::activeTextInput($searchRelatedPropertiesModel, $searchRelatedPropertiesModel->getAttributeNameRangeTo($name), [
                                    'class' => 'form-control',
                                    'placeholder' => 'до'
                                ]) . "</div></div>"
                            ;
                }



                $autoColumns[] = [
                    'attribute' => $name,
                    'label' => \yii\helpers\ArrayHelper::getValue($model->relatedPropertiesModel->attributeLabels(), $name),
                    'visible' => false,
                    'format' => 'raw',
                    'filter' => $filter,
                    'class' => \yii\grid\DataColumn::className(),
                    'value' => function($model, $key, $index) use ($name)
                    {
                        /**
                         * @var $model \yiisns\kernel\models\ContentElement
                         */
                        $value = $model->relatedPropertiesModel->getSmartAttribute($name);
                        if (is_array($value))
                        {
                            return implode(",", $value);
                        } else
                        {
                            return $value;
                        }
                    },
                ];
            }
        }


    }
    $userColumns = include_once __DIR__ . "/_columns-select-element.php";

    $columns = \yii\helpers\ArrayHelper::merge($userColumns, $autoColumns);

    ?>

    <?= \yiisns\admin\widgets\GridViewStandart::widget([
        'dataProvider'      => $dataProvider,
        'filterModel'       => $searchModel,
        'enabledCheckbox'   => false,
        'autoColumns'       => false,
        'settingsData'      =>
        [
            'namespace' => \Yii::$app->controller->action->getUniqueId() . $content_id
        ],
        'columns' => $columns
    ]); ?>


<? endif; ?>
