<?php
return [   
    'components' => [
        'authManager' => [
            'class' => 'yiisns\rbac\DbManager'
        ],
        
        'i18n' => [
            'translations' => [
                'yiisns/rbac' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yiisns/rbac/messages',
                    'fileMap' => [
                        'yiisns/rbac' => 'main.php'
                    ]
                ]
            ]
        ]
    ],
    
    'modules' => [
        'rbac' => [
            'class' => 'yiisns\rbac\RbacModule'
        ]
    ]
];