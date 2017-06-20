<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.05.2016
 */
namespace yiisns\apps\appsWidgets\treeMenu;

use yiisns\kernel\base\AppCore;
use yiisns\apps\base\Widget;
use yiisns\apps\base\WidgetRenderable;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\Tree;

use yii\caching\TagDependency;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/**
 * Class TreeMenuWidget
 *
 * @package yiisns\apps\appsWidgets\treeMenu
 */
class TreeMenuWidget extends WidgetRenderable
{
    public $treePid = null;

    public $active = AppCore::BOOL_Y;

    public $level = null;

    public $label = null;

    public $site_codes = [];

    public $orderBy = 'priority';

    public $order = SORT_ASC;

    public $enabledCurrentSite = AppCore::BOOL_Y;

    public $enabledRunCache = AppCore::BOOL_Y;

    public $runCacheDuration = 0;

    public $tree_type_ids = [];

    public $activeQueryCallback;

    /**
     *
     * @see (new ActiveQuery)->with
     * @var array
     */
    public $with = [
        'children'
    ];

    /**
     *
     * @var ActiveQuery
     */
    public $activeQuery = null;

    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => 'The menu sections',
        ]);
    }

    public $text = '';

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'treePid' => \Yii::t('yiisns/kernel', 'The parent section'),
            'active' => \Yii::t('yiisns/kernel', 'Activity'),
            'level' => \Yii::t('yiisns/kernel', 'The nesting level'),
            'label' => \Yii::t('yiisns/kernel', 'Header'),
            'site_codes' => \Yii::t('yiisns/kernel', 'Linking to sites'),
            'orderBy' => \Yii::t('yiisns/kernel', 'Sorting'),
            'order' => \Yii::t('yiisns/kernel', 'Sorting direction'),
            'enabledCurrentSite' => \Yii::t('yiisns/kernel', 'Consider the current site'),
            'enabledRunCache' => \Yii::t('yiisns/kernel', 'Enable caching'),
            'runCacheDuration' => \Yii::t('yiisns/kernel', 'Cache lifetime'),
            'tree_type_ids' => \Yii::t('yiisns/kernel', 'Section types')
        ]);
    }

    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
            'enabledCurrentSite' => \Yii::t('yiisns/kernel', 'If you select "yes", then the sample section, add the filter condition, sections of the site, which is called the widget'),
            'level' => \Yii::t('yiisns/kernel', 'Adds the sample sections, the condition of nesting choice. 0 - will not use this condition at all.')
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                'text',
                'string'
            ],
            [
                [
                    'viewFile',
                    'label',
                    'active',
                    'orderBy',
                    'enabledCurrentSite',
                    'enabledRunCache'
                ],
                'string'
            ],
            [
                [
                    'treePid',
                    'level',
                    'runCacheDuration'
                ],
                'integer'
            ],
            [
                [
                    'order'
                ],
                'integer'
            ],
            [
                [
                    'site_codes'
                ],
                'safe'
            ],
            [
                [
                    'tree_type_ids'
                ],
                'safe'
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

    public function init()
    {
        parent::init();
        
        $this->initActiveQuery();
    }

    /**
     * 
     * @return $this
     */
    public function initActiveQuery()
    {
        $this->activeQuery = Tree::find();
        
        if ($this->treePid) {
            $this->activeQuery->andWhere([
                'pid' => $this->treePid
            ]);
        }
        
        if ($this->level) {
            $this->activeQuery->andWhere([
                'level' => $this->level
            ]);
        }
        
        if ($this->active) {
            $this->activeQuery->andWhere([
                'active' => $this->active
            ]);
        }
        
        if ($this->site_codes) {
            $this->activeQuery->andWhere([
                'site_code' => $this->site_codes
            ]);
        }
        
        if ($this->enabledCurrentSite == AppCore::BOOL_Y && \Yii::$app->appSettings->site) {
            $this->activeQuery->andWhere([
                'site_code' => \Yii::$app->appSettings->site->code
            ]);
        }
        
        if ($this->orderBy) {
            $this->activeQuery->orderBy([
                $this->orderBy => (int) $this->order
            ]);
        }
        
        if ($this->tree_type_ids) {
            $this->activeQuery->andWhere([
                'tree_type_id' => $this->tree_type_ids
            ]);
        }
        
        if ($this->with) {
            $this->activeQuery->with($this->with);
        }
        
        if ($this->activeQueryCallback && is_callable($this->activeQueryCallback)) {
            $callback = $this->activeQueryCallback;
            $callback($this->activeQuery);
        }
        
        return $this;
    }

    protected function _run()
    {
        $key = $this->getCacheKey() . 'run';
        
        $dependency = new TagDependency([
            'tags' => [
                $this->className() . (string) $this->namespace,
                (new Tree())->getTableCacheTag()
            ]
        ]);
        
        $result = \Yii::$app->cache->get($key);
        if ($result === false || $this->enabledRunCache == AppCore::BOOL_N) {
            $result = parent::_run();
            \Yii::$app->cache->set($key, $result, (int) $this->runCacheDuration, $dependency);
        }
        
        return $result;
    }
}