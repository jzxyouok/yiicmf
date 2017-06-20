Ssh console for YiiSNS
===================================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiisns/sshConsole "*"
```

or add

```
"yiisns/sshConsole": "*"
```

Configuration app
----------

```php

'components' =>
[
    'i18n' => [
        'translations' =>
        [
            'yiisns/sshConsole' => [
                'class'             => 'yii\i18n\PhpMessageSource',
                'basePath'          => '@yiisns/sshConsole/messages',
                'fileMap' => [
                    'yiisns/sshConsole' => 'main.php',
                ],
            ]
        ]
    ],
],

'modules' =>
[
    'sshConsole' => [
        'class'         => 'yiisns\sshConsole\SshConsoleModule',
    ]
]

```