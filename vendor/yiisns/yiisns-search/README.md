Component search for YiiSNS
===================================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiisns/search "*"
```

or add

```
"yiisns/search": "*"
```

Configuration app
----------

```php

'components' =>
[
    'search' => [
        'class' => 'yiisns\search\CmsSearchComponent',
    ],

    'i18n' => [
        'translations' =>
        [
            'yiisns/search' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@yiisns/search/messages',
                'fileMap' => [
                    'yiisns/search' => 'main.php',
                ],
            ]
        ]
    ],

    'urlManager' => [
        'rules' => [
            'search' => 'search/result',
        ]
    ]
],

'modules' =>
[
    'search' => [
        'class' => 'yiisns\search\SearchModule',
    ]
]

```