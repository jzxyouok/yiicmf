<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 24.07.2016
 */
namespace yiisns\admin\widgets;

use yiisns\admin\actions\modelEditor\AdminMultiModelEditAction;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\grid\CheckboxColumn;
use yiisns\admin\widgets\gridViewStandart\GridViewStandartAsset;
use yiisns\kernel\relatedProperties\models\RelatedPropertiesModel;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * @property string $gridJsObject
 *
 * Class GridViewStandart
 * @package yiisns\admin\widgets
 */
class GridViewStandart extends GridViewHasSettings
{
    /**
     * @var AdminModelEditorController
     */
    public $adminController = null;
    public $isOpenNewWindow = false;
    public $enabledCheckbox = true;

    public function init()
    {
        $defaultColumns = [];

        if ($this->enabledCheckbox)
        {
            $defaultColumns[] = ['class' => 'yiisns\admin\grid\CheckboxColumn'];
        }

        if ($this->adminController)
        {
            $defaultColumns[] = [
                'class'                 => \yiisns\admin\grid\ActionColumn::className(),
                'controller'            => $this->adminController,
                'isOpenNewWindow'       => $this->isOpenNewWindow
            ];
        }

        $defaultColumns[] = [
            'class' => 'yii\grid\SerialColumn',
            'visible' => false
        ];

        $this->columns = ArrayHelper::merge($defaultColumns, $this->columns);

        GridViewStandartAsset::register($this->view);

        parent::init();
    }

    /**
     * @return string
     */
    public function getGridJsObject()
    {
        return "sx.Grid" . $this->id;
    }

    /**
     * @return string
     */
    public function renderBeforeTable()
    {
        $multiActions = [];
        if ($this->adminController)
        {
            $multiActions = $this->adminController->getMultiActions();
        }

        if (!$multiActions)
        {
            return parent::renderBeforeTable();
        }

        $this->_initMultiActions();
        $this->beforeTableLeft = $this->_buttonsMulti;

        return parent::renderBeforeTable();
    }

    /**
     * @return string
     */
    public function renderAfterTable()
    {
        $multiActions = [];
        if ($this->adminController)
        {
            $multiActions = $this->adminController->getMultiActions();
        }

        if (!$multiActions)
        {
            return parent::renderAfterTable();
        }

        $this->_initMultiActions();
        $this->afterTableLeft = $this->_buttonsMulti . $this->_additionalsMulti;

        return parent::renderAfterTable();
    }


    protected function _initMultiActions()
    {
        if ($this->_initMultiOptions === true)
        {
            return $this;
        }

        $this->_initMultiOptions = true;

        $multiActions = [];
        if ($this->adminController)
        {
            $multiActions = $this->adminController->getMultiActions();
        }

        if (!$multiActions)
        {
            return $this;
        }

        $options = [
            'id'                    => $this->id,
            'enabledPjax'           => $this->enabledPjax,
            'pjaxId'                => $this->pjax->id,
            'requestPkParamName'    => $this->adminController->requestPkParamName
        ];
        $optionsString = Json::encode($options);

        $gridJsObject = $this->getGridJsObject();

        $this->view->registerJs(<<<JS
        {$gridJsObject} = new sx.classes.grid.Standart($optionsString);
JS
);
        $buttons = '';

        $additional = [];
        foreach ($multiActions as $action)
        {
            $additional[]               = $action->registerForGrid($this);

            $buttons .= <<<HTML
            <button class="btn btn-default btn-sm sx-grid-multi-btn" data-id="{$action->id}">
                <i class="{$action->icon}"></i> {$action->name}
            </button>
HTML;
        }

        $additional = implode('', $additional);

        $checkbox = Html::checkbox('sx-select-full-all', false, [
            'class' => 'sx-select-full-all'
        ]);

        $this->_buttonsMulti = <<<HTML
    <!--{$checkbox} All数据的批量选择-->
    <span class="sx-grid-multi-controlls">{$buttons}</span>
HTML;
        $this->_additionalsMulti = $additional;

        $this->view->registerCss(<<<CSS
    .sx-grid-multi-controlls
    {
        margin-left: 20px;
    }
CSS
);
    }

    protected $_initMultiOptions = null;
    protected $_buttonsMulti = null;
    protected $_additionalsMulti = null;
    /**
     * @param RelatedPropertiesModel|null $relatedPropertiesModel
     * @return array
     */
    static public function getColumnsByRelatedPropertiesModel(RelatedPropertiesModel $relatedPropertiesModel = null, $searchModel)
    {
        $autoColumns = [];
        $searchRelatedPropertiesModel = $searchModel;
        /**
         * @var $model \yiisns\kernel\models\ContentElement
         */
        if ($relatedPropertiesModel)
        {
            foreach ($relatedPropertiesModel->toArray($relatedPropertiesModel->attributes()) as $name => $value) {


                $property = $relatedPropertiesModel->getRelatedProperty($name);
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
                    'label' => \yii\helpers\ArrayHelper::getValue($relatedPropertiesModel->attributeLabels(), $name),
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
                            return implode(',', $value);
                        } else
                        {
                            return $value;
                        }
                    },
                ];
            }
        }
        return $autoColumns;
    }
}