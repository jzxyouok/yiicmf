<?php
return [

    'components' => [
        'agent' => [
            'class' => 'yiisns\agent\AgentComponent'
        ],
        
        'i18n' => [
            'translations' => [
                'yiisns/agent' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yiisns/agent/messages',
                    'fileMap' => [
                        'yiisns/agent' => 'main.php'
                    ]
                ]
            ]
        ]
    ],
    
    'modules' => [
        'agent' => [
            'class' => 'yiisns\agent\AgentModule',
            'controllerNamespace' => 'yiisns\agent\console\controllers'
        ]
    ]
];