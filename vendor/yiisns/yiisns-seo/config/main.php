<?php
return [  
    'bootstrap' => ['seo'],  
    'components' => [
        'seo' => [
            'class' => 'yiisns\seo\SeoComponent'
        ],
        
        'i18n' => [
            'translations' => [
                'yiisns/seo' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yiisns/seo/messages',
                    'fileMap' => [
                        'yiisns/seo' => 'main.php'
                    ]
                ]
            ]
        ],
        
        'urlManager' => [
            'rules' => [
                'robots.txt' => '/seo/robots/on-request',
                'sitemap.xml' => '/seo/sitemap/on-request'
            ]
        ]
    ],
    
    'modules' => [
        'seo' => [
            'class' => 'yiisns\seo\SeoModule'
        ]
    ]
];