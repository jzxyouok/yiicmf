<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 12.03.2016
 */
namespace yiisns\admin\widgets;

use yiisns\kernel\base\AppCore;
use yiisns\admin\controllers\AdminModelEditorController;

use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 * Class RelatedModelsGrid
 * @package yiisns\admin\widgets
 */
class RelatedModelsGrid extends Widget
{
    /**
     * @var null 管理链接模型的控制器
     */
    public $controllerRoute         = null;

    public $namespace               = null;

    /**
     * @var string 添加链接的模型操作
     */
    public $controllerCreateAction      = 'create';
    public $controllerSortableAction  = 'sortable-priority';

    /**
     * @var string название
     */
    public $label  = '';

    /**
     * @var string
     */
    public $hint    = '';

    /**
     * @var array
     */
    public $gridViewOptions  = [];

    /**
     * @var array связь
     */
    public $relation  = [];

    /**
     * @var array
     */
    public $sort = [];

    /**
     * @var callback
     */
    public $dataProviderCallback = null;

    public $parentModel  = null;

    public function init()
    {
        parent::init();

        if ($this->namespace === null)
        {
            $id = [];
            if (\Yii::$app->controller)
            {
                $id = [\Yii::$app->controller->getUniqueId()];
            }

            if (\Yii::$app->controller->action)
            {
                $id = [\Yii::$app->controller->action->getUniqueId()];
            }

            if ($this->controllerRoute)
            {
                $id[] = $this->controllerRoute;
            }

            if ($this->parentModel)
            {
                $id[] = $this->parentModel->className();
            }

            $this->namespace = md5(serialize($id));
        }
    }

    public function run()
    {
        if ($this->parentModel->isNewRecord)
        {
            return '';
        }

        /**
         * @var $controller AdminModelEditorController
         */
        $controller = \Yii::$app->createController($this->controllerRoute)[0];

        $rerlation = [];
        foreach ($this->relation as $relationLink => $parent)
        {
            if ($this->parentModel->getAttribute($parent))
            {
                $rerlation[$relationLink] = $this->parentModel->{$parent};
            } else
            {
                $rerlation[$relationLink] = $parent;
            }
        }

        $createUrl = \yiisns\apps\helpers\UrlHelper::construct($this->controllerRoute . '/' . $this->controllerCreateAction, $rerlation)
                ->setSystemParam(\yiisns\admin\Module::SYSTEM_QUERY_EMPTY_LAYOUT, 'true')
                ->setSystemParam(\yiisns\admin\Module::SYSTEM_QUERY_NO_ACTIONS_MODEL, 'true')
                ->enableAdmin()->toString();


        $sortableUrl = \yiisns\apps\helpers\UrlHelper::construct($this->controllerRoute . '/' . $this->controllerSortableAction)
                ->enableAdmin()->toString();


        $search = new \yiisns\kernel\models\Search($controller->modelClassName);
        $search->getDataProvider()->query->where($rerlation);

        if (isset($this->sort['defaultOrder']))
        {
            $search->getDataProvider()->sort->defaultOrder = $this->sort['defaultOrder'];
        }

        if ($this->dataProviderCallback && is_callable($this->dataProviderCallback))
        {
            $function = $this->dataProviderCallback;
            $function($search->getDataProvider());
        }

        $pjaxId = "sx-table-" . md5($this->label . $this->hint . $this->parentModel->className());
        $gridOptions = ArrayHelper::merge([
            /*'filterModel'   => $search,*/
            'pjaxOptions' => [
                'id' => $pjaxId
            ],
            'autoColumns' => false,
            /*"settingsData" =>
            [
                'enabledPjaxPagination' => AppCore::BOOL_Y
            ],*/
            "sortableOptions" => [
                'backend' => $sortableUrl
            ],
            'dataProvider'  => $search->getDataProvider(),
            'layout' => "\n{beforeTable}\n{items}\n{afterTable}\n{pager}",
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],
                [
                    'class'                 => \yiisns\admin\grid\ActionColumn::className(),
                    'controller'            => $controller,
                    'isOpenNewWindow'       => true
                ],
            ],
        ], (array) $this->gridViewOptions);

        //TODO:: Bad hardcode
        if (ArrayHelper::getValue($gridOptions, 'sortable') === true)
        {
            $gridOptions['settingsData'] = [
                'pageSize' => 100,
                'orderBy' => 'priority',
                'order' => SORT_ASC,
            ];
        }

        return $this->render('related-models-grid',[
            'widget'        => $this,
            'createUrl'     => $createUrl,
            'controller'    => $controller,
            'gridOptions'   => $gridOptions,
            'pjaxId'        => $pjaxId,
        ]);
    }
}