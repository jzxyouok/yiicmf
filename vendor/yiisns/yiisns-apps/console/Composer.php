<?php
namespace yiisns\apps\console;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;
use yiisns\apps\components\AppSettings;
use yiisns\apps\helpers\FileHelper;

class Composer
{
    public static function postInstall(Event $event)
    {
        $vendorDir = $event->getComposer()
            ->getConfig()
            ->get('vendor-dir');
        echo "\tpostInstall\n";
        self::generateTmpConfigs($vendorDir);
    }

    public static function postUpdate(Event $event)
    {
        $vendorDir = $event->getComposer()
            ->getConfig()
            ->get('vendor-dir');
        echo "\tpostUpdate\n";
        self::generateTmpConfigs($vendorDir);
    }

    static public function generateTmpConfigs($vendorDir)
    {
        require $vendorDir . '/autoload.php';
        require $vendorDir . '/yiisoft/yii2/Yii.php';
        define('ROOT_DIR', __DIR__);
        define('APP_CONFIG_DIR', __DIR__);
        define('VENDOR_DIR', $vendorDir);
        require $vendorDir . '/yiisns/apps/global.php';
        
        $application = new \yii\console\Application([
            'id' => 'application',
            'basePath' => __DIR__,
            
            'id' => 'application',
            "name" => "YiiSNS",
            'language' => 'zh-cn',
            'vendorPath' => $vendorDir,
            
            'components' => [
                
                'apps' => [
                    'class' => 'yiisns\apps\components\AppSettings'
                ],
                
                'i18n' => [
                    'class' => 'yiisns\apps\i18n\I18N',
                    'translations' => [
                        'yiisns/apps' => [
                            'class' => 'yii\i18n\PhpMessageSource',
                            'basePath' => '@yiisns/apps/messages',
                            'fileMap' => [
                                'yiisns/apps' => 'main.php'
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
                ]
            ]
        ]);
        
        if (\Yii::$app->appCore->generateTmpConfig()) {
            echo "\t\ttmp web config is generated\n";
        } else {
            echo "\t\tError tmp web config is generated\n";
        }
        
        if (\Yii::$app->appCore->generateTmpConsoleConfig()) {
            echo "\t\ttmp console config is generated\n";
        } else {
            echo "\t\tError tmp console config is generated\n";
        }
    }
}