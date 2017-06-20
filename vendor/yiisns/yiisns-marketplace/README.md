Marketplace for YiiSNS
===================================

Installation
------------

The preferred way to install this extension is through [composer](https://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiisns/yiisns-marketplace "*"
```

or add

```
"yiisns/yiisns-marketplace": "*"
```

Configuration app
----------

```php

'components' =>
[
    'marketplace' =>
    [
        'class' => '\yiisns\marketplace\marketplaceComponent',
    ],
    'i18n' => [
        'translations' =>
        [
            'yiisns/marketplace' => [
                'class'             => 'yii\i18n\PhpMessageSource',
                'basePath'          => '@yiisns/marketplace/messages',
                'fileMap' => [
                    'yiisns/marketplace' => 'main.php',
                ],
            ]
        ]
    ],
],

'modules' =>
[
    'marketplace' => [
        'class' => 'yiisns\marketplace\marketplaceModule',
    ]
]

```
