<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.06.2016
 */
return [
    'bootstrap' => ['log'],
    
    'components' => [
        'i18n' => [
            'translations' => [
                'yiisns/logdb' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yiisns/logDbTarget/messages',
                    'fileMap' => [
                        'yiisns/logdb' => 'main.php'
                    ]
                ]
            ]
        ],
        
        'logDbTargetSettings' => [
            'class' => 'yiisns\logDbTarget\components\LogDbTargetSettings'
        ],
        
        'log' => [
            'targets' => [
                [
                    'class' => 'yiisns\logDbTarget\LogDbTarget'
                ]
            ]
        ]
    ],
    
    'modules' => [
        'logDbTarget' => [
            'class' => 'yiisns\logDbTarget\Module'
        ]
    ]
];