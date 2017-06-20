<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.03.2016
 */
namespace yiisns\rbac;

/**
 * Class SnsManager
 * 
 * @package yiisns\kernel\rbac
 */
class SnsManager extends \yii\rbac\DbManager
{
    const PERMISSION_ADMIN_ACCESS = 'admin.admin-access';

    const PERMISSION_CONTROLL_PANEL = 'apps.controll-panel-access';

    const PERMISSION_ALLOW_EDIT = 'apps.allow-edit';

    const PERMISSION_ADMIN_DASHBOARDS_EDIT = 'admin.admin-dashboards-edit';

    const PERMISSION_USER_FULL_EDIT = 'apps.user-full-edit';

    const PERMISSION_ALLOW_MODEL_CREATE = 'apps.model-create';

    const PERMISSION_ALLOW_MODEL_UPDATE = 'apps.model-update';

    const PERMISSION_ALLOW_MODEL_UPDATE_ADVANCED = 'apps.model-update-advanced';

    const PERMISSION_ALLOW_MODEL_DELETE = 'apps.model-delete';

    const PERMISSION_ALLOW_MODEL_UPDATE_OWN = 'apps.model-update-own';

    const PERMISSION_ALLOW_MODEL_UPDATE_ADVANCED_OWN = 'apps.model-update-advanced-own';

    const PERMISSION_ALLOW_MODEL_DELETE_OWN = 'apps.model-delete-own';

    const PERMISSION_ELFINDER_USER_FILES = 'apps.elfinder-user-files';

    const PERMISSION_ELFINDER_COMMON_PUBLIC_FILES = 'apps.elfinder-common-public-files';

    const PERMISSION_ELFINDER_ADDITIONAL_FILES = 'apps.elfinder-additional-files';

    const PERMISSION_EDIT_VIEW_FILES = 'apps.edit-view-files';

    const ROLE_GUEST = 'guest';

    const ROLE_ROOT = 'root';

    const ROLE_ADMIN = 'admin';

    const ROLE_MANGER = 'manager';

    const ROLE_EDITOR = 'editor';

    const ROLE_USER = 'user';

    const ROLE_APPROVED = 'approved';

    static public function protectedRoles()
    {
        return [
            static::ROLE_ROOT,
            static::ROLE_ADMIN,
            static::ROLE_MANGER,
            static::ROLE_EDITOR,
            static::ROLE_USER,
            static::ROLE_GUEST,
            static::ROLE_APPROVED
        ];
    }

    static public function protectedPermissions()
    {
        return [
            static::PERMISSION_ADMIN_ACCESS,
            static::PERMISSION_CONTROLL_PANEL
        ];
    }
}