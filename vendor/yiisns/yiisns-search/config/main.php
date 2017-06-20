<?php
return [
    
    'components' => [
        'search' => [
            'class' => 'yiisns\search\SearchComponent',
            'img' => [
                '\yiisns\admin\assets\AdminAsset',
                'images/icons/dashboard.png'
            ]
        ],
        
        'i18n' => [
            'translations' => [
                'yiisns/search' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yiisns/search/messages',
                    'fileMap' => [
                        'yiisns/search' => 'main.php'
                    ]
                ]
            ]
        ],
        
        'urlManager' => [
            'rules' => [
                'search' => 'search/result/index',
                'search/' => 'search/result/index'
            ]
        ]
    ],
    
    'modules' => [
        'search' => [
            'class' => 'yiisns\search\SearchModule'
        ]
    ]
];