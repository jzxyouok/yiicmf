<?php
return [ 
    'components' => [
        'dbDumper' => [
            'class' => 'yiisns\dbDumper\DbDumperComponent'
        ],
        
        'i18n' => [
            'translations' => [
                'yiisns/dbDumper' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yiisns/dbDumper/messages',
                    'fileMap' => [
                        'yiisns/dbDumper' => 'main.php'
                    ]
                ]
            ]
        ]
    ],
    
    'modules' => [
        'dbDumper' => [
            'class' => 'yiisns\dbDumper\DbDumperModule'
        ]
    ]
];