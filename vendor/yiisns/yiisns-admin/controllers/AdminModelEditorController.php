<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.10.2016
 * @since 2.0.0
 */
namespace yiisns\admin\controllers;

use yiisns\apps\base\widgets\ActiveForm;
use yiisns\apps\components\AppSettings;
use yiisns\apps\Exception;
use yiisns\apps\helpers\UrlHelper;
use yiisns\apps\helpers\ComponentHelper;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\kernel\models\Search;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\actions\AdminModelAction;
use yiisns\admin\actions\modelEditor\AdminModelEditorCreateAction;
use yiisns\admin\actions\modelEditor\AdminModelEditorUpdateAction;
use yiisns\admin\actions\modelEditor\AdminMultiModelEditAction;
use yiisns\admin\actions\modelEditor\AdminOneModelEditAction;
use yiisns\admin\actions\modelEditor\AdminOneModelUpdateAction;
use yiisns\admin\actions\modelEditor\ModelEditorGridAction;
use yiisns\admin\components\UrlRule;
use yiisns\admin\controllers\helpers\Action;
use yiisns\admin\controllers\helpers\ActionModel;
use yiisns\admin\controllers\helpers\rules\HasModel;
use yiisns\admin\controllers\helpers\rules\NoModel;
use yiisns\admin\filters\AdminAccessControl;
use yiisns\admin\widgets\ControllerActions;
use yiisns\admin\widgets\ControllerModelActions;
use yiisns\rbac\SnsManager;

use yii\base\ActionEvent;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\behaviors\BlameableBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\web\Application;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 *
 * @property string $indexUrl
 * @property AdminAction[] $actions
 * @property \yii\db\ActiveRecord $model Class AdminModelEditorController
 * @property string $name
 * @package yiisns\admin\controllers
 */
class AdminModelEditorController extends AdminController
{
    /**
     * @example ActiveRecord::className();
     * @see _ensure()
     * @var string
     */
    public $modelClassName;

    /**
     * management model for the default.
     *
     * @var string
     */
    public $modelDefaultAction = 'update';

    /**
     * Attribute model, which will be shown in the breadcrumbs back, and the title page.
     *
     * @var string
     */
    public $modelShowAttribute = 'id';

    /**
     * PK will be used for the search model.
     *
     * @var string
     */
    public $modelPkAttribute = 'id';

    /**
     * Name of the parameter in the query PK.
     *
     * @var string
     */
    public $requestPkParamName = 'pk';

    /**
     *
     * @var null|AdminMultiModelEditAction[]
     */
    protected $_multiActions = null;

    /**
     *
     * @var ActiveRecord
     */
    protected $_model = null;

