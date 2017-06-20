<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 31.10.2016
 * @since 1.0.0
 */
return [
    'id' => 'application',
    'name' => 'YiiSNS',
    'language' => 'zh-cn',
    'bootstrap' => [
        'toolbar'
    ],
    
    'components' => [
        'appCore' => [
            'class' => 'yiisns\kernel\base\AppCore',
        ],
        'appSettings' => [
            'class' => 'yiisns\apps\components\AppSettings'
        ],
        
        'user' => [
            'class' => '\yii\web\User',
            'identityClass' => 'yiisns\kernel\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => [
                'apps/auth/login'
            ]
        ],
        
        'i18n' => [
            'class' => 'yiisns\kernel\i18n\I18N',
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@application/messages',
                    'fileMap' => [
                        'app' => 'main.php'
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
        
        'toolbar' => [
            'class' => 'yiisns\apps\components\Toolbar'
        ],
        
        'storage' => [
            'class' => 'yiisns\apps\components\Storage',
            'components' => [
                'local' => [
                    'class' => 'yiisns\apps\components\storage\ClusterLocal',
                    'priority' => 100
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
                
                "apps-imaging" => [
                    "class" => 'yiisns\apps\components\ImagingUrlRule'
                ]
            ]
        ],
        
        'assetManager' => [
            
            'appendTimestamp' => true, // 给发布的样式增加时间戳       
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        'jquery.min.js'
                    ]
                ],
                
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        'js/bootstrap.min.js'
                    ]
                ],
                
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        'css/bootstrap.min.css'
                    ]
                ]
            ]
        ],
        
        'imaging' => [
            'class' => 'yiisns\apps\components\Imaging'
        ],
        
        'breadcrumbs' => [
            'class' => 'yiisns\apps\components\Breadcrumbs'
        ],
        
        'currentSite' => [
            'class' => 'yiisns\apps\components\CurrentSite'
        ],
        
        'console' => [
            'class' => 'yiisns\apps\components\ConsoleComponent'
        ]
    ],
    
    'modules' => [
        
        'apps' => [
            'class' => 'yiisns\apps\Module'
        ],
        
        'datecontrol' => [
            'class' => 'yiisns\apps\modules\datecontrol\Module'
        ],
    ]
];