<?php
/**
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.10.2016
 * @since 1.0.0
 */
return [
    'name' => 'YiiSNS中文社区',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' =>
    [
        'db' => include_once __DIR__ . '/db.php',

        'urlManager' => [
            'rules' => [
                [
                    'class' => \yiisns\apps\components\urlRules\UrlRuleContentElement::className(),
                ],

                [
                    'class' => \yiisns\apps\components\urlRules\UrlRuleTree::className(),
                ]
            ]
        ],
        
        'formatter' => [
            'defaultTimeZone' => 'UTC',
            'timeZone' => 'Asia/Shanghai',
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat'=>'php:Y-m-d H:i:s'
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'assetManager' =>
        [
            'linkAssets'  => true,
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class'     => 'yii\log\FileTarget',
                    'logVars'   => [],
                    'levels' => [
                        'error',
                        'warning'
                    ],
                ],
            ],
        ],

        'templateBoomerang' => [
            'class' => 'common\components\boomerang\TemplateBoomerang',
        ],
    ],
];