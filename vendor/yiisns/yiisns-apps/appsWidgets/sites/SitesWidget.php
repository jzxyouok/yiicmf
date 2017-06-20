<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.05.2016
 */

namespace yiisns\apps\appsWidgets\sites;

use yiisns\kernel\base\AppCore;
use yiisns\apps\base\Widget;
use yiisns\apps\base\WidgetRenderable;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\ContentElement;
use yiisns\kernel\models\ContentElementTree;
use yiisns\kernel\models\Site;
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
 * Class SitesWidget
 * @package yiisns\apps\appsWidgets\contentElements
 */
class SitesWidget extends WidgetRenderable
{
    public $orderBy                     = 'priority';
    public $order                       = SORT_ASC;
    public $label                       = null;
    public $limit                       = 0;
    public $active                      = AppCore::BOOL_Y;
    public $enabledRunCache             = AppCore::BOOL_Y;
    public $runCacheDuration            = 0;

    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => 'Sites'
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),
        [
            'orderBy'                   => \Yii::t('yiisns/kernel', 'Sort by what parameter'),
            'order'                     => \Yii::t('yiisns/kernel', 'Sorting direction'),
            'label'                     => \Yii::t('yiisns/kernel', 'Title'),
            'limit'                     => \Yii::t('yiisns/kernel', 'The maximum number of entries in the sample ({limit})',['limit' => 'limit']),
            'active'                    => \Yii::t('yiisns/kernel', 'Take into consideration active flag'),
            'enabledRunCache'           =>  \Yii::t('yiisns/kernel', 'Include caching'),
            'runCacheDuration'          =>  \Yii::t('yiisns/kernel', 'The lifetime of a cache'),
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
        [
            [['enabledPaging'], 'string'],
            [['enabledPjaxPagination'], 'string'],
            [['pageParamName'], 'string'],
            [['pageSize'], 'string'],
            [['orderBy'], 'string'],
            [['order'], 'integer'],
            [['label'], 'string'],
            [['label'], 'string'],
            [['enabledSearchParams'], 'string'],
            [['limit'], 'integer'],
            [['active'], 'string'],
            [['createdBy'], 'safe'],
            [['content_ids'], 'safe'],
            [['enabledCurrentTree'], 'string'],
            [['enabledCurrentTreeChild'], 'string'],
            [['tree_ids'], 'safe'],
            [['enabledRunCache'], 'string'],
            [['runCacheDuration'], 'integer'],
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
     * @var ActiveQuery
     */
    public $activeQuery = null;


    protected function _run()
    {
        $key = $this->getCacheKey() . 'run';

        $dependency = new TagDependency([
            'tags'      =>
            [
                $this->className() . (string) $this->namespace,
                (new Site())->getTableCacheTag(),
            ],
        ]);

        $result = \Yii::$app->cache->get($key);
        if ($result === false || $this->enabledRunCache == AppCore::BOOL_N)
        {
            $this->activeQuery = Site::find();

            if ($this->active == AppCore::BOOL_Y)
            {
                $this->activeQuery->active();
            } else if ($this->active == AppCore::BOOL_N)
            {
                $this->activeQuery->active(false);
            }

            if ($this->limit)
            {
                $this->activeQuery->limit($limit);
            }

            if ($this->orderBy)
            {
                $this->activeQuery->orderBy([$this->orderBy => (int) $this->order]);
            }

            $result = parent::_run();

            \Yii::$app->cache->set($key, $result, (int) $this->runCacheDuration, $dependency);
        }

        return $result;
    }
}