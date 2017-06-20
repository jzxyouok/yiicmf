<?php
return array(
    'id' => 'yiisns-app',
    'name' => 'YiiSNS',
    'language' => 'zh-cn',
    'vendorPath' => 'G:\\wwwroot\\dev.yiisns.cn/vendor',
    'components' => array(
        'db' => array(
            'class' => 'yii\\db\\Connection',
            'charset' => 'utf8',
            'enableSchemaCache' => false
        ),
        'storage' => array(
            'class' => 'yiisns\\apps\\components\\Storage',
            'components' => array(
                'local' => array(
                    'class' => 'yiisns\\apps\\components\\storage\\ClusterLocal'
                )
            )
        ),
        'currentSite' => array(
            'class' => 'yiisns\\apps\\components\\CurrentSite'
        ),
        
        'appCore' => array(
            'class' => 'yiisns\\kernel\\base\\AppCore'
        ),
        
        'appSettings' => array(
            'class' => 'yiisns\apps\components\AppSettings'
        ),
        
        'imaging' => array(
            'class' => 'yiisns\\apps\\components\\Imaging'
        ),
        'console' => array(
            'class' => 'yiisns\\apps\\components\\ConsoleComponent'
        ),
        'i18n' => array(
            'class' => 'yiisns\\kernel\\i18n\\I18N',
            'translations' => array(
                'yiisns/apps' => array(
                    'class' => 'yii\\i18n\\PhpMessageSource',
                    'basePath' => '@yiisns\\apps/messages',
                    'fileMap' => array(
                        'yiisns\\apps' => 'main.php'
                    )
                ),
                'yiisns/apps/user' => array(
                    'class' => 'yii\\i18n\\PhpMessageSource',
                    'basePath' => '@yiisns/apps/messages',
                    'fileMap' => array(
                        'yiisns/apps/user' => 'user.php'
                    )
                ),
                'yiisns/dbDumper' => array(
                    'class' => 'yii\\i18n\\PhpMessageSource',
                    'basePath' => '@yiisns/dbDumper/messages',
                    'fileMap' => array(
                        'yiisns/dbDumper' => 'main.php'
                    )
                ),
                'yiisns/agent' => array(
                    'class' => 'yii\\i18n\\PhpMessageSource',
                    'basePath' => '@yiisns/agent/messages',
                    'fileMap' => array(
                        'yiisns/agent' => 'main.php'
                    )
                ),
                'yiisns/search' => array(
                    'class' => 'yii\\i18n\\PhpMessageSource',
                    'basePath' => '@yiisns/search/messages',
                    'fileMap' => array(
                        'yiisns/search' => 'main.php'
                    )
                ),
                'yiisns/mail' => array(
                    'class' => 'yii\\i18n\\PhpMessageSource',
                    'basePath' => '@yiisns/mail/messages',
                    'fileMap' => array(
                        'yiisns/mail' => 'main.php'
                    )
                )
            )
        ),
        'urlManager' => array(
            'class' => 'yii\\web\\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '',
            'rules' => array(
                'u' => 'apps/user/index',
                'u/<username>' => 'apps/user/view',
                'u/<username>/<action>' => 'apps/user/<action>',
                '~<_a:(login|logout|register|forget|reset-password)>' => 'apps/auth/<_a>',
                'yiisns-apps' => 'apps/apps/index',
                'yiisns-apps/<action>' => 'apps/apps/<action>',
                'imaging' => array(
                    'class' => 'yiisns\\apps\\components\\ImagingUrlRule'
                )
            )
        ),
        'admin' => array(
            'class' => '\\yiisns\\admin\\components\\settings\\AdminSettings'
        ),
        'authManager' => array(
            'class' => 'yiisns\\rbac\\DbManager'
        ),
        'logDbTargetSettings' => array(
            'class' => 'yiisns\\logDbTarget\\components\\LogDbTargetSettings'
        ),
        'log' => array(
            'targets' => array(
                0 => array(
                    'class' => 'yiisns\\logDbTarget\\LogDbTarget'
                )
            )
        ),
        'dbDumper' => array(
            'class' => 'yiisns\\dbDumper\\DbDumperComponent'
        ),
        'agent' => array(
            'class' => 'yiisns\\agent\\AgentComponent'
        ),
        'search' => array(
            'class' => 'yiisns\\search\\SearchComponent'
        ),
        'mailer' => array(
            'class' => 'yiisns\\mail\\Mailer',
            'view' => array(
                'theme' => array(
                    'pathMap' => array(
                        '@app/mail' => array(
                            0 => '@app/mail',
                            1 => '@yiisns/mail/templates'
                        )
                    )
                )
            )
        ),
        'mailerSettings' => array(
            'class' => 'yiisns\\mail\\MailerSettings'
        )
    ),
    'modules' => array(
        'apps' => array(
            'class' => 'yiisns\\apps\\Module',
            'controllerNamespace' => 'yiisns\\apps\\console\\controllers'
        ),
        'rbac' => array(
            'class' => 'yiisns\\rbac\\RbacModule',
            'controllerNamespace' => 'yiisns\\rbac\\console\\controllers'
        ),
        'logDbTarget' => array(
            'class' => '\\yiisns\\logDbTarget\\ConsoleModule'
        ),
        'dbDumper' => array(
            'class' => 'yiisns\\dbDumper\\DbDumperModule',
            'controllerNamespace' => 'yiisns\\dbDumper\\console\\controllers'
        ),
        'agent' => array(
            'class' => 'yiisns\\agent\\AgentModule',
            'controllerNamespace' => 'yiisns\\agent\\console\\controllers'
        ),
        'search' => array(
            'class' => 'yiisns\\search\\SearchModule',
            'controllerNamespace' => 'yiisns\\search\\console\\controllers'
        ),
        'mailer' => array(
            'class' => 'yiisns\\mail\\Module',
            'controllerNamespace' => 'yiisns\\mail\\console\\controllers'
        )
    )
);
