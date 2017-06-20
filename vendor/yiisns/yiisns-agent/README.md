Agents for YiiSNS
===================================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiisns/agent "*"
```

or add

```
"yiisns/agent": "*"
```

Configuration app
----------

```php

'bootstrap' => ['agent'],

'components' =>
[
    'agent' => [
        'class' => 'yiisns\agent\AgentComponent',
        'onHitsEnabled' => true
    ],

    'i18n' => [
        'translations' =>
        [
            'yiisns/agent' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@yiisns/agent/messages',
                'fileMap' => [
                    'yiisns/agent' => 'main.php',
                ],
            ]
        ]
    ]
],

'modules' =>
[
    'agent' => [
        'class' => 'yiisns\agent\CmsAgentModule',
    ]
]

```

How to enable execution on cron agents
----------------

#### Configuration app

```php

'components' =>
[
    'agent' => [
        'class'             => 'yiisns\agent\AgentComponent',
        'onHitsEnabled'     => false
    ],
]

```

#### Cront task

```bash
* * * * * cd /var/www/sites/you-site.com/ && php yii agent/execute
```