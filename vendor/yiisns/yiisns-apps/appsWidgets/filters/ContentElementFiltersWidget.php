<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.05.2016
 */
namespace yiisns\apps\appsWidgets\filters;

use yiisns\apps\base\Widget;
use yiisns\apps\base\WidgetRenderable;
use yiisns\apps\appsWidgets\filters\models\SearchProductsModel;
use yiisns\kernel\base\AppCore;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\Content;
use yiisns\kernel\models\ContentElement;
use yiisns\kernel\models\ContentElementTree;
use yiisns\kernel\models\Search;
use yiisns\kernel\models\Tree;
use yiisns\kernel\models\searchs\SearchRelatedPropertiesModel;

use yii\base\DynamicModel;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/**
 * @property Content $content;
 *
 * Class ContentElementFiltersWidget
 * @package yiisns\apps\appsWidgets\filters
 */
class ContentElementFiltersWidget extends WidgetRenderable
{
    public $content_id;
    public $searchModelAttributes       = [];
    public $realatedProperties          = [];

    /**
     * @var bool taking into account only the available filters of current sampling
     */
    public $onlyExistsFilters = false;
    /**
     * @var array (array ids records to show only the filters)
     */
    public $elementIds = [];

    /**
     * @var SearchProductsModel
     */
    public $searchModel = null;

    /**
     * @var SearchRelatedPropertiesModel
     */
    public $searchRelatedPropertiesModel  = null;

    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => 'Filters',
        ]);
    }

    public function init()
    {
        parent::init();

        if (!$this->searchModelAttributes)
        {
            $this->searchModelAttributes = [];
        }

        if (!$this->searchModel)
        {
            $this->searchModel = new \yiisns\apps\appsWidgets\filters\models\SearchProductsModel();
        }

        if (!$this->searchRelatedPropertiesModel && $this->content)
        {
            $this->searchRelatedPropertiesModel = new SearchRelatedPropertiesModel();
            $this->searchRelatedPropertiesModel->initContent($this->content);
        }

        $this->searchModel->load(\Yii::$app->request->get());

        if ($this->searchRelatedPropertiesModel)
        {
            $this->searchRelatedPropertiesModel->load(\Yii::$app->request->get());
        }
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),
        [
            'content_id'                => \Yii::t('yiisns/kernel', 'Content'),
            'searchModelAttributes'     => \Yii::t('yiisns/kernel', 'Fields'),
            'realatedProperties'        => \Yii::t('yiisns/kernel', 'Properties'),
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
        [
            [['content_id'], 'integer'],
            [['searchModelAttributes'], 'safe'],
            [['realatedProperties'], 'safe'],
        ]);
    }

    public function renderConfigForm(ActiveForm $form)
    {
        echo \Yii::$app->view->renderFile(__DIR__ . '/_form.php', [
            'form'  => $form,
            'model' => $this
        ], $this);
    }

    /**
     * @return Content
     */
    public function getContent()
    {
        return Content::findOne($this->content_id);
    }

    /**
     * @param ActiveDataProvider $activeDataProvider
     */
    public function search(ActiveDataProvider $activeDataProvider)
    {
        if ($this->onlyExistsFilters)
        {
            /**
             * @var $query \yii\db\ActiveQuery
             */
            $query  = clone $activeDataProvider->query;
            $ids    = $query->select(['content_element.id as mainId'])->indexBy('mainId')->asArray()->all();

            $this->elementIds = array_keys($ids);
        }

        $this->searchModel->search($activeDataProvider);

        if ($this->searchRelatedPropertiesModel)
        {
            $this->searchRelatedPropertiesModel->search($activeDataProvider);
        }
    }

    /**
     *
     * @param ContentProperty $property
     * @return $this|array|\yii\db\ActiveRecord[]
     */
    public function getRelatedPropertyOptions($property)
    {
        $options = [];

        if ($property->property_type == \yiisns\kernel\relatedProperties\PropertyType::CODE_ELEMENT)
        {
            $propertyType = $property->handler;

            if ($this->elementIds)
            {
                $availables = \yiisns\kernel\models\ContentElementProperty::find()
                    ->select(['value_enum'])
                    ->indexBy('value_enum')
                    ->andWhere(['element_id' => $this->elementIds])
                    ->andWhere(['property_id' => $property->id])
                    ->asArray()
                    ->all()
                ;

                $availables = array_keys($availables);
            }

            $options = \yiisns\kernel\models\ContentElement::find()
                ->active()
                ->andWhere(['content_id' => $propertyType->content_id]);
                if ($this->elementIds)
                {
                    $options->andWhere(['id' => $availables]);
                }

            $options = $options->select(['id', 'name'])->asArray()->all();

            $options = \yii\helpers\ArrayHelper::map(
                $options, 'id', 'name'
            );

        } elseif ($property->property_type == \yiisns\kernel\relatedProperties\PropertyType::CODE_LIST)
        {
            $options = $property->getEnums()->select(['id', 'value']);

            if ($this->elementIds)
            {
                $availables = \yiisns\kernel\models\ContentElementProperty::find()
                    ->select(['value_enum'])
                    ->indexBy('value_enum')
                    ->andWhere(['element_id' => $this->elementIds])
                    ->andWhere(['property_id' => $property->id])
                    ->asArray()
                    ->all()
                ;

                $availables = array_keys($availables);
                $options->andWhere(['id' => $availables]);
            }

            $options = $options->asArray()->all();

            $options = \yii\helpers\ArrayHelper::map(
                $options, 'id', 'value'
            );
        }

        return $options;
    }
}