<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.05.2016
 */
namespace yiisns\apps\appsWidgets\contentElements;

use yiisns\kernel\base\AppCore;
use yiisns\apps\base\Widget;
use yiisns\apps\base\WidgetRenderable;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\ContentElement;
use yiisns\kernel\models\ContentElementTree;
use yiisns\kernel\models\Search;
use yiisns\kernel\models\Tree;

use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/**
 * Class ContentElementsWidget
 * 
 * @package yiisns\apps\appsWidgets\contentElements
 */
class ContentElementsWidget extends WidgetRenderable
{
    public $contentElementClass = '\yiisns\kernel\models\ContentElement';

    public $enabledPaging = AppCore::BOOL_Y;

    public $enabledPjaxPagination = AppCore::BOOL_Y;

    public $pageSize = 10;

    public $pageSizeLimitMin = 1;

    public $pageSizeLimitMax = 50;

    public $pageParamName = 'page';

    public $orderBy = 'published_at';

    public $order = SORT_DESC;

    public $label = null;

    public $enabledSearchParams = AppCore::BOOL_Y;

    public $enabledCurrentTree = AppCore::BOOL_Y;

    public $enabledCurrentTreeChild = AppCore::BOOL_Y;

    public $enabledCurrentTreeChildAll = AppCore::BOOL_Y;

    public $tree_ids = [];

    public $limit = 0;

    public $active = '';

    public $createdBy = [];

    public $content_ids = [];

    public $enabledActiveTime = AppCore::BOOL_Y;

    public $enabledRunCache = AppCore::BOOL_N;

    public $runCacheDuration = 0;

    public $activeQueryCallback;

    public $dataProviderCallback;

    /**
     * Additionaly, any data
     *
     * @var array
     */
    public $data = [];

    /**
     *
     * @see (new ActiveQuery)->with
     * @var array
     */
    public $with = ['image', 'tree'];

    /**
     * When a sample of elements does a search and table of multiple links.
     * Slowly on large databases!
     * 
     * @var bool
     */
    public $isJoinTreeMap = true;

    public $options = [];

