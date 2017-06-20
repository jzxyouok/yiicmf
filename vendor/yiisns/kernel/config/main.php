<?php
return [
    'components' => [
        'i18n' => [
            'translations' =>
            [
                'yiisns/kernel' => [
                    'class'             => 'yii\i18n\PhpMessageSource',
                    'basePath'          => '@yiisns/kernel/messages',
                    'fileMap' => [
                        'yiisns/kernel' => 'main.php',
                    ],
                ],
            ],
        ],
    ],
];