<?php
return [
    'components' => [
        
        'admin' => [
            'class' => 'yiisns\admin\components\settings\AdminSettings',
            'dashboards' => [
                'Advanced widgets' => [
                    yiisns\admin\dashboards\ContentElementListDashboard::className()
                ]
            ]
        ],
        
        'urlManager' => [
            'rules' => [
                'yiisns-admin' => [
                    'class' => 'yiisns\admin\components\UrlRule',
                    'adminPrefix' => '~sx'
                ]
            ]
        ],
        
        'i18n' => [
            'translations' => [
                'yiisns/admin' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yiisns/admin/messages',
                    'fileMap' => [
                        'yiisns/admin' => 'main.php'
                    ]
                ]
            ]
        ]
    ],
    
    'modules' => [
        
        'admin' => [
            'class' => 'yiisns\admin\Module',
            'allowedIPs' => [
                '192.168.1.*'
            ]
        ]
    ]
];