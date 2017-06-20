<?php
return [
    
    'components' => [
        'i18n' => [
            'translations' => [
                'yiisns/sshConsole' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yiisns/sshConsole/messages',
                    'fileMap' => [
                        'yiisns/sshConsole' => 'main.php'
                    ]
                ]
            ]
        ]
    ],
    
    'modules' => [
        'sshConsole' => [
            'class' => 'yiisns\sshConsole\SshConsoleModule'
        ]
    ]
];