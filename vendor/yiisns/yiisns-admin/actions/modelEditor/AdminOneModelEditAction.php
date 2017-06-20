<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.05.2016
 */
namespace yiisns\admin\actions\modelEditor;

use yiisns\apps\helpers\ComponentHelper;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\Search;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\components\UrlRule;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\controllers\AdminController;
use yiisns\admin\filters\AdminAccessControl;
use yiisns\admin\widgets\ControllerActions;
use yiisns\rbac\SnsManager;
use yii\authclient\AuthAction;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Inflector;
use yii\web\Application;
use yii\web\ViewAction;

/**
 *
 * @property AdminModelEditorController $controller Class AdminModelsGridAction
 * @package yiisns\admin\actions
 */
class AdminOneModelEditAction extends AdminModelEditorAction
{
    public function init()
    {
        parent::init();
        
        $this->controller->attachBehavior('accessCreate', [
            'class' => AdminAccessControl::className(),
            'only' => [
                $this->id
            ],
            'rules' => [
                [
                    'allow' => true,
                    'matchCallback' => [
                        $this,
                        'checkUpdateAccess'
                    ]
                ]
            ]
        ]);
    }

    protected function beforeRun()
    {
        if (parent::beforeRun()) {
            if (! $this->controller->model) {
                $this->controller->redirect($this->controller->indexUrl);
                return false;
            }
            
            return true;
        }
    }

    public function run()
    {
        if ($this->callback) {
            return $this->runCallback();
        }
        
        if (! $this->controller->model) {
            return $this->controller->redirect($this->controller->indexUrl);
        }
        
        return parent::run();
    }

    /**
     *
     * @return UrlHelper
     */
    public function getUrl()
    {
        $url = parent::getUrl();
        $url->set($this->controller->requestPkParamName, $this->controller->model->{$this->controller->modelPkAttribute});
        return $url;
    }

    /**
     *
     * @return bool
     */
    public function isVisible()
    {
        if (! parent::isVisible()) {
            return false;
        }
        
        return $this->checkUpdateAccess();
    }

    public function checkUpdateAccess()
    {
        $model = $this->controller->model;
        if (ComponentHelper::hasBehavior($model, BlameableBehavior::className())) {
            if ($permission = \Yii::$app->authManager->getPermission(SnsManager::PERMISSION_ALLOW_MODEL_UPDATE)) {
                if (! \Yii::$app->user->can($permission->name, [
                    'model' => $this->controller->model
                ])) {
                    return false;
                }
            }
        } else {
            if ($permission = \Yii::$app->authManager->getPermission(SnsManager::PERMISSION_ALLOW_MODEL_UPDATE)) {
                if (! \Yii::$app->user->can($permission->name)) {
                    return false;
                }
            }
        }
        
        return true;
    }
}