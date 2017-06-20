<?php
return [ 
    'components' => [
        'authManager' => [
            'class' => 'yiisns\rbac\DbManager'
        ]
    ],
    
    'modules' => [
        'rbac' => [
            'class' => 'yiisns\rbac\RbacModule',
            'controllerNamespace' => 'yiisns\rbac\console\controllers'
        ]
    ]
];