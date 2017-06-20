Database dumper for YiiSNS
===================================

Installation
------------

The preferred way to install this extension is through [composer](https://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiisns/yiisns-db-dumper "*"
```

or add

```
"yiisns/yiisns-db-dumper": "*"
```

Configuration app
----------

```php

'components' =>
[
    'dbDumper' => [
        'class' => '\yiisns\dbDumper\DbDumperComponent',
    ],
    'i18n' => [
        'translations' =>
        [
            'yiisns/dbDumper' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@yiisns/dbDumper/messages',
                'fileMap' => [
                    'yiisns/dbDumper' => 'main.php',
                ],
            ]
        ]
    ],
],
'modules' =>
[
    'dbDumper' => [
        'class' => '\yiisns\dbDumper\DbDumperModule',
    ]
]

```