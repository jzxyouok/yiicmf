<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.10.2016
 * @since 1.0.0
 */
return [
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'application\controllers',   
    'params' => [],
    
    'on beforeRequest' => function ($event) {
        \Yii::setAlias('template', '@app/views');
    },
    
    'components' => [
        'errorHandler' => [
            'errorAction' => 'apps/error/error'
        ],
        
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'yiisns'
        ],
        
        'user' => [
            'identityClass' => 'common\models\User',
            'identityCookie' => [
                'name' => '_identity',
                'httpOnly' => true,
                'domain' => 'cmf.yiisns.cn'
            ]
        ],
        
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => [
                        '@app/templates/default'
                    ]
                ]
            ]
        ]
    ]
];