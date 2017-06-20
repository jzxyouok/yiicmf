Component seo for YiiSNS
===================================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiisns/yiisns-seo "*"
```

or add

```
"yiisns/yiisns-seo": "*"
```

Configuration app
----------

```php

'bootstrap' => ['seo'],

'components' =>
[
    'seo' => [
        'class' => 'yiisns\seo\SeoComponent',
    ],

    'i18n' => [
        'translations' =>
        [
            'yiisns/seo' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@yiisns/seo/messages',
                'fileMap' => [
                    'yiisns/seo' => 'main.php',
                ],
            ]
        ]
    ],

    'urlManager' => [
        'rules' => [
            'robots.txt' => '/seo/robots/on-request',
            'sitemap.xml' => '/seo/sitemap/on-request',
        ]
    ]
],

'modules' =>
[
    'seo' => [
        'class' => 'yiisns\seo\SeoModule',
    ]
]

```