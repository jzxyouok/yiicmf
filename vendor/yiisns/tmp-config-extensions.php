<?php

return array (
  'id' => 'application',
  'name' => 'YiiSNS',
  'language' => 'zh-cn',
  'bootstrap' => 
  array (
    0 => 'toolbar',
    1 => 'seo',
    2 => 'log',
    3 => 'agent',
    4 => 'assetsAutoCompress',
  ),
  'components' => 
  array (
    'appCore' => 
    array (
      'class' => 'yiisns\\kernel\\base\\AppCore',
    ),
    'appSettings' => 
    array (
      'class' => 'yiisns\\apps\\components\\AppSettings',
    ),
    'user' => 
    array (
      'class' => '\\yii\\web\\User',
      'identityClass' => 'yiisns\\kernel\\models\\User',
      'enableAutoLogin' => true,
      'loginUrl' => 
      array (
        0 => 'apps/auth/login',
      ),
    ),
    'i18n' => 
    array (
      'class' => 'yiisns\\kernel\\i18n\\I18N',
      'translations' => 
      array (
        'app' => 
        array (
          'class' => 'yii\\i18n\\PhpMessageSource',
          'basePath' => '@application/messages',
          'fileMap' => 
          array (
            'app' => 'main.php',
          ),
        ),
        'yiisns/apps/user' => 
        array (
          'class' => 'yii\\i18n\\PhpMessageSource',
          'basePath' => '@yiisns/apps/messages',
          'fileMap' => 
          array (
            'yiisns/apps/user' => 'user.php',
          ),
        ),
        'yiisns/admin' => 
        array (
          'class' => 'yii\\i18n\\PhpMessageSource',
          'basePath' => '@yiisns/admin/messages',
          'fileMap' => 
          array (
            'yiisns/admin' => 'main.php',
          ),
        ),
        'yiisns/kernel' => 
        array (
          'class' => 'yii\\i18n\\PhpMessageSource',
          'basePath' => '@yiisns/kernel/messages',
          'fileMap' => 
          array (
            'yiisns/kernel' => 'main.php',
          ),
        ),
        'yiisns/rbac' => 
        array (
          'class' => 'yii\\i18n\\PhpMessageSource',
          'basePath' => '@yiisns/rbac/messages',
          'fileMap' => 
          array (
            'yiisns/rbac' => 'main.php',
          ),
        ),
        'yiisns/seo' => 
        array (
          'class' => 'yii\\i18n\\PhpMessageSource',
          'basePath' => '@yiisns/seo/messages',
          'fileMap' => 
          array (
            'yiisns/seo' => 'main.php',
          ),
        ),
        'yiisns/logdb' => 
        array (
          'class' => 'yii\\i18n\\PhpMessageSource',
          'basePath' => '@yiisns/logDbTarget/messages',
          'fileMap' => 
          array (
            'yiisns/logdb' => 'main.php',
          ),
        ),
        'yiisns/dbDumper' => 
        array (
          'class' => 'yii\\i18n\\PhpMessageSource',
          'basePath' => '@yiisns/dbDumper/messages',
          'fileMap' => 
          array (
            'yiisns/dbDumper' => 'main.php',
          ),
        ),
        'yiisns/agent' => 
        array (
          'class' => 'yii\\i18n\\PhpMessageSource',
          'basePath' => '@yiisns/agent/messages',
          'fileMap' => 
          array (
            'yiisns/agent' => 'main.php',
          ),
        ),
        'yiisns/search' => 
        array (
          'class' => 'yii\\i18n\\PhpMessageSource',
          'basePath' => '@yiisns/search/messages',
          'fileMap' => 
          array (
            'yiisns/search' => 'main.php',
          ),
        ),
        'yiisns/sshConsole' => 
        array (
          'class' => 'yii\\i18n\\PhpMessageSource',
          'basePath' => '@yiisns/sshConsole/messages',
          'fileMap' => 
          array (
            'yiisns/sshConsole' => 'main.php',
          ),
        ),
        'yiisns/assets-auto' => 
        array (
          'class' => 'yii\\i18n\\PhpMessageSource',
          'basePath' => '@yiisns/assetsAuto/messages',
          'fileMap' => 
          array (
            'yiisns/assets-auto' => 'main.php',
          ),
        ),
        'yiisns/form2' => 
        array (
          'class' => 'yii\\i18n\\PhpMessageSource',
          'basePath' => '@yiisns/form2/messages',
          'fileMap' => 
          array (
            'yiisns/form2' => 'main.php',
          ),
        ),
        'yiisns/mail' => 
        array (
          'class' => 'yii\\i18n\\PhpMessageSource',
          'basePath' => '@yiisns/mail/messages',
          'fileMap' => 
          array (
            'yiisns/mail' => 'main.php',
          ),
        ),
      ),
    ),
    'toolbar' => 
    array (
      'class' => 'yiisns\\apps\\components\\Toolbar',
    ),
    'storage' => 
    array (
      'class' => 'yiisns\\apps\\components\\Storage',
      'components' => 
      array (
        'local' => 
        array (
          'class' => 'yiisns\\apps\\components\\storage\\ClusterLocal',
          'priority' => 100,
        ),
      ),
    ),
    'urlManager' => 
    array (
      'class' => 'yii\\web\\UrlManager',
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'suffix' => '',
      'rules' => 
      array (
        'u' => 'apps/user/index',
        'u/<username>' => 'apps/user/view',
        'u/<username>/<action>' => 'apps/user/<action>',
        '~<_a:(login|logout|register|forget|reset-password)>' => 'apps/auth/<_a>',
        'yiisns-apps' => 'apps/apps/index',
        'yiisns-apps/<action>' => 'apps/apps/<action>',
        'apps-imaging' => 
        array (
          'class' => 'yiisns\\apps\\components\\ImagingUrlRule',
        ),
        'yiisns-admin' => 
        array (
          'class' => 'yiisns\\admin\\components\\UrlRule',
          'adminPrefix' => '~sx',
        ),
        'robots.txt' => '/seo/robots/on-request',
        'sitemap.xml' => '/seo/sitemap/on-request',
        'search' => 'search/result/index',
        'search/' => 'search/result/index',
      ),
    ),
    'assetManager' => 
    array (
      'appendTimestamp' => true,
      'bundles' => 
      array (
        'yii\\web\\JqueryAsset' => 
        array (
          'js' => 
          array (
            0 => 'jquery.min.js',
          ),
        ),
        'yii\\bootstrap\\BootstrapPluginAsset' => 
        array (
          'js' => 
          array (
            0 => 'js/bootstrap.min.js',
          ),
        ),
        'yii\\bootstrap\\BootstrapAsset' => 
        array (
          'css' => 
          array (
            0 => 'css/bootstrap.min.css',
          ),
        ),
      ),
    ),
    'imaging' => 
    array (
      'class' => 'yiisns\\apps\\components\\Imaging',
    ),
    'breadcrumbs' => 
    array (
      'class' => 'yiisns\\apps\\components\\Breadcrumbs',
    ),
    'currentSite' => 
    array (
      'class' => 'yiisns\\apps\\components\\CurrentSite',
    ),
    'console' => 
    array (
      'class' => 'yiisns\\apps\\components\\ConsoleComponent',
    ),
    'admin' => 
    array (
      'class' => 'yiisns\\admin\\components\\settings\\AdminSettings',
      'dashboards' => 
      array (
        'Advanced widgets' => 
        array (
          0 => 'yiisns\\admin\\dashboards\\ContentElementListDashboard',
        ),
      ),
    ),
    'authManager' => 
    array (
      'class' => 'yiisns\\rbac\\DbManager',
    ),
    'seo' => 
    array (
      'class' => 'yiisns\\seo\\SeoComponent',
    ),
    'logDbTargetSettings' => 
    array (
      'class' => 'yiisns\\logDbTarget\\components\\LogDbTargetSettings',
    ),
    'log' => 
    array (
      'targets' => 
      array (
        0 => 
        array (
          'class' => 'yiisns\\logDbTarget\\LogDbTarget',
        ),
      ),
    ),
    'dbDumper' => 
    array (
      'class' => 'yiisns\\dbDumper\\DbDumperComponent',
    ),
    'agent' => 
    array (
      'class' => 'yiisns\\agent\\AgentComponent',
      'onHitsEnabled' => true,
    ),
    'search' => 
    array (
      'class' => 'yiisns\\search\\SearchComponent',
      'img' => 
      array (
        0 => '\\yiisns\\admin\\assets\\AdminAsset',
        1 => 'images/icons/dashboard.png',
      ),
    ),
    'assetsAutoCompress' => 
    array (
      'class' => '\\yiisns\\assetsAuto\\AssetsAutoCompressComponent',
    ),
    'assetsAutoCompressSettings' => 
    array (
      'class' => '\\yiisns\\assetsAuto\\SettingsAssetsAutoCompress',
    ),
    'mailer' => 
    array (
      'class' => 'yiisns\\mail\\Mailer',
      'view' => 
      array (
        'theme' => 
        array (
          'pathMap' => 
          array (
            '@app/mail' => 
            array (
              0 => '@app/mail',
              1 => '@yiisns/mail/templates',
            ),
          ),
        ),
      ),
    ),
    'mailerSettings' => 
    array (
      'class' => 'yiisns\\mail\\MailerSettings',
    ),
  ),
  'modules' => 
  array (
    'apps' => 
    array (
      'class' => 'yiisns\\apps\\Module',
    ),
    'datecontrol' => 
    array (
      'class' => 'yiisns\\apps\\modules\\datecontrol\\Module',
    ),
    'admin' => 
    array (
      'class' => 'yiisns\\admin\\Module',
      'allowedIPs' => 
      array (
        0 => '192.168.1.*',
      ),
    ),
    'rbac' => 
    array (
      'class' => 'yiisns\\rbac\\RbacModule',
    ),
    'seo' => 
    array (
      'class' => 'yiisns\\seo\\SeoModule',
    ),
    'logDbTarget' => 
    array (
      'class' => 'yiisns\\logDbTarget\\Module',
    ),
    'dbDumper' => 
    array (
      'class' => 'yiisns\\dbDumper\\DbDumperModule',
    ),
    'agent' => 
    array (
      'class' => 'yiisns\\agent\\AgentModule',
    ),
    'search' => 
    array (
      'class' => 'yiisns\\search\\SearchModule',
    ),
    'sshConsole' => 
    array (
      'class' => 'yiisns\\sshConsole\\SshConsoleModule',
    ),
    'form2' => 
    array (
      'class' => '\\yiisns\\form2\\Module',
    ),
    'mailer' => 
    array (
      'class' => 'yiisns\\mail\\Module',
    ),
  ),
);
