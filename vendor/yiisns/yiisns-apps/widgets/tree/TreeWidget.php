<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.12.2016
 */

namespace yiisns\apps\widgets\tree;

use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\Site;
use yiisns\kernel\models\Tree;
use yiisns\apps\widgets\tree\assets\TreeWidgetAsset;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * @property int[] $openedIds
 *
 * Class TreeWidget
 * @package yiisns\kernel\widgets\tree
 */
class TreeWidget extends Widget
{
    public static $autoIdPrefix = 'treeWidget';

    /**
     * @var array Widget wrapper options
     */
    public $options = [];

    /**
     * @var array Nodes for which to build a tree.
     */
    public $models      = [];

    /**
     * @var string Widget session param name
     */
    public $sessionName                 = 'apps-tree-opened';

    /**
     * @var string
     */
    public $openedRequestName           = 'o';

    /**
     * @var string Widget view file
     */
    public $viewFile                    = 'tree';
    /**
     * @var string Widget one node view file
     */
    public $viewNodeFile                = '_node';
    /**
     * @var string Inner node content file
     */
    public $viewNodeContentFile         = '_node-content';

    /**
     * @var array Additional information in the context of a call widget
     */
    public $contextData                     = [];

    /**
     * @var \yii\widgets\Pjax
     */
    public $pjax                        = null;
    public $pjaxClass                   = 'yiisns\apps\widgets\Pjax';
    public $pjaxOptions                 = [
        'isBlock' => true
    ];


    protected $_pjaxIsStart = false;

    public function init()
    {
        parent::init();

        $this->options['id'] = $this->id;
        Html::addCssClass($this->options, 'sx-tree');

        //Automatic filling models
        if ($this->models !== false && is_array($this->models) && count($this->models) == 0)
        {
            $this->models = Tree::findRoots()
                ->joinWith('siteRelation')
                ->orderBy([Site::tableName() . ".priority" => SORT_ASC])->all();
        }

        $this->_beginPjax();
    }

    /**
     * @return array
     */
    public function getOpenedIds()
    {
        if ($fromRequest = (array) \Yii::$app->request->getQueryParam($this->openedRequestName))
        {
            $opened = array_unique($fromRequest);
            \Yii::$app->getSession()->set($this->sessionName, $opened);
        } else
        {
            $opened = array_unique(\Yii::$app->getSession()->get($this->sessionName, []));
        }

        return $opened;
    }


    /**
     * @return string
     */
    public function run()
    {
        $this->registerAssets();
        echo $this->render($this->viewFile);
        $this->_endPjax();
    }

    /**
     * @return $this
     */
    protected function _beginPjax()
    {
        if (!$this->pjax)
        {
            $pjaxClass = $this->pjaxClass;
            $pjaxOptions = ArrayHelper::merge($this->pjaxOptions, [
                'id' => 'sx-pjax-' . $this->id,
                //'enablePushState' => false,
            ]);
            $this->_pjaxIsStart = true;
            $this->pjax = $pjaxClass::begin($pjaxOptions);
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function _endPjax()
    {
        if ($this->_pjaxIsStart === true)
        {
            $className = $this->pjax->className();
            $className::end();
        }

        return $this;
    }

    /**
     * @param $models
     * @return string
     */
    public function renderNodes($models)
    {
        $options["item"] = [$this, 'renderNode'];
        $ul = Html::ul($models, $options);

        return $ul;
    }

    /**
     * @param $model
     * @return string
     */
    public function renderNode($model)
    {
        return $this->render($this->viewNodeFile, [
            'model' => $model,
        ]);
    }

    /**
     * @param $model
     * @return string
     */
    public function renderNodeContent($model)
    {
        return $this->render($this->viewNodeContentFile, [
            'model' => $model,
        ]);
    }


    /**
     * @param $model
     * @return $this|string
     */
    public function getOpenCloseLink($model)
    {
        $currentLink = "";

        if ($model->children)
        {
            $openedIds = $this->openedIds;

            if ($this->isOpenNode($model))
            {
                $newOptionsOpen = [];
                foreach ($openedIds as $id)
                {
                    if ($id != $model->id)
                    {
                        $newOptionsOpen[] = $id;
                    }
                }

                $urlOptionsOpen = array_unique($newOptionsOpen);
                $params = \Yii::$app->request->getQueryParams();
                $pathInfo = \Yii::$app->request->pathInfo;
                $params[$this->openedRequestName] = $urlOptionsOpen;

                $currentLink = "/{$pathInfo}?" . http_build_query($params);
            } else
            {
                $urlOptionsOpen = array_unique(array_merge($openedIds, [$model->id]));
                $params = \Yii::$app->request->getQueryParams();
                $params[$this->openedRequestName] = $urlOptionsOpen;
                $pathInfo = \Yii::$app->request->pathInfo;

                $currentLink = "/{$pathInfo}?" . http_build_query($params);
            }
        }

        return $currentLink;
    }

    /**
     * Нода для этой модели открыта?
     *
     * @param $model
     * @return bool
     */
    public function isOpenNode($model)
    {
        $isOpen = false;

        if ($openedIds = (array) $this->openedIds)
        {
            if (in_array($model->id, $openedIds))
            {
                $isOpen = true;
            }
        }

        return $isOpen;
    }

    /**
     *
     *
     * @param $model
     * @return string
     */
    public function getNodeName($model)
    {
        /**
         * @var $model \yiisns\kernel\models\Tree
         */

        $result = $model->name;

        $additionalName = '';
        if ($model->level == 0)
        {
            $site = Site::findOne(['code' => $model->site_code]);
            if ($site)
            {
                $additionalName = $site->name;
            }
        } else
        {
            if ($model->name_hidden)
            {
                $additionalName = $model->name_hidden;
            }
        }

        if ($additionalName)
        {
            $result .= " [{$additionalName}]";
        }

        return $result;
    }



    public function registerAssets()
    {
        $options    = Json::encode([
            'id' => $this->id,
            'pjaxid' => $this->pjax->id
        ]);

        TreeWidgetAsset::register($this->getView());
        $this->getView()->registerJs(<<<JS

        (function(window, sx, $, _)
        {
            sx.createNamespace('classes.tree', sx);

            sx.classes.tree.CmsTreeWidget = sx.classes.Component.extend({

                _init: function()
                {
                    var self = this;
                },

                _onDomReady: function()
                {
                    var self = this;
                },
            });

            new sx.classes.tree.CmsTreeWidget({$options});

        })(window, sx, sx.$, sx._);
JS
    );

        $this->getView()->registerCss(<<<CSS


CSS
);
    }
}