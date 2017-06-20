Mailer for SkeekS CMS
===================================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiisns/yiisns-mailer "*"
```

or add

```
"yiisns/yiisns-mailer": "*"
```

Configuration app
----------

```php

'components' =>
[
    'mailer' => [
        'class'         => 'yiisns\mail\Mailer',
        'view'          =>
        [
            'theme' =>
            [
                'pathMap' =>
                [
                    '@app/mail' =>
                    [
                        '@app/mail',
                        '@yiisns/mail/templates'
                    ]
                ]
            ]
        ]
    ],

    'mailerSettings' => [
        'class'         => 'yiisns\mail\MailerSettings',
    ],

    'i18n' => [
        'translations' =>
        [
            'yiisns/mail' => [
                'class'             => 'yii\i18n\PhpMessageSource',
                'basePath'          => '@yiisns/mail/messages',
                'fileMap' => [
                    'yiisns/mail' => 'main.php',
                ],
            ]
        ]
    ],
],

'modules' =>
[
    'mailer' => [
        'class'         => 'yiisns\mail\Module',
    ]
]

```