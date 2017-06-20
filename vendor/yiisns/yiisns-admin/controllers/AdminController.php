<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 29.05.2016
 */
namespace yiisns\admin\controllers;

use yiisns\apps\helpers\UrlHelper;

use yiisns\admin\actions\AdminAction;
use yiisns\admin\components\UrlRule;
use yiisns\admin\controllers\helpers\ActionManager;
use yiisns\admin\filters\AccessControl;
use yiisns\admin\filters\AccessRule;
use yiisns\admin\filters\AdminAccessControl;
use yiisns\admin\filters\AdminLastActivityAccessControl;
use yiisns\admin\widgets\ControllerActions;
use yiisns\rbac\SnsManager;
use yiisns\kernel\base\Controller;

use yii\base\ActionEvent;
use yii\base\Event;
use yii\base\Exception;
use yii\base\InlineAction;
use yii\base\Model;
use yii\base\Theme;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\helpers\Inflector;
use yii\web\Application;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 *
 * @property string $permissionName Class AdminController
 * @package yiisns\admin\controllers
 */
abstract class AdminController extends Controller
{
    const LAYOUT_EMPTY = 'main-empty';

    const LAYOUT_MAIN = 'main';

    /**
     * 标题的名称
     * @var string
     */
    public $name = '';

    /**
     * 访问此控制器的权限的名称
     *
     * @return string
     */
    public function getPermissionName()
    {
        return $this->getUniqueId();
    }

    /**
     * 访问管理界面
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'adminAccess' => [
                'class' => AdminAccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [
                            SnsManager::PERMISSION_ADMIN_ACCESS
                        ]
                    ]
                ]
            ],
            
            'adminActionsAccess' => [
                'class' => AdminAccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        // 将matchCallback修改为denyCallback重复出现
                        // You are blocked because of a long inactivity on the site
                        'matchCallback' => function ($rule, $action) { 
                            if ($this->permissionName) {
                                if ($permission = \Yii::$app->authManager->getPermission($this->permissionName)) {
                                    if (! \Yii::$app->user->can($permission->name)) {
                                        return false;
                                    }
                                }
                            }
                            return true;
                        }
                    ]
                ]
            ],
            
            'adminLastActivityAccess' => [
                'class' => AdminLastActivityAccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if (\Yii::$app->user->identity->lastAdminActivityAgo > \Yii::$app->admin->blockedTime) {
                                return false;
                            }
                            
                            if (\Yii::$app->user->identity) {
                                \Yii::$app->user->identity->updateLastAdminActivity();
                            }
                            return true;
                        }
                    ]
                ]
            ]
        ];
    }

    public function init()
    {
        \Yii::$app->admin;
        
        parent::init();
        
        if (! $this->name) {
            $this->name = $this->id;
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
        if (! \Yii::$app->admin->requestIsAdmin) {
            throw new NotFoundHttpException('Request: ' . \Yii::$app->request->pathInfo . ' ip: ' . \Yii::$app->request->userIP);
        }
        
        \Yii::$app->view->theme = new Theme([
            'pathMap' => [
                '@app/views' => [
                    '@yiisns/admin/views'
                ]
            ]
        ]);
        
        $this->_initMetaData();
        $this->_initBreadcrumbsData();
        
        return parent::beforeAction($action);
    }

    /**
     * View title
     * 
     * @return $this
     */
    protected function _initMetaData()
    {
        $data = [];
        $data[] = \Yii::$app->name;
        $data[] = $this->name;
        
        if ($this->action && property_exists($this->action, 'name')) {
            $data[] = $this->action->name;
        }
        $this->view->title = implode(' - ', $data);
        return $this;
    }

    /**
     * Breadcrumbs
     * 
     * @return $this
     */
    protected function _initBreadcrumbsData()
    {
        $baseRoute = $this->module instanceof Application ? $this->id : ('/' . $this->module->id . '/' . $this->id);
        
        if ($this->name) {
            $this->view->params['breadcrumbs'][] = [
                'label' => $this->name,
                'url' => UrlHelper::constructCurrent()->setRoute($baseRoute . '/' . $this->defaultAction)
                    ->enableAdmin()
                    ->toString()
            ];
        }
        
        if ($this->action && property_exists($this->action, 'name')) {
            $this->view->params['breadcrumbs'][] = $this->action->name;
        }
        
        return $this;
    }
}