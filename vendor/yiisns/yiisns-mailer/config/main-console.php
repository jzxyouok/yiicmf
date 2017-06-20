<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.08.2016
 */
return [
    
    'components' => [
        'mailer' => [
            'class' => 'yiisns\mail\Mailer',
            'view' => [
                'theme' => [
                    'pathMap' => [
                        '@app/mail' => [
                            '@app/mail',
                            '@yiisns/mail/templates'
                        ]
                    ]
                ]
            ]
        ],
        
        'mailerSettings' => [
            'class' => 'yiisns\mail\MailerSettings'
        ],
        
        'i18n' => [
            'translations' => [
                'yiisns/mail' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yiisns/mail/messages',
                    'fileMap' => [
                        'yiisns/mail' => 'main.php'
                    ]
                ]
            ]
        ]
    ],
    
    'modules' => [
        'mailer' => [
            'class' => 'yiisns\mail\Module',
            "controllerNamespace" => 'yiisns\mail\console\controllers'
        ]
    ]
];