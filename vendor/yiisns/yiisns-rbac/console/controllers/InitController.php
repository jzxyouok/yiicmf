<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.04.2016
 */
namespace yiisns\rbac\console\controllers;

use yiisns\kernel\models\User;
use yiisns\admin\components\UrlRule;
use yiisns\admin\controllers\AdminController;
use yiisns\rbac\AuthorRule;
use yiisns\rbac\SnsManager;
use Yii;
use yii\base\Exception;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\rbac\Rule;

/**
 * Setting permissions
 *
 * Class RbacController
 * 
 * @package yiisns\kernel\controllers
 */
class InitController extends Controller
{
    /**
     *
     * @var string the default command action.
     */
    public $defaultAction = 'init';

    public function actionInit()
    {
        $this->initRbacModules();
        $this->initAdminData();
        $this->initRootAssigning();
        $this->initRootUser();
    }

    public function actionViewConfig()
    {
        $this->loadConfig();
    }

    public function initRootAssigning()
    {
        $roleRoot = \Yii::$app->authManager->getRole(SnsManager::ROLE_ROOT);
        foreach (\Yii::$app->authManager->getPermissions() as $permission) {
            $this->stdout("\t\tassign root permisssion: " . $permission->name);
            try {
                \Yii::$app->authManager->addChild($roleRoot, $permission);
                $this->stdout(' - success' . "\n");
            } catch (\Exception $e) {
                $this->stdout(' - already exist' . "\n");
            }
        }
        ;
        foreach (\Yii::$app->authManager->getRoles() as $role) {
            $this->stdout("\t\tassign root role: " . $role->name);
            try {
                \Yii::$app->authManager->addChild($roleRoot, $role);
                $this->stdout(' - success' . "\n");
            } catch (\Exception $e) {
                $this->stdout(' - already exist' . "\n");
            }
        }
        ;
    }

    public function initRbacModules()
    {
        $this->stdout("Init rules, permissions adn data from all modules and extensions\n\n", Console::BOLD);
        $this->stdout("1) Loading config\n", Console::FG_YELLOW);
        if (! $config = $this->loadConfig()) {
            $this->stdout("Start script: not found data for rbac migrations", Console::FG_RED);
            die();
        }
        $this->stdout("2) Start migrations\n", Console::FG_YELLOW);
        $this->applyConfig($config);
        $this->stdout("3) Assigning roles, privileges, rules\n", Console::FG_YELLOW);
        $this->applyAssigningConfig($config);
    }

    /**
     *
     * @param
     *            $config
     * @return bool
     */
    protected function _applyRule($config)
    {
        if (! is_array($config)) {
            return false;
        }
        if (! $calssName = ArrayHelper::getValue($config, 'class')) {
            return false;
        }
        if (! class_exists($calssName)) {
            return false;
        }
        $rule = new $calssName();
        if (! $rule instanceof Rule) {
            return false;
        }
        if ($ruleExist = \Yii::$app->authManager->getRule($rule->name)) {
            return $ruleExist;
        }
        if (\Yii::$app->authManager->add($rule)) {
            return $rule;
        }
        return false;
    }

    /**
     *
     * @param
     *            $config
     * @return bool
     */
    protected function _assignRole($config)
    {
        if (! is_array($config)) {
            return false;
        }
        if (! $name = ArrayHelper::getValue($config, 'name')) {
            return false;
        }
        if (! $child = ArrayHelper::getValue($config, 'child')) {
            return false;
        }
        if (! $role = \Yii::$app->authManager->getRole($name)) {
            return false;
        }
        if ($childRoles = ArrayHelper::getValue($child, 'roles')) {
            if ($childRoles) {
                foreach ($childRoles as $name) {
                    $this->stdout("\t\tassign child role: " . $name);
                    if ($roleChild = \Yii::$app->authManager->getRole($name)) {
                        try {
                            \Yii::$app->authManager->addChild($role, $roleChild);
                            $this->stdout(' - success' . "\n");
                        } catch (\Exception $e) {
                            $this->stdout(' - already exist' . "\n");
                        }
                    }
                }
            }
        }
        if ($childPermissions = ArrayHelper::getValue($child, 'permissions')) {
            if ($childPermissions) {
                foreach ($childPermissions as $name) {
                    $this->stdout("\t\tassign child permission: " . $name);
                    if ($permissionChild = \Yii::$app->authManager->getPermission($name)) {
                        try {
                            \Yii::$app->authManager->addChild($role, $permissionChild);
                            $this->stdout(' - success' . "\n");
                        } catch (\Exception $e) {
                            $this->stdout(' - already exist' . "\n");
                        }
                    }
                }
            }
        }
        return $role;
    }

