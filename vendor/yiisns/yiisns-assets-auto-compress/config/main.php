<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.06.2016
 */
return [
    
    'bootstrap' => [
        'assetsAutoCompress'
    ],
    
    'components' => [
        'assetsAutoCompress' => [
            'class' => '\yiisns\assetsAuto\AssetsAutoCompressComponent'
        ],
        
        'assetsAutoCompressSettings' => [
            'class' => '\yiisns\assetsAuto\SettingsAssetsAutoCompress'
        ],
        
        'i18n' => [
            'translations' => [
                'yiisns/assets-auto' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yiisns/assetsAuto/messages',
                    'fileMap' => [
                        'yiisns/assets-auto' => 'main.php'
                    ]
                ]
            ]
        ]
    ]
];