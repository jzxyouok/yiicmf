<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 31.10.2016
 * @since 1.0.0
 */
return [
    'id' => 'yiisns-app',
    'name' => 'YiiSNS',
    'language' => 'zh-cn',
    'vendorPath' => VENDOR_DIR,
    
    'components' => [
        
        'db' => [
            'class' => 'yii\db\Connection',
            'charset' => 'utf8',
            'enableSchemaCache' => false
        ],
        
        'storage' => [
            'class' => 'yiisns\apps\components\Storage',
            'components' => [
                'local' => [
                    'class' => 'yiisns\apps\components\storage\ClusterLocal'
                ]
            ]
        ],
        
        'currentSite' => [
            'class' => 'yiisns\apps\components\CurrentSite'
        ],
        
        'appSettings' => [
            'class' => 'yiisns\apps\components\AppSettings'
        ],
        
        'appCore' => [
             'class' => 'yiisns\kernel\base\AppCore'
        ],
        
        'imaging' => [
            'class' => 'yiisns\apps\components\Imaging'
        ],
        
        'console' => [
            'class' => 'yiisns\apps\components\ConsoleComponent'
        ],
        
        'i18n' => [
            'class' => 'yiisns\apps\i18n\I18N',
            'translations' => [
                'yiisns/apps' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yiisns\apps/messages',
                    'fileMap' => [
                        'yiisns\apps' => 'main.php'
                    ]
                ],
                
                'yiisns/apps/user' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yiisns/apps/messages',
                    'fileMap' => [
                        'yiisns/apps/user' => 'user.php'
                    ]
                ]
            ]
        ],
        
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '',
            'rules' => [
                'u' => 'apps/user/index',
                'u/<username>' => 'apps/user/view',
                'u/<username>/<action>' => 'apps/user/<action>',
                
                '~<_a:(login|logout|register|forget|reset-password)>' => 'apps/auth/<_a>',
                
                'yiisns-apps' => 'apps/apps/index',
                'yiisns-apps/<action>' => 'apps/apps/<action>',
                
                "imaging" => [
                    "class" => 'yiisns\apps\components\ImagingUrlRule'
                ]
            ]
        ] // Resize image on request

        
    ],
    
    'modules' => [
        
        'apps' => [
            'class' => 'yiisns\apps\Module',
            'controllerNamespace' => 'yiisns\apps\console\controllers'
        ]
    ]
];