    /**
     *
     * @return array
     */
    public function behaviors()
    {
        $behaviors = ArrayHelper::merge(parent::behaviors(), [
            
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => [
                        'post'
                    ],
                    'delete-multi' => [
                        'post'
                    ]
                ]
            ],
            
            'accessDelete' => [
                'class' => AdminAccessControl::className(),
                'only' => [
                    'delete'
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if (ComponentHelper::hasBehavior($this->model, BlameableBehavior::className())) {
                                if ($permission = \Yii::$app->authManager->getPermission(SnsManager::PERMISSION_ALLOW_MODEL_DELETE)) {
                                    if (! \Yii::$app->user->can($permission->name, [
                                        'model' => $this->model
                                    ])) {
                                        return false;
                                    }
                                }
                            }
                            
                            return true;
                        }
                    ]
                ]
            ]
        ]);
        
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'index' => [
                'class' => ModelEditorGridAction::className(),
                'name' => \Yii::t('yiisns/kernel', 'List'),
                'icon' => 'glyphicon glyphicon-th-list',
                'priority' => 10
            ],
            
            'create' => [
                'class' => AdminModelEditorCreateAction::className(),
                'name' => \Yii::t('yiisns/kernel', 'Add'),
                'icon' => 'glyphicon glyphicon-plus'
            ],
            
            'update' => [
                'class' => AdminOneModelUpdateAction::className(),
                'name' => \Yii::t('yiisns/kernel', 'Edit'),
                'icon' => 'glyphicon glyphicon-pencil',
                'priority' => 10
            ],
            
            'delete' => [
                'class' => AdminOneModelEditAction::className(),
                'name' => \Yii::t('yiisns/kernel', 'Delete'),
                'icon' => 'glyphicon glyphicon-trash',
                'confirm' => \Yii::t('yiisns/kernel', 'Are you sure you want to delete this item?'),
                'method' => 'post',
                'request' => 'ajax',
                'callback' => [
                    $this,
                    'actionDelete'
                ],
                'priority' => 99999
            ],
            
            'delete-multi' => [
                'class' => AdminMultiModelEditAction::className(),
                'name' => \Yii::t('yiisns/kernel', 'Delete'),
                'icon' => 'glyphicon glyphicon-trash',
                'confirm' => \Yii::t('yiisns/kernel', 'Are you sure you want to permanently delete the selected items?'),
                'eachCallback' => [
                    $this,
                    'eachMultiDelete'
                ],
                'priority' => 99999
            ]
        ]);
    }

    /**
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        
        $this->_ensure();
    }

    /**
     *
     * @throws InvalidConfigException
     */
    protected function _ensure()
    {
        if (! $this->modelClassName) {
            throw new InvalidConfigException(\Yii::t('yiisns/kernel', "For {modelname} must specify the model class", [
                'modelname' => 'AdminModelEditorController'
            ]));
        }
        
        if (! class_exists($this->modelClassName)) {
            throw new InvalidConfigException("{$this->modelClassName} " . \Yii::t('yiisns/kernel', 'the class is not found, you must specify the existing class model'));
        }
    }

    /**
     *
     * @param \yii\base\Action $action            
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->_initActionsData();
        
        return parent::beforeAction($action);
    }

    /**
     *
     * @return ActiveRecord
     * @throws NotFoundHttpException
     */
    public function getModel()
    {
        if ($this->_model === null) {
            $pk = \Yii::$app->request->get($this->requestPkParamName);
            
            if ($pk) {
                $modelClass = $this->modelClassName;
                $this->_model = $modelClass::findOne($pk);
            }
        }
        
        return $this->_model;
    }

    /**
     *
     * @param ActiveRecord $model            
     * @return $this
     */
    public function setModel($model)
    {
        $this->_model = $model;
        $this->_actions = null;
        return $this;
    }

    /**
     *
     * @return array|null|\yiisns\admin\actions\modelEditor\AdminMultiModelEditAction[]
     */
    public function getMultiActions()
    {
        if ($this->_multiActions !== null) {
            return $this->_multiActions;
        }
        
        $actions = $this->actions();
        
        if ($actions) {
            foreach ($actions as $id => $data) {
                $action = $this->createAction($id);
                
                if ($action instanceof AdminMultiModelEditAction) {
                    if ($action->isVisible()) {
                        $this->_multiActions[$id] = $action;
                    }
                }
            }
        } else {
            $this->_multiActions = [];
        }
        
        if ($this->_multiActions) {
            ArrayHelper::multisort($this->_multiActions, 'priority');
        }
        
        return $this->_multiActions;
    }

    /**
     *
     * @return $this
     */
    protected function _initActionsData()
    {
        if (count($this->actions) > 1) {
            $this->view->params['actions'] = ControllerActions::begin([
                'activeActionId' => $this->action->id,
                'controller' => $this
            ])->run();
        }
        
        return $this;
    }

    /**
     *
     * @return $this
     */
    protected function _initMetaData()
    {
        $data = [];
        $data[] = \Yii::$app->name;
        $data[] = $this->name;
        
        if ($this->model) {
            if ($this->action instanceof AdminOneModelEditAction) {
                $data[] = $this->model->{$this->modelShowAttribute};
            }
        }
        
        if ($this->action && property_exists($this->action, 'name')) {
            $data[] = $this->action->name;
        }
        
        $this->view->title = implode(' - ', $data);
        return $this;
    }

    /**
     *
     * @return $this
     */
    protected function _initBreadcrumbsData()
    {
        $baseRoute = $this->module instanceof Application ? "/" . $this->id : ("/" . $this->module->id . "/" . $this->id);
        
        if ($this->name) {
            $this->view->params['breadcrumbs'][] = [
                'label' => $this->name,
                'url' => UrlHelper::constructCurrent()->setRoute($baseRoute . '/' . $this->defaultAction)
                    ->enableAdmin()
                    ->toString()
            ];
        }
        
        if ($this->action instanceof AdminOneModelEditAction && $this->model) {
            $this->view->params['breadcrumbs'][] = [
                'label' => $this->model->{$this->modelShowAttribute},
                'url' => UrlHelper::constructCurrent()->setRoute($baseRoute . '/' . $this->modelDefaultAction)
                    ->set($this->requestPkParamName, $this->model->{$this->modelPkAttribute})
                    ->enableAdmin()
                    ->normalizeCurrentRoute()
                    ->toString()
            ];
        }
        
        if ($this->action && property_exists($this->action, 'name')) {
            $this->view->params['breadcrumbs'][] = $this->action->name;
        }
        
        return $this;
    }

    /**
     *
     * @var null|AdminAction[]
     */
    protected $_actions = null;

    /**
     * 
     * @see ControllerActions
     * @return AdminAction[]
     */
    public function getActions()
    {
        if ($this->_actions !== null) {
            return $this->_actions;
        }
        
        $actions = $this->actions();
        
        if ($actions) {
            foreach ($actions as $id => $data) {
                $action = $this->createAction($id);
                
                if ($this->model) {
                    if ($action instanceof AdminOneModelEditAction) {
                        if ($action->isVisible()) {
                            $this->_actions[$id] = $action;
                        }
                    }
                } else {
                    if (! $action instanceof AdminOneModelEditAction && ! $action instanceof AdminMultiModelEditAction) {
                        if ($action->isVisible()) {
                            $this->_actions[$id] = $action;
                        }
                    }
                }
            }
        } else {
            $this->_actions = [];
        }
        
        if ($this->_actions) {
            ArrayHelper::multisort($this->_actions, 'priority');
        }
        
        return $this->_actions;
    }

    /**
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    public function actionDelete()
    {
        $rr = new RequestResponse();
        
        if ($rr->isRequestAjaxPost()) {
            try {
                if ($this->model->delete()) {
                    $rr->message = \Yii::t('yiisns/kernel', 'Record deleted successfully');
                    $rr->success = true;
                } else {
                    $rr->message = \Yii::t('yiisns/kernel', 'Record deleted unsuccessfully');
                    $rr->success = false;
                }
            } catch (\Exception $e) {
                $rr->message = $e->getMessage();
                $rr->success = false;
            }
            
            return (array) $rr;
        }
    }

    /**
     *
     * @param $model
     * @param $action
     * @return bool
     */
    public function eachMultiDelete($model, $action)
    {
        try {
            return $model->delete();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     *
     * @return string
     */
    public function getIndexUrl()
    {
        return UrlHelper::construct('/' . $this->id . '/' . $this->action->id)->enableAdmin()
            ->setRoute($this->defaultAction)
            ->normalizeCurrentRoute()
            ->toString();
    }

    /**
     *
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionSortablePriority()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            
            if ($keys = \Yii::$app->request->post('keys')) {
                // $counter = count($keys);
                
                foreach ($keys as $counter => $key) {
                    $priority = ($counter + 1) * 1000;
                    
                    $modelClassName = $this->modelClassName;
                    $model = $modelClassName::findOne($key);
                    if ($model) {
                        $model->priority = $priority;
                        $model->save(false);
                    }
                    
                    // $counter = $counter - 1;
                }
            }
            
            return [
                'success' => true,
                'message' => \Yii::t('yiisns/kernel', 'Changes saved')
            ];
        }
    }
}