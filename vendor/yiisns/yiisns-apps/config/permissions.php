<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.03.2016
 */
return [
    'rules' => [
        [
            'class' => \yiisns\rbac\AuthorRule::className()
        ]
    ],
    
    'roles' => [      
        [
            'name' => \yiisns\rbac\SnsManager::ROLE_ROOT,
            'description' => \Yii::t('yiisns/kernel', 'Superuser')
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::ROLE_GUEST,
            'description' => \Yii::t('yiisns/kernel', 'Unauthorized user')
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::ROLE_ADMIN,
            'description' => \Yii::t('yiisns/kernel', 'Admin'),
            
            'child' => [
                /*
                 * 'roles' =>
                 * [
                 * \yiisns\rbac\SnsManager::ROLE_MANGER,
                 * \yiisns\rbac\SnsManager::ROLE_EDITOR,
                 * \yiisns\rbac\SnsManager::ROLE_USER,
                 * ],
                 */
                'permissions' => [
                    \yiisns\rbac\SnsManager::PERMISSION_ADMIN_ACCESS,
                    \yiisns\rbac\SnsManager::PERMISSION_CONTROLL_PANEL,
                    
                    \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_CREATE,
                    \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_UPDATE,
                    \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_DELETE,
                    \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_UPDATE_ADVANCED,
                    \yiisns\rbac\SnsManager::PERMISSION_ELFINDER_USER_FILES,
                    \yiisns\rbac\SnsManager::PERMISSION_ELFINDER_COMMON_PUBLIC_FILES,
                    \yiisns\rbac\SnsManager::PERMISSION_ELFINDER_ADDITIONAL_FILES
                ]
            ]
        ],
        [
            'name' => \yiisns\rbac\SnsManager::ROLE_MANGER,
            'description' => \Yii::t('yiisns/kernel', 'Manager (access to the administration)'),
            'child' => [
                /*
                 * 'roles' =>
                 * [
                 * \yiisns\rbac\SnsManager::ROLE_EDITOR,
                 * \yiisns\rbac\SnsManager::ROLE_USER,
                 * ],
                 */
                
                'permissions' => [
                    \yiisns\rbac\SnsManager::PERMISSION_ADMIN_ACCESS,
                    \yiisns\rbac\SnsManager::PERMISSION_CONTROLL_PANEL,
                    
                    \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_CREATE,
                    \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_UPDATE,
                    \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_DELETE,
                    \yiisns\rbac\SnsManager::PERMISSION_ELFINDER_USER_FILES,
                    \yiisns\rbac\SnsManager::PERMISSION_ELFINDER_COMMON_PUBLIC_FILES
                ]
            ]
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::ROLE_EDITOR,
            'description' => \Yii::t('yiisns/kernel', 'Editor (access to the administration)'),
            'child' => [
                /*
                 * 'roles' =>
                 * [
                 * \yiisns\rbac\SnsManager::ROLE_USER,
                 * ],
                 */
                
                'permissions' => [
                    \yiisns\rbac\SnsManager::PERMISSION_ADMIN_ACCESS,
                    \yiisns\rbac\SnsManager::PERMISSION_CONTROLL_PANEL,
                    
                    \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_CREATE,
                    \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_UPDATE_OWN,
                    \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_DELETE_OWN,
                    
                    \yiisns\rbac\SnsManager::PERMISSION_ELFINDER_USER_FILES,
                    \yiisns\rbac\SnsManager::PERMISSION_ELFINDER_COMMON_PUBLIC_FILES
                ]
            ]
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::ROLE_USER,
            'description' => \Yii::t('yiisns/kernel', 'Registered user'),
            
            'permissions' => [
                \yiisns\rbac\SnsManager::PERMISSION_ELFINDER_USER_FILES
            ]
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::ROLE_APPROVED,
            'description' => \Yii::t('yiisns/kernel', 'Confirmed user'),
            
            'permissions' => [
                \yiisns\rbac\SnsManager::PERMISSION_ELFINDER_USER_FILES
            ]
        ]
    ],
    
    'permissions' => [
        [
            'name' => \yiisns\rbac\SnsManager::PERMISSION_ADMIN_ACCESS,
            'description' => \Yii::t('yiisns/kernel', 'Access to system administration')
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::PERMISSION_CONTROLL_PANEL,
            'description' => \Yii::t('yiisns/kernel', 'Access to the site control panel')
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_CREATE,
            'description' => \Yii::t('yiisns/kernel', 'The ability to create records')
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::PERMISSION_EDIT_VIEW_FILES,
            'description' => \Yii::t('yiisns/kernel', 'The ability to edit view files')
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_UPDATE,
            'description' => \Yii::t('yiisns/kernel', 'Updating data records')
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_UPDATE_OWN,
            'description' => \Yii::t('yiisns/kernel', 'Updating data own records'),
            'ruleName' => (new \yiisns\rbac\AuthorRule())->name,
            'child' => [
                'permissions' => [
                    \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_UPDATE
                ]
            ]
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_UPDATE_ADVANCED,
            'description' => \Yii::t('yiisns/kernel', 'Updating additional data records')
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_UPDATE_ADVANCED_OWN,
            'description' => \Yii::t('yiisns/kernel', 'Updating additional data own records'),
            'ruleName' => (new \yiisns\rbac\AuthorRule())->name,
            'child' => [
                'permissions' => [
                    \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_UPDATE_ADVANCED
                ]
            ]
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_DELETE,
            'description' => \Yii::t('yiisns/kernel', 'Deleting records')
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_DELETE_OWN,
            'description' => \Yii::t('yiisns/kernel', 'Deleting own records'),
            'ruleName' => (new \yiisns\rbac\AuthorRule())->name,
            'child' => [
                'permissions' => [
                    \yiisns\rbac\SnsManager::PERMISSION_ALLOW_MODEL_DELETE
                ]
            ]
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::PERMISSION_ELFINDER_USER_FILES,
            'description' => \Yii::t('yiisns/kernel', 'Access to personal files')
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::PERMISSION_ELFINDER_COMMON_PUBLIC_FILES,
            'description' => \Yii::t('yiisns/kernel', 'Access to the public files')
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::PERMISSION_ELFINDER_ADDITIONAL_FILES,
            'description' => \Yii::t('yiisns/kernel', 'Access to all files')
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::PERMISSION_ADMIN_DASHBOARDS_EDIT,
            'description' => \Yii::t('yiisns/kernel', 'Access to edit dashboards')
        ],
        
        [
            'name' => \yiisns\rbac\SnsManager::PERMISSION_USER_FULL_EDIT,
            'description' => \Yii::t('yiisns/kernel', 'The ability to manage user groups')
        ]
    ]
];