<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.04.2016
 */
namespace yiisns\rbac\controllers;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\admin\controllers\AdminController;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\actions\modelEditor\AdminOneModelEditAction;

use yiisns\rbac\models\AuthItem;
use yiisns\rbac\models\searchs\AuthItem as AuthItemSearch;
use yiisns\rbac\SnsManager;
use yii\helpers\ArrayHelper;
use yii\rbac\Permission;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\rbac\Item;
use Yii;
use yii\web\Response;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/**
 * AuthItemController implements the CRUD actions for AuthItem model.
 */
class AdminPermissionController extends AdminModelEditorController
{
    public function init()
    {
        $this->name                   = \Yii::t('yiisns/rbac', 'Privileges management');
        $this->modelShowAttribute      = 'name';
        $this->modelPkAttribute         = 'name';
        $this->modelClassName          = Permission::className();
        parent::init();
    }
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'index' =>
            [
                'class'     => AdminAction::className(),
                'callback'  => [$this, 'actionIndex']
            ],
            'view' =>
            [
                'class'     => AdminOneModelEditAction::className(),
                'name'      => 'View',
                'icon'      => 'glyphicon glyphicon-eye-open',
                'callback'  => [$this, 'actionView'],
            ],
            'create' =>
            [
                'class'         => AdminAction::className(),
                'callback'      => [$this, 'actionCreate']
            ],
            'update-data' =>
            [
                'class'         => AdminAction::className(),
                'name'          => \Yii::t('yiisns/rbac', 'Update privileges'),
                'icon'          => 'glyphicon glyphicon-retweet',
                'method'        => 'post',
                'request'       => 'ajax',
                'callback'      => [$this, 'actionUpdateData']
            ],
        ]);
    }
    /**
     * @return Role
     * @throws NotFoundHttpException
     */
    public function getModel()
    {
        if ($this->_model === null)
        {
            if ($pk = \Yii::$app->request->get($this->requestPkParamName))
            {
                $this->_model = $this->findModel($pk);
            }
        }
        return $this->_model;
    }
    public function actionUpdateData()
    {
        $rr = new RequestResponse();
        if ($rr->isRequestAjaxPost())
        {
            $auth = Yii::$app->authManager;
            foreach (\Yii::$app->admin->menu->getData() as $group)
            {
                if (is_array($group))
                {
                    foreach ($group['items'] as $itemData)
                    {
                        if (is_array($itemData))
                        {
                            /**
                             * @var $controller \yii\web\Controller
                             */
                            list($controller, $route) = \Yii::$app->createController(@$itemData['url'][0]);

                            if ($controller)
                            {
                                if ($controller instanceof AdminController)
                                {
                                    if (!$adminAccess = $auth->getPermission($controller->permissionName))
                                    {
                                        $adminAccess = $auth->createPermission($controller->permissionName);
                                        $adminAccess->description = \Yii::t('yiisns/rbac', 'Administration') . ' | ' . $controller->name;
                                        $auth->add($adminAccess);
                                        if ($root = $auth->getRole('root'))
                                        {
                                            $auth->addChild($root, $adminAccess);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $rr->success = true;
            $rr->message = \Yii::t('yiisns/rbac', 'Update completed');
            return $rr;
        }
        return [];
    }
    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch(['type' => Item::TYPE_PERMISSION]);
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'controller' => $this,
        ]);
    }
    /**
     * Displays a single AuthItem model.
     * @param string $id
     * @return mixed
     */
    public function actionView()
    {
        $model = $this->model;
        $id = $model->name;
        $model = $this->findModel($id);
        $authManager = Yii::$app->getAuthManager();
        $avaliable = $assigned = [
            'Permission' => [],
            'Routes' => [],
        ];
        $children = array_keys($authManager->getChildren($id));
        $children[] = $id;
        foreach ($authManager->getPermissions() as $name => $role) {
            if (in_array($name, $children)) {
                continue;
            }
            if (isset($name[0]))
            {
                $avaliable[$name[0] === '/' ? 'Routes' : 'Permission'][$name] = $name . ' — ' . $role->description;
            }
        }
        foreach ($authManager->getChildren($id) as $name => $child) {
            $assigned[$name[0] === '/' ? 'Routes' : 'Permission'][$name] = $name . ' — ' . $child->description;;
        }
        $avaliable = array_filter($avaliable);
        $assigned = array_filter($assigned);
        return $this->render('view', ['model' => $model, 'avaliable' => $avaliable, 'assigned' => $assigned]);
    }
    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItem(null);
        $model->type = Item::TYPE_PERMISSION;
        if (\Yii::$app->request->isAjax && !\Yii::$app->request->isPjax)
        {
            $model->load(\Yii::$app->request->post());
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', ['model' => $model,]);
        }
    }
    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param  string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->model;
        $id = $model->name;
        $model = $this->findModel($id);
        if (\Yii::$app->request->isAjax && !\Yii::$app->request->isPjax)
        {
            $model->load(\Yii::$app->request->post());
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if (\Yii::$app->request->isAjax)
        {
            if ($model->load(\Yii::$app->request->post()) && $model->save())
            {
                \Yii::$app->getSession()->setFlash('success', \Yii::t('yiisns/rbac', 'Saved successfully'));
            } else
            {
                \Yii::$app->getSession()->setFlash('error', \Yii::t('yiisns/rbac', 'Failed to save'));
            }
        }
        return $this->render('update', ['model' => $model,]);
    }
    /**
     * Deletes an existing Game model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        $rr = new RequestResponse();
        if ($rr->isRequestAjaxPost())
        {
            try
            {
                $model  = $this->model;
                $id     = $model->name;
                $model  = $this->findModel($id);
                if (!in_array($model->item->name, SnsManager::protectedPermissions()))
                {
                    if (\Yii::$app->getAuthManager()->remove($model->item))
                    {
                        $rr->message = \Yii::t('yiisns/rbac', 'Record deleted successfully');
                        $rr->success = true;
                    } else
                    {
                        $rr->message = \Yii::t('yiisns/rbac', 'Record deleted unsuccessfully');
                        $rr->success = false;
                    }
                } else
                {
                    $rr->message = \Yii::t('yiisns/rbac', 'This entry can not be deleted!');
                    $rr->success = false;
                }
            } catch (\Exception $e)
            {
                $rr->message = $e->getMessage();
                $rr->success = false;
            }
            return (array) $rr;
        }
    }
    /**
     * Assign or remove items
     * @param string $id
     * @param string $action
     * @return array
     */
    public function actionAssign($id, $action)
    {
        $post = Yii::$app->getRequest()->post();
        $roles = $post['roles'];
        $manager = Yii::$app->getAuthManager();
        $parent = $manager->getPermission($id);
        $error = [];
        if ($action == 'assign') {
            foreach ($roles as $role) {
                $child = $manager->getPermission($role);
                try {
                    $manager->addChild($parent, $child);
                } catch (\Exception $exc) {
                    $error[] = $exc->getMessage();
                }
            }
        } else {
            foreach ($roles as $role) {
                $child = $manager->getPermission($role);
                try {
                    $manager->removeChild($parent, $child);
                } catch (\Exception $exc) {
                    $error[] = $exc->getMessage();
                }
            }
        }
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;
        return [$this->actionRoleSearch($id, 'avaliable', $post['search_av']),
            $this->actionRoleSearch($id, 'assigned', $post['search_asgn']),
            $error];
    }
    /**
     * Search role
     * @param string $id
     * @param string $target
     * @param string $term
     * @return array
     */
    public function actionRoleSearch($id, $target, $term = '')
    {
        $result = [
            'Permission' => [],
            'Routes' => [],
        ];
        $authManager = Yii::$app->getAuthManager();
        if ($target == 'avaliable') {
            $children = array_keys($authManager->getChildren($id));
            $children[] = $id;
            foreach ($authManager->getPermissions() as $name => $role) {
                if (in_array($name, $children)) {
                    continue;
                }
                if (empty($term) or strpos($name, $term) !== false) {
                    $result[$name[0] === '/' ? 'Routes' : 'Permission'][$name] = $name;
                }
            }
        } else {
            foreach ($authManager->getChildren($id) as $name => $child) {
                if (empty($term) or strpos($name, $term) !== false) {
                    $result[$name[0] === '/' ? 'Routes' : 'Permission'][$name] = $name;
                }
            }
        }
        return Html::renderSelectOptions('', array_filter($result));
    }
    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  string        $id
     * @return AuthItem      the loaded model
     * @throws HttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $item = Yii::$app->getAuthManager()->getPermission($id);
        if ($item) {
            return new AuthItem($item);
        } else {
            throw new NotFoundHttpException(\Yii::t('yiisns/rbac', 'The requested page does not exist.'));
        }
    }

    /**
     * @return string
     */
    public function actionPermissionForRole()
    {
        $rr = new RequestResponse();

        if (!$permissionName = \Yii::$app->request->post('permissionName'))
        {
            $rr->success = false;
            $rr->message = \Yii::t('yiisns/rbac', 'Invalid parameters');
            return $rr;
        }

        $permission = \Yii::$app->authManager->getPermission($permissionName);
        if (!$permission)
        {
            $rr->success = false;
            $rr->message = \Yii::t('yiisns/rbac', 'Privilege not found');
            return $rr;
        }

        $rolesValues = (array) \Yii::$app->request->post('roles');
        ///$rolesValues[] = SnsManager::ROLE_ROOT;

        foreach (\Yii::$app->authManager->getRoles() as $role)
        {
            if (in_array($role->name, $rolesValues))
            {
                if (!\Yii::$app->authManager->hasChild($role, $permission))
                {
                    \Yii::$app->authManager->addChild($role, $permission);
                }
            } else
            {
                if (\Yii::$app->authManager->hasChild($role, $permission))
                {
                    \Yii::$app->authManager->removeChild($role, $permission);
                }
            }

            $rr->message = \Yii::t('yiisns/rbac', 'Access rights saved');
            $rr->success = true;
        }

        return $rr;
    }
}