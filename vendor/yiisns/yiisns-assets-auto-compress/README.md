Component automatically compile js and css files (on request)
===================================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiisns/yiisns-assets-auto-compress "*"
```

or add

```
"yiisns/yiisns-assets-auto-compress": "*"
```

Configuration app
----------

```php

'bootstrap'    => ['assetsAutoCompress'],
'components' =>
[
    'assetsAutoCompress' =>
    [
        'class'         => '\yiisns\assetsAuto\AssetsAutoCompressComponent',
    ],
    'assetsAutoCompressSettings' =>
    [
        'class'         => '\yiisns\assetsAuto\SettingsAssetsAutoCompress',
    ],
    'i18n' => [
        'translations' =>
        [
            'yiisns/assets-auto' => [
                'class'             => 'yii\i18n\PhpMessageSource',
                'basePath'          => '@yiisns/assetsAuto/messages',
                'fileMap' => [
                    'yiisns/assets-auto' => 'main.php',
                ],
            ]
        ]
    ],
],

```