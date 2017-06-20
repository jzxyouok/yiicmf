<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.05.2016
 */
namespace yiisns\admin\actions\modelEditor;

use yiisns\apps\helpers\UrlHelper;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\kernel\models\Search;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\components\UrlRule;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\controllers\AdminController;
use yiisns\admin\filters\AdminAccessControl;
use yiisns\admin\widgets\ControllerActions;
use yiisns\admin\widgets\GridViewStandart;
use yiisns\rbac\SnsManager;

use yii\authclient\AuthAction;
use yii\base\View;
use yii\behaviors\BlameableBehavior;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\Application;
use yii\web\ViewAction;

/**
 *
 * @property AdminModelEditorController
 *          
 * Class AdminModelsGridAction
 * @package yiisns\admin\actions
 */
class AdminMultiModelEditAction extends AdminModelEditorAction
{
    public $options = [];

    public function init()
    {
        parent::init();
        
        $this->method = 'post';
        $this->request = 'ajax';
    }

    /**
     *
     * @var array
     */
    public $models = [];

    /**
     * processor model
     *
     * @var callable
     */
    public $eachCallback = null;

    public function run()
    {
        $rr = new RequestResponse();
        
        $pk = \Yii::$app->request->post($this->controller->requestPkParamName);
        $modelClass = $this->controller->modelClassName;
        
        $this->models = $modelClass::find()->where([
            $this->controller->modelPkAttribute => $pk
        ])->all();
        
        if (! $this->models) {
            $rr->success = false;
            $rr->message = \Yii::t('yiisns/kernel', 'No records found');
            return (array) $rr;
        }
        
        $data = [];
        foreach ($this->models as $model) {
            $raw = [];
            if ($this->eachExecute($model)) {
                $data['success'] = ArrayHelper::getValue($data, 'success', 0) + 1;
            } else {
                $data['errors'] = ArrayHelper::getValue($data, 'errors', 0) + 1;
            }
        }
        
        $rr->success = true;
        $rr->message = \Yii::t('yiisns/kernel', 'Mission complete');
        $rr->data = $data;
        return (array) $rr;
    }

    /**
     *
     * @param $model
     * @return bool
     */
    public function eachExecute($model)
    {
        $action = null;
        
        if ($this->eachCallback && is_callable($this->eachCallback)) {
            $callback = $this->eachCallback;
            return $callback($model, $action);
        }
        
        return true;
    }

    /**
     *
     * @param GridView $grid            
     * @return string
     */
    public function registerForGrid(GridViewStandart $grid)
    {
        $clientOptions = Json::encode($this->getClientOptions());
        
        $grid->view->registerJs(<<<JS
(function(sx, $, _)
{
    new sx.classes.grid.MultiAction({$grid->gridJsObject}, '{$this->id}' ,{$clientOptions});
})(sx, sx.$, sx._);
JS
);
        return "";
    }

    public function getClientOptions()
    {
        return [
            'id' => $this->id,
            'url' => (string) $this->url,
            'confirm' => $this->confirm,
            'method' => $this->method,
            'request' => $this->request
        ];
    }
}