    /**
     *
     * @param
     *            $config
     * @return bool
     */
    protected function _assignPermission($config)
    {
        if (! is_array($config)) {
            return false;
        }
        if (! $name = ArrayHelper::getValue($config, 'name')) {
            return false;
        }
        if (! $child = ArrayHelper::getValue($config, 'child')) {
            return false;
        }
        if (! $permission = \Yii::$app->authManager->getPermission($name)) {
            return false;
        }
        if ($childRoles = ArrayHelper::getValue($child, 'roles')) {
            if ($childRoles) {
                foreach ($childRoles as $name) {
                    $this->stdout("\t\tassign child role: " . $name);
                    if ($roleChild = \Yii::$app->authManager->getRole($name)) {
                        try {
                            \Yii::$app->authManager->addChild($permission, $roleChild);
                            $this->stdout(' - success' . "\n");
                        } catch (\Exception $e) {
                            $this->stdout(' - already exist' . "\n");
                        }
                    }
                }
            }
        }
        if ($childPermissions = ArrayHelper::getValue($child, 'permissions')) {
            if ($childPermissions) {
                foreach ($childPermissions as $name) {
                    $this->stdout("\t\tassign child permission: " . $name);
                    if ($permissionChild = \Yii::$app->authManager->getPermission($name)) {
                        try {
                            \Yii::$app->authManager->addChild($permission, $permissionChild);
                            $this->stdout(' - success' . "\n");
                        } catch (\Exception $e) {
                            $this->stdout(' - already exist' . "\n");
                        }
                    }
                }
            }
        }
        return $permission;
    }

    /**
     *
     * @param
     *            $config
     * @return bool
     */
    protected function _applyRole($config)
    {
        if (! is_array($config)) {
            return false;
        }
        if (! $name = ArrayHelper::getValue($config, 'name')) {
            return false;
        }
        $description = ArrayHelper::getValue($config, 'description');
        if ($role = \Yii::$app->authManager->getRole($name)) {
            return $role;
        }
        
        $role = \Yii::$app->authManager->createRole($name);
        $role->description = $description;
        if (\Yii::$app->authManager->add($role)) {
            return $role;
        }
        return false;
    }

    /**
     *
     * @param
     *            $config
     * @return bool
     */
    protected function _applyPermission($config)
    {
        if (! is_array($config)) {
            return false;
        }
        if (! $name = ArrayHelper::getValue($config, 'name')) {
            return false;
        }
        $description = ArrayHelper::getValue($config, 'description');
        $ruleName = ArrayHelper::getValue($config, 'ruleName', '');
        if ($role = \Yii::$app->authManager->getPermission($name)) {
            return $role;
        }
        $role = \Yii::$app->authManager->createPermission($name);
        if ($description) {
            $role->description = $description;
        }
        if ($ruleName) {
            $role->ruleName = $ruleName;
        }
        if (\Yii::$app->authManager->add($role)) {
            return $role;
        }
        return false;
    }

    /**
     *
     * @param array $config            
     */
    public function applyConfig($config = [])
    {
        if ($rules = ArrayHelper::getValue($config, 'rules')) {
            $this->stdout("\tInit rules: " . count($rules) . "\n");
            foreach ($rules as $data) {
                if ($rule = $this->_applyRule($data)) {
                    $this->stdout("\t\t- success: " . $rule->name . "\n");
                } else {
                    $this->stdout("\t\t- error config rule: " . Json::encode($data) . "\n");
                }
            }
        }
        if ($roles = ArrayHelper::getValue($config, 'roles')) {
            $this->stdout("\tInit roles: " . count($roles) . "\n");
            foreach ($roles as $data) {
                if ($role = $this->_applyRole($data)) {
                    $this->stdout("\t\t- success: " . $role->name . "\n");
                } else {
                    $this->stdout("\t\t- error config role: " . Json::encode($data) . "\n");
                }
            }
        }
        if ($permissions = ArrayHelper::getValue($config, 'permissions')) {
            $this->stdout("\tInit permissions: " . count($permissions) . "\n");
            foreach ($permissions as $data) {
                if ($permission = $this->_applyPermission($data)) {
                    $this->stdout("\t\t- success: " . $permission->name . "\n");
                } else {
                    $this->stdout("\t\t- error config role: " . Json::encode($data) . "\n");
                }
            }
        }
    }

    public function applyAssigningConfig($config)
    {
        if ($roles = ArrayHelper::getValue($config, 'roles')) {
            $this->stdout("\tAssining roles: " . count($roles) . "\n");
            foreach ($roles as $data) {
                if ($role = $this->_assignRole($data)) {
                    $this->stdout("\t- success assigned: " . $role->name . "\n");
                }
            }
        }
        if ($permissions = ArrayHelper::getValue($config, 'permissions')) {
            $this->stdout("\tAssining permissions: " . count($roles) . "\n");
            foreach ($permissions as $data) {
                if ($permission = $this->_assignPermission($data)) {
                    $this->stdout("\t- success assigned: " . $permission->name . "\n");
                }
            }
        }
    }

