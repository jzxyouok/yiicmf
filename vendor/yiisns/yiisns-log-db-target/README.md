Error logging in mysql database for YiiSNS
===================================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiisns/yiisns-log-db-target "*"
```

or add

```
"yiisns/yiisns-log-db-target": "*"
```

Configuration app
----------

```php

'components' =>
[
    'i18n' => [
        'translations' =>
        [
            'yiisns/logdb' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@yiisns/logDbTarget/messages',
                'fileMap' => [
                    'yiisns/logdb' => 'main.php',
                ],
            ]
        ]
    ],

    'logDbTargetSettings' => [
        'class' => 'yiisns\logDbTarget\components\LogDbTargetSettings',
    ],

    'log' => [
        'targets' => [
            [
                'class' => 'yiisns\logDbTarget\LogDbTarget',
            ],
        ],
    ]
],

'modules' =>
[
    'logDbTarget' => [
        'class' => '\yiisns\logDbTarget\Module',
    ]
]

```