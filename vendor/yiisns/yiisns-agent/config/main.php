<?php
return [
    
    'bootstrap' => ['agent'],
    
    'components' => [
        'agent' => [
            'class' => 'yiisns\agent\AgentComponent',
            'onHitsEnabled' => true
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
            'class' => 'yiisns\agent\AgentModule'
        ]
    ]
];