    public function init()
    {
        parent::init();
        
        $this->initActiveQuery();
    }

    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => \Yii::t('yiisns/kernel', 'Content elements')
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'enabledPaging' => \Yii::t('yiisns/kernel', 'Enable paging'),
            'enabledPjaxPagination' => \Yii::t('yiisns/kernel', 'Enable ajax navigation'),
            'pageParamName' => \Yii::t('yiisns/kernel', 'Parameter name pages'),
            'pageSize' => \Yii::t('yiisns/kernel', 'Number of records on one page'),
            'pageSizeLimitMin' => \Yii::t('yiisns/kernel', 'The minimum allowable value for pagination'),
            'pageSizeLimitMax' => \Yii::t('yiisns/kernel', 'The maximum allowable value for pagination'),
            'orderBy' => \Yii::t('yiisns/kernel', 'Sort by what parameter'),
            'order' => \Yii::t('yiisns/kernel', 'Sorting direction'),
            'label' => \Yii::t('yiisns/kernel', 'Title'),
            'enabledSearchParams' => \Yii::t('yiisns/kernel', 'Take into account the parameters from search string (for filtering)'),
            'limit' => \Yii::t('yiisns/kernel', 'The maximum number of entries in the sample ({limit})', [
                'limit' => 'limit'
            ]),
            'active' => \Yii::t('yiisns/kernel', 'Take into consideration active flag'),
            'createdBy' => \Yii::t('yiisns/kernel', 'Selecting the user records'),
            'content_ids' => \Yii::t('yiisns/kernel', 'Elements of content'),
            'enabledCurrentTree' => \Yii::t('yiisns/kernel', 'For the colection taken into account the current section (which shows the widget)'),
            'enabledCurrentTreeChild' => \Yii::t('yiisns/kernel', 'For the colection taken into account the current section and its subsections'),
            'enabledCurrentTreeChildAll' => \Yii::t('yiisns/kernel', 'For the colection taken into account the current section and all its subsections'),
            'tree_ids' => \Yii::t('yiisns/kernel', 'Show items linked to sections'),
            'enabledActiveTime' => \Yii::t('yiisns/kernel', 'Take into consideration activity time'),
            'enabledRunCache' => \Yii::t('yiisns/kernel', 'Include caching'),
            'runCacheDuration' => \Yii::t('yiisns/kernel', 'The lifetime of a cache')
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                [
                    'enabledPaging'
                ],
                'string'
            ],
            [
                [
                    'enabledPjaxPagination'
                ],
                'string'
            ],
            [
                [
                    'pageParamName'
                ],
                'string'
            ],
            [
                [
                    'pageSize'
                ],
                'string'
            ],
            [
                [
                    'orderBy'
                ],
                'string'
            ],
            [
                [
                    'order'
                ],
                'integer'
            ],
            [
                [
                    'label'
                ],
                'string'
            ],
            [
                [
                    'label'
                ],
                'string'
            ],
            [
                [
                    'enabledSearchParams'
                ],
                'string'
            ],
            [
                [
                    'limit'
                ],
                'integer'
            ],
            [
                [
                    'pageSizeLimitMin'
                ],
                'integer'
            ],
            [
                [
                    'pageSizeLimitMax'
                ],
                'integer'
            ],
            [
                [
                    'active'
                ],
                'string'
            ],
            [
                [
                    'createdBy'
                ],
                'safe'
            ],
            [
                [
                    'content_ids'
                ],
                'safe'
            ],
            [
                [
                    'enabledCurrentTree'
                ],
                'string'
            ],
            [
                [
                    'enabledCurrentTreeChild'
                ],
                'string'
            ],
            [
                [
                    'enabledCurrentTreeChildAll'
                ],
                'string'
            ],
            [
                [
                    'tree_ids'
                ],
                'safe'
            ],
            [
                [
                    'enabledActiveTime'
                ],
                'string'
            ],
            
            [
                [
                    'enabledRunCache'
                ],
                'string'
            ],
            [
                [
                    'runCacheDuration'
                ],
                'integer'
            ]
        ]);
    }

    public function renderConfigForm(ActiveForm $form)
    {
        echo \Yii::$app->view->renderFile(__DIR__ . '/_form.php', [
            'form' => $form,
            'model' => $this
        ], $this);
    }

    protected function _run()
    {
        $cacheKey = $this->getCacheKey() . 'run';
        
        $dependency = new TagDependency([
            'tags' => [
                $this->className() . (string) $this->namespace,
                (new ContentElement())->getTableCacheTag()
            ]
        ]);
        
        $result = \Yii::$app->cache->get($cacheKey);
        if ($result === false || $this->enabledRunCache == AppCore::BOOL_N) {
            $result = parent::_run();
            
            \Yii::$app->cache->set($cacheKey, $result, (int) $this->runCacheDuration, $dependency);
        }
        
        return $result;
    }

    /**
     *
     * @param Tree $tree            
     * @return array
     */
    public function getAllIdsForChildren(Tree $tree)
    {
        $treeIds = [];
        /**
         *
         * @var $query ActiveQuery
         */
        $childrens = $tree->getChildren()
            ->with('children')
            ->all();
        
        if ($childrens) {
            foreach ($childrens as $chidren) {
                if ($chidren->children) {
                    $treeIds[$chidren->id] = $chidren->id;
                    $treeIds = array_merge($treeIds, $this->getAllIdsForChildren($chidren));
                } else {
                    $treeIds[$chidren->id] = $chidren->id;
                }
            }
        }
        
        return $treeIds;
    }

    /**
     *
     * @var ActiveDataProvider
     */
    public $dataProvider = null;

    /**
     *
     * @var Search
     */
    public $search = null;

    /**
     *
     * @return $this
     */
    public function initActiveQuery()
    {
        $className = $this->contentElementClass;
        $this->initDataProvider();
        
        if ($this->createdBy) {
            $this->dataProvider->query->andWhere([
                $className::tableName() . '.created_by' => $this->createdBy
            ]);
        }
        
        if ($this->active) {
            $this->dataProvider->query->andWhere([
                $className::tableName() . '.active' => $this->active
            ]);
        }
        
        if ($this->content_ids) {
            $this->dataProvider->query->andWhere([
                $className::tableName() . '.content_id' => $this->content_ids
            ]);
        }
        
        if ($this->limit) {
            $this->dataProvider->query->limit($this->limit);
        }
        
        $treeIds = (array) $this->tree_ids;
        
        if ($this->enabledCurrentTree == AppCore::BOOL_Y) {
            $tree = \Yii::$app->appSettings->currentTree;
            if ($tree) {
                if ($this->enabledCurrentTreeChild == AppCore::BOOL_Y) {
                    if ($this->enabledCurrentTreeChildAll == AppCore::BOOL_Y) {
                        $treeIds = $tree->getDescendants()
                            ->select([
                            'id'
                        ])
                            ->indexBy('id')
                            ->asArray()
                            ->all();
                        $treeIds = array_keys($treeIds);
                    } else {
                        if ($childrens = $tree->children) {
                            foreach ($childrens as $chidren) {
                                $treeIds[] = $chidren->id;
                            }
                        }
                    }
                }
                
                $treeIds[] = $tree->id;
            }
        }
        
        if ($treeIds) {
            foreach ($treeIds as $key => $treeId) {
                if (! $treeId) {
                    unset($treeIds[$key]);
                }
            }
            
            if ($treeIds) {
                /**
                 *
                 * @var $query ActiveQuery
                 */
                $query = $this->dataProvider->query;
                
                if ($this->isJoinTreeMap === true) {
                    $query->joinWith('contentElementTrees');
                    $query->andWhere([
                        'or',
                        [
                            $className::tableName() . '.tree_id' => $treeIds
                        ],
                        [
                            ContentElementTree::tableName() . '.tree_id' => $treeIds
                        ]
                    ]);
                } else {
                    $query->andWhere([
                        $className::tableName() . '.tree_id' => $treeIds
                    ]);
                }
            }
        }
        
        if ($this->enabledActiveTime == AppCore::BOOL_Y) {
            $this->dataProvider->query->andWhere([
                "<=",
                $className::tableName() . '.published_at',
                \Yii::$app->formatter->asTimestamp(time())
            ]);
            
            $this->dataProvider->query->andWhere([
                'or',
                [
                    ">=",
                    $className::tableName() . '.published_to',
                    \Yii::$app->formatter->asTimestamp(time())
                ],
                [
                    ContentElement::tableName() . '.published_to' => null
                ]
            ]);
        }
        
        if ($this->with) {
            $this->dataProvider->query->with($this->with);
        }
        
        $this->dataProvider->query->groupBy([
            $className::tableName() . '.id'
        ]);
        
        if ($this->activeQueryCallback && is_callable($this->activeQueryCallback)) {
            $callback = $this->activeQueryCallback;
            $callback($this->dataProvider->query);
        }
        
        if ($this->dataProviderCallback && is_callable($this->dataProviderCallback)) {
            $callback = $this->dataProviderCallback;
            $callback($this->dataProvider);
        }
        
        return $this;
    }

    public function initDataProvider()
    {
        $className = $this->contentElementClass;
        
        $this->search = new Search($className::className());
        $this->dataProvider = $this->search->getDataProvider();
        
        if ($this->enabledPaging == AppCore::BOOL_Y) {
            $this->dataProvider->getPagination()->defaultPageSize = $this->pageSize;
            $this->dataProvider->getPagination()->pageParam = $this->pageParamName;
            $this->dataProvider->getPagination()->pageSizeLimit = [
                (int) $this->pageSizeLimitMin,
                (int) $this->pageSizeLimitMax
            ];
        } else {
            $this->dataProvider->pagination = false;
        }
        
        if ($this->orderBy) {
            $this->dataProvider->getSort()->defaultOrder = [
                $this->orderBy => (int) $this->order
            ];
        }
        
        return $this;
    }
}