    /**
     * 
     * @return array
     */
    public function loadConfig()
    {
        $files = \yiisns\apps\helpers\FileHelper::findExtensionsFiles([
            '/config/permissions.php'
        ]);
        $files = array_unique(array_merge([
            \Yii::getAlias('@app/config/permissions.php'),
            \Yii::getAlias('@common/config/permissions.php')
        ], $files));
        
        $config = [];
        
        foreach ($files as $permisssionsFile) {
            if (file_exists($permisssionsFile)) {
                $this->stdout("\t- " . $permisssionsFile);
                $cfg = (array) include $permisssionsFile;
                if ($cfg) {
                    $config = ArrayHelper::merge($config, $cfg);
                    $this->stdout("(rules: " . count(ArrayHelper::getValue($cfg, 'rules', [])) . ';');
                    $this->stdout("roles: " . count(ArrayHelper::getValue($cfg, 'roles', [])) . ';');
                    $this->stdout("permissions: " . count(ArrayHelper::getValue($cfg, 'permissions', [])) . ';)');
                    $this->stdout("\n");
                } else {
                    $this->stdout("(is empty data)");
                }
            }
        }
        
        /*
         * $this->stdout("\tScan all extensions\n");
         * $config = [];
         * foreach (\Yii::$app->extensions as $code => $data)
         * {
         * if ($data['alias'])
         * {
         * foreach ($data['alias'] as $code => $path)
         * {
         * $permisssionsFile = $path . '/config/permissions.php';
         * if (file_exists($permisssionsFile))
         * {
         * $this->stdout("\t- " . $permisssionsFile);
         * $cfg = (array) include $permisssionsFile;
         * if ($cfg)
         * {
         * $config = ArrayHelper::merge($config, $cfg);
         * $this->stdout("(rules: " . count(ArrayHelper::getValue($cfg, 'rules', [])) . ';');
         * $this->stdout("roles: " . count(ArrayHelper::getValue($cfg, 'roles', [])) . ';');
         * $this->stdout("permissions: " . count(ArrayHelper::getValue($cfg, 'permissions', [])) . ';)');
         * $this->stdout("\n");
         * } else
         * {
         * $this->stdout("(is empty data)");
         * }
         * }
         * }
         * }
         * }
         */
        
        $this->stdout("\tAll config is ready: ", Console::FG_GREEN);
        $this->stdout(" (rules: " . count(ArrayHelper::getValue($config, 'rules', [])) . ';');
        $this->stdout(" roles: " . count(ArrayHelper::getValue($config, 'roles', [])) . ';');
        $this->stdout(" permissions: " . count(ArrayHelper::getValue($config, 'permissions', [])) . ';)');
        $this->stdout("\n");
        return $config;
    }

    /**
     * 
     * @return $this
     */
    protected function initRootUser()
    {
        $this->stdout("Init root user \n", Console::BOLD);
        $root = User::findByUsername('root');
        $aManager = \Yii::$app->authManager;
        if ($root && $aManager->getRole(SnsManager::ROLE_ROOT)) {
            if (! $aManager->getAssignment(SnsManager::ROLE_ROOT, $root->primaryKey)) {
                $aManager->assign($aManager->getRole(SnsManager::ROLE_ROOT), $root->primaryKey);
            }
        }
        return $this;
    }

    public function initAdminData()
    {
        $auth = Yii::$app->authManager;
        foreach (\Yii::$app->admin->menu->getData() as $group) {
            if (is_array($group)) {
                foreach ($group['items'] as $itemData) {
                    if (! is_array($itemData)) {
                        continue;
                    }
                    if (! isset($itemData['url'])) {
                        continue;
                    }
                    $url = $itemData['url'][0];
                    if (! is_array($url)) {
                        continue;
                    }
                    /**
                     *
                     * @var $controller \yii\web\Controller
                     */
                    list ($controller, $route) = \Yii::$app->createController($url);
                    // print_r("---------");
                    // print_r($controller);die;
                    if ($controller) {
                        if ($controller instanceof AdminController) {
                            if (! $adminAccess = $auth->getPermission($controller->permissionName)) {
                                $adminAccess = $auth->createPermission($controller->permissionName);
                                $adminAccess->description = 'Администрирование | ' . $controller->name;
                                $auth->add($adminAccess);
                            }
                        }
                    }
                }
            }
        }
        return $this;
    }
}