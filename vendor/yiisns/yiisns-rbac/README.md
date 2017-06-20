Rbac for YiiSNS
===================================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiisns/rbac "*"
```

or add

```
"yiisns/yiisns-rbac": "*"
```

Configuration app
----------

```php

'components' => [
    'authManager' => [
        'class' => '\yiisns\rbac\DbManager'
    ],
        
    'i18n' => [
        'translations' => [
            'yiisns/rbac' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@yiisns/rbac/messages',
                'fileMap' => [
                    'yiisns/rbac' => 'main.php'
                ]
            ]
        ]
    ]
],
    
'modules' => [
    'rbac' => [
        'class' => 'yiisns\rbac\RbacModule'
    ]
]

```