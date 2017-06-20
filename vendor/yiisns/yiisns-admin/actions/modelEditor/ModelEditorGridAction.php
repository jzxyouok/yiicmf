<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.05.2016
 */
namespace yiisns\admin\actions\modelEditor;

use yiisns\apps\helpers\UrlHelper;

use yiisns\kernel\models\Search;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\components\UrlRule;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\controllers\AdminController;
use yiisns\admin\widgets\ControllerActions;

use yii\authclient\AuthAction;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\web\Application;
use yii\web\ViewAction;

/**
 *
 * Class AdminModelsGridAction
 *
 * @package yiisns\admin\actions
 */
class ModelEditorGridAction extends AdminModelEditorAction
{
    /**
     *
     * @var string
     */
    public $modelSearchClassName = '';

    /**
     *
     * @var array
     */
    public $columns = [];

    /**
     *
     * @var array
     */
    public $gridConfig = [];

    /**
     *
     * @var callable
     */
    public $dataProviderCallback = null;

    public $filter = null;

    /**
     *
     * @return string
     */
    public function run()
    {
        $modelSeacrhClass = $this->modelSearchClassName;
        
        if (! $modelSeacrhClass) {
            $search = new Search($this->controller->modelClassName);
            $dataProvider = $search->search(\Yii::$app->request->queryParams);
            $searchModel = $search->loadedModel;
        } else {
            $searchModel = new $modelSeacrhClass();
            $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        }
        
        if ($this->dataProviderCallback && is_callable($this->dataProviderCallback)) {
            $dataProviderCallback = $this->dataProviderCallback;
            $dataProviderCallback($dataProvider);
        }
        
        // filter
        if ($this->filter && is_callable($this->filter)) {
            $filter = $this->filter;
            $filter($dataProvider, \Yii::$app->request->queryParams);
        }
        
        $gridConfig = [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'adminController' => $this->controller,
            'columns' => $this->columns
        ];
        
        $gridConfig = ArrayHelper::merge($gridConfig, $this->gridConfig);
        
        // var_dump($gridConfig);
        
        $this->viewParams = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'controller' => $this->controller,
            'columns' => $this->columns,
            'gridConfig' => $gridConfig
        ];
        
        return parent::run();
    }

    /**
     * Renders a view
     *
     * @param string $viewName  view name
     * @return string result of the rendering
     */
    protected function render($viewName)
    {
        $result = '';
        
        try {
            // If the template is not present in the standard way, or it's basic mistakes
            $result = parent::render($viewName);
        } catch (InvalidParamException $e) {
            if (! file_exists(\Yii::$app->view->viewFile)) {
                \Yii::warning($e->getMessage(), 'template-render');
                $result = $this->controller->render("@yiisns/admin/views/base-actions/grid-standart", (array) $this->viewParams);
            }
        }
        return $result;
    }
}