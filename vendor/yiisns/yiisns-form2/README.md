Form designer for SkeekS CMS
===================================

The module provides an opportunity to collect a variety of forms through the admin panel. Manage elemntov order forms, and views. Configure whom to notify.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiisns/yiisns-module-form2 "*"
```

or add

```
"yiisns/yiisns-module-form2": "*"
```

Configuration app
----------

```php

'components' =>
[
    'i18n' => [
        'translations' =>
        [
            'yiisns/form2' => [
                'class'             => 'yii\i18n\PhpMessageSource',
                'basePath'          => '@yiisns/form2/messages',
                'fileMap' => [
                    'yiisns/form2' => 'main.php',
                ],
            ]
        ]
    ],
],
'modules' =>
[
    'form2' => [
        'class' => '\yiisns\form2\Module',
    ]
]

```
