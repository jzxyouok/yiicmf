<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.08.2016
 */
namespace yiisns\rbac\widgets\adminPermissionForRoles;

use yiisns\apps\helpers\UrlHelper;
use yiisns\admin\components\UrlRule;
use yiisns\rbac\SnsManager;
use yiisns\rbac\widgets\adminPermissionForRoles\assets\AdminPermissionForRolesWidgetAsset;
use yii\base\Widget;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\rbac\Permission;

/**
 *
 * @property Permission $permission
 * @property array $permissionRoles Class AdminPermissionForRolesWidget
 *          
 * @package yiisns\kernel\rbac\widgets\adminPermissionForRoles
 */
class AdminPermissionForRolesWidget extends Widget
{
    public static $autoIdPrefix = 'AdminPermissionForRolesWidget';

    /**
     *
     * @var string a privilege to nominate, and configure.
     */
    public $permissionName = '';

    public $permissionDescription = '';

    public $label = '';

    public $items = [];

    public $notClosedRoles = [
        SnsManager::ROLE_ROOT
    ];

    /**
     *
     * @var bool check the clearance and to establish if it is not.
     */
    public $createPermission = true;

    public function init()
    {
        parent::init();
        
        if (! $this->items) {
            $this->items = \yii\helpers\ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
        }
        
        $permission = \Yii::$app->authManager->getPermission($this->permissionName);
        
        if ($this->createPermission && ! $permission) {
            $permission = \Yii::$app->authManager->createPermission($this->permissionName);
            $permission->description = $this->permissionDescription;
            
            \Yii::$app->authManager->add($permission);
        }
        
        if ($this->notClosedRoles && $permission) {
            foreach ($this->notClosedRoles as $roleName) {
                if ($role = \Yii::$app->authManager->getRole($roleName)) {
                    if (! \Yii::$app->authManager->hasChild($role, $permission)) {
                        \Yii::$app->authManager->addChild($role, $permission);
                    }
                }
            }
        }
    }

    public function run()
    {
        AdminPermissionForRolesWidgetAsset::register($this->view);
        
        return $this->render('permission-for-roles', [
            'widget' => $this
        ]);
    }

    /**
     *
     * @return string
     */
    public function getClientOptionsJson()
    {
        return Json::encode([
            'id' => $this->id,
            'permissionName' => $this->permissionName,
            'notClosedRoles' => $this->notClosedRoles,
            'backend' => Url::to([
                '/rbac/admin-permission/permission-for-role',
                UrlRule::ADMIN_PARAM_NAME => UrlRule::ADMIN_PARAM_VALUE
            ])
        ]);
    }

    /**
     *
     * @return \yii\rbac\Permission
     */
    public function getPermission()
    {
        return \Yii::$app->authManager->getPermission($this->permissionName);
    }

    /**
     *
     * @return array
     */
    public function getPermissionRoles()
    {
        $result = [];
        
        if ($roles = \Yii::$app->authManager->getRoles()) {
            foreach ($roles as $role) {
                if (\Yii::$app->authManager->hasChild($role, $this->permission)) {
                    $result[] = $role->name;
                }
            }
        }
        
        return $result;
    }
}