<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.05.2016
 */

namespace yiisns\admin\dashboards;

use yiisns\apps\base\Widget;
use yiisns\apps\base\WidgetRenderable;
use yiisns\apps\helpers\UrlHelper;

use yiisns\kernel\models\ContentElement;
use yiisns\kernel\models\ContentElementTree;
use yiisns\kernel\models\Search;
use yiisns\admin\base\AdminDashboardWidget;
use yiisns\admin\base\AdminDashboardWidgetRenderable;

use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/**
 * Class ContentElementListDashboard
 * @package yiisns\admin\dashboards
 */
class ContentElementListDashboard extends AdminDashboardWidgetRenderable
{
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => \Yii::t('yiisns/kernel', 'The list of content items')
        ]);
    }

    public $viewFile    = 'content-element-list';

    public $name;

    public $enabledPaging               = true;
    public $pageSize                    = 10;
    public $pageSizeLimitMin            = 1;
    public $pageSizeLimitMax            = 50;

    public $orderBy                     = 'published_at';
    public $order                       = SORT_DESC;
    public $tree_ids                    = [];
    public $limit                       = 0;
    public $active                      = '';
    public $createdBy                   = [];
    public $content_ids                 = [];

    public $enabledActiveTime           = true;

    /**
     * @see (new ActiveQuery)->with
     * @var array
     */
    public $with = ['image', 'tree'];


    public function init()
    {
        parent::init();

        if (!$this->name)
        {
            $this->name = \Yii::t('yiisns/kernel', 'The list of content items');
        }
    }
    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['name'], 'string'],
            [['enabledPaging'], 'boolean'],

            [['orderBy'], 'string'],
            [['order'], 'integer'],

            [['limit'], 'integer'],
            [['pageSizeLimitMin'], 'integer'],
            [['pageSizeLimitMax'], 'integer'],

            [['active'], 'string'],
            [['createdBy'], 'safe'],
            [['content_ids'], 'safe'],

            [['tree_ids'], 'safe'],
            [['enabledActiveTime'], 'boolean'],

            [['pageSize'], 'integer'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'name'                           => \Yii::t('yiisns/kernel', 'Name'),

            'enabledPaging'             => \Yii::t('yiisns/kernel', 'Enable paging'),
            'pageSizeLimitMin'          => \Yii::t('yiisns/kernel', 'The minimum allowable value for pagination'),
            'pageSizeLimitMax'          => \Yii::t('yiisns/kernel', 'The maximum allowable value for pagination'),
            'pageSize'                  => \Yii::t('yiisns/kernel', 'Number of records on one page'),

            'orderBy'                   => \Yii::t('yiisns/kernel', 'Sort by what parameter'),
            'order'                     => \Yii::t('yiisns/kernel', 'Sorting direction'),

            'limit'                     => \Yii::t('yiisns/kernel', 'The maximum number of entries in the sample ({limit})',['limit' => 'limit']),
            'active'                    => \Yii::t('yiisns/kernel', 'Take into consideration active flag'),

            'createdBy'                 => \Yii::t('yiisns/kernel', 'Selecting the user records'),
            'content_ids'               => \Yii::t('yiisns/kernel', 'Elements of content'),

            'tree_ids'                  => \Yii::t('yiisns/kernel', 'Show items linked to sections'),
            'enabledActiveTime'         => \Yii::t('yiisns/kernel', 'Take into consideration activity time'),
        ]);
    }


    /**
     * @var ActiveDataProvider
     */
    public $dataProvider    = null;

    /**
     * @var Search
     */
    public $search          = null;

    public function initDataProvider()
    {
        $this->search         = new Search(ContentElement::className());
        $this->dataProvider   = $this->search->getDataProvider();

        if ($this->enabledPaging)
        {
            $this->dataProvider->getPagination()->defaultPageSize   = $this->pageSize;
            $this->dataProvider->getPagination()->pageParam         = 'page-' . $this->id;
            $this->dataProvider->getPagination()->pageSizeLimit         = [(int) $this->pageSizeLimitMin, (int) $this->pageSizeLimitMax];
        } else
        {
            $this->dataProvider->pagination = false;
        }

        if ($this->orderBy)
        {
            $this->dataProvider->getSort()->defaultOrder =
            [
                $this->orderBy => (int) $this->order
            ];
        }

        $this->search->search(\Yii::$app->request->get());

        return $this;
    }


    public function run()
    {
        $this->initDataProvider();

        if ($this->createdBy)
        {
            $this->dataProvider->query->andWhere([ContentElement::tableName() . '.created_by' => $this->createdBy]);
        }

        if ($this->active)
        {
            $this->dataProvider->query->andWhere([ContentElement::tableName() . '.active' => $this->active]);
        }

        if ($this->content_ids)
        {
            $this->dataProvider->query->andWhere([ContentElement::tableName() . '.content_id' => $this->content_ids]);
        }

        if ($this->limit)
        {
            $this->dataProvider->query->limit($this->limit);
        }


        $treeIds = (array) $this->tree_ids;

        if ($treeIds)
        {
            foreach ($treeIds as $key => $treeId)
            {
                if (!$treeId)
                {
                    unset($treeIds[$key]);
                }
            }

            if ($treeIds)
            {
                /**
                 * @var $query ActiveQuery
                 */
                $query = $this->dataProvider->query;

                $query->joinWith('contentElementTrees');
                $query->andWhere(
                    [
                        'or',
                        [ContentElement::tableName() . '.tree_id' => $treeIds],
                        [ContentElementTree::tableName() . '.tree_id' => $treeIds]
                    ]
                );
            }

        }


        if ($this->enabledActiveTime)
        {
            $this->dataProvider->query->andWhere(
                ["<=", ContentElement::tableName() . '.published_at', \Yii::$app->formatter->asTimestamp(time())]
            );

            $this->dataProvider->query->andWhere(
                [
                    'or',
                    [">=", ContentElement::tableName() . '.published_to', \Yii::$app->formatter->asTimestamp(time())],
                    [ContentElement::tableName() . '.published_to' => null],
                ]
            );
        }

        /**
         *
         */
        if ($this->with)
        {
            $this->dataProvider->query->with($this->with);
        }

        $this->dataProvider->query->groupBy([ContentElement::tableName() . '.id']);

        return parent::run();
    }

    /**
     * @param \yiisns\admin\widgets\ActiveForm $form
     */
    public function renderConfigForm(ActiveForm $form = null)
    {
        echo $form->fieldSet(\Yii::t('yiisns/kernel', 'Main'));
            echo $form->field($this, 'name');
        echo $form->fieldSetEnd();

        echo $form->fieldSet(\Yii::t('yiisns/kernel','Pagination'));
            echo $form->field($this, 'enabledPaging')->checkbox();
            echo $form->field($this, 'pageSize');
            echo $form->field($this, 'pageSizeLimitMin');
            echo $form->field($this, 'pageSizeLimitMax');
        echo $form->fieldSetEnd();

        echo $form->fieldSet(\Yii::t('yiisns/kernel', 'Filtering'));

            echo $form->field($this, 'enabledActiveTime')->checkbox()
                ->hint(\Yii::t('yiisns/kernel', 'Will be considered time of beginning and end of the publication'));

            echo $form->fieldSelectMulti($this, 'content_ids', \yiisns\kernel\models\Content::getDataForSelect());
            /*echo $form->fieldSelectMulti($this, 'createdBy')->widget(
                \yiisns\admin\widgets\formInputs\SelectModelDialogUserInput::className()
            );*/

            echo $form->field($this, 'tree_ids')->widget(
                \yiisns\apps\widgets\formInputs\selectTree\SelectTree::className(),
                [
                    'mode' => \yiisns\apps\widgets\formInputs\selectTree\SelectTree::MOD_MULTI,
                    'attributeMulti' => 'tree_ids'
                ]
            );
        echo $form->fieldSetEnd();

        echo $form->fieldSet(\Yii::t('yiisns/kernel', 'Sorting and quantity'));
            echo $form->field($this, 'limit');
            echo $form->fieldSelect($this, 'orderBy', (new \yiisns\kernel\models\ContentElement())->attributeLabels());
            echo $form->fieldSelect($this, 'order', [
            SORT_ASC    => "ASC (".\Yii::t('yiisns/kernel', 'from smaller to larger').")",
            SORT_DESC   => "DESC (".\Yii::t('yiisns/kernel', 'from highest to lowest').")",
        ]);
        echo $form->fieldSetEnd();
    }
}