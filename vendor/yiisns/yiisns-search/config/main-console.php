<?php
return [
    
    'components' => [
        'search' => [
            'class' => 'yiisns\search\SearchComponent'
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
        ]
    ],
    
    'modules' => [
        'search' => [
            'class' => 'yiisns\search\SearchModule',
            'controllerNamespace' => 'yiisns\search\console\controllers'
        ]
    ]
];