<?php
/**
 * SelectTree
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 13.11.2016
 * @since 1.0.0
 */
namespace yiisns\apps\widgets\formInputs\selectTree;

use yiisns\apps\Exception;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\Tree;
use yiisns\admin\Module;
use yiisns\admin\widgets\ActiveForm;
use yiisns\apps\widgets\formInputs\selectTree\assets\SelectTreeInputWidgetAsset;
use yiisns\apps\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use Yii;

/**
 *
 *
 *  <?= $form->field($model, 'treeIds')->widget(
        \yiisns\apps\widgets\formInputs\selectTree\SelectTreeInputWidget::class,
        [
            'multiple' => true
        ]
    ); ?>
 *
 *
 * @property Tree[] $sections
 *
 * Class SelectTreeInputWidget
 *
 * @package yiisns\kernel\widgets\formInputs\selectTree
 */
class SelectTreeInputWidget extends InputWidget
{
    public static $autoIdPrefix = 'SelectTreeInputWidget';

    /**
     * @var array
     */
    public $clientOptions = [];
    /**
     * @var array
     */
    public $wrapperOptions = [];

    /**
     * @see yiisns\apps\widgets\tree\TreeWidget options
     *
     * @var array
     */
    public $treeWidgetOptions   = [];
    public $treeWidgetClass     = 'yiisns\apps\widgets\tree\TreeWidget';

    /**
     * @var bool
     */
    public $multiple      = false;

    /**
     * @var null|callable
     */
    public $isAllowNodeSelectCallback = null;

    public function init()
    {
        $this->treeWidgetOptions = ArrayHelper::merge([
            'models'                => [],
            'sessionName'           => 'select-' . (int) $this->multiple,
            'viewNodeContentFile'   => '@yiisns/apps/widgets/formInputs/selectTree/views/_tree-node',

            'pjaxOptions'   =>
            [
                'enablePushState' => false,
            ],

            'contextData' => [
                'selectTreeInputWidget' => $this
            ]
        ], $this->treeWidgetOptions);

        $this->wrapperOptions['id'] = $this->id . "-wrapper";

        $this->clientOptions['id']          = $this->id;
        $this->clientOptions['wrapperid']   = $this->wrapperOptions['id'];

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $value = $this->model->{$this->attribute};
        $items = $value;
        if ($value && is_string($value) || is_int($value))
        {
            $items = [$value => $value];
        }

        if (!$items)
        {
            $items = [];
        }

        $this->options['multiple'] = $this->multiple;
        Html::addCssClass($this->options, 'sx-widget-element');

        $select = Html::activeListBox($this->model, $this->attribute, $items, $this->options);

        $this->clientOptions['value']       = $value;
        $this->clientOptions['multiple']    = (int) $this->multiple;
        $this->registerAssets();

        return $this->render('select-tree-widget', [
            'elementForm' => $select
        ]);
    }

    /**
     * @return $this
     */
    public function registerAssets()
    {
        SelectTreeInputWidgetAsset::register($this->view);
        return $this;
    }

    /**
     * @param $model
     *
     * @return string
     */
    public function getNodeName($tree)
    {
        if ($models = ArrayHelper::getValue($this->treeWidgetOptions, 'models'))
        {
            $model = $models[0];
            $rootLevel = $model->level;

            /**
             * @var \yiisns\kernel\models\Tree $tree
             */
            $name = $tree->name;
            if ($tree->parents)
            {
                $parents = $tree->getParents()->andWhere(['>=', 'level', $rootLevel])->all();
                if ($parents)
                {
                    $name = implode(" / ", \yii\helpers\ArrayHelper::map($parents, 'id', 'name'));
                    $name .= " / " . $tree->name;
                }
            }

            return $name;
        }

        return $tree->name;
    }

    /**
     * @param $model
     *
     * @return string
     */
    public function renderNodeControll($model)
    {
        $disabled = false;
        if ($this->isAllowNodeSelectCallback && is_callable($this->isAllowNodeSelectCallback))
        {
            $function = $this->isAllowNodeSelectCallback;
            if (!$function($model))
            {
                $disabled = "disabled";
            }
        }

        if ($this->multiple)
        {
            $controllElement = Html::checkbox($this->id . '-checkbox', false, [
                'value'     => $model->id,
                'class'     => 'sx-checkbox',
                'disabled'  => $disabled,
                'style'     => 'float: left; margin-left: 5px; margin-right: 5px;',
            ]);
        } else
        {
            $controllElement = Html::radio($this->id . '-radio', false, [
                'value'     => $model->id,
                'class'     => 'sx-radio',
                'disabled'  => $disabled,
                'style'     => 'float: left; margin-left: 5px; margin-right: 5px;',
            ]);
        }

        return $controllElement;
    }

    /**
     * @param $model
     *
     * @return string
     */
    public function renderNodeName($model)
    {
        $result = $model->name;
        $additionalName = '';
        if ($model->level == 0)
        {
            $site = \yiisns\kernel\models\Site::findOne(['code' => $model->site_code]);
            if ($site)
            {
                $additionalName = $site->name;
            }
        }

        if ($additionalName)
        {
            $result .= " [{$additionalName}]";
        }

        return $result;
    }

    /**
     * @return Tree[]
     */
    public function getSections()
    {
        $value = $this->model->{$this->attribute};
        if (!$value)
        {
            return [];
        }

        $items = $value;
        if (is_string($value) || is_int($value))
        {
            $items = [$value => $value];
        }

        return Tree::findAll(["id" => $items]);
    }
}