<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.07.2016
 */
return [
    'other' => [
        'items' => [
            [
                'label' => \Yii::t('yiisns/logdb', 'Logs Management'),
                'img' => [
                    '\yiisns\logDbTarget\assets\LogDbTargetAsset',
                    'icons/log.png'
                ],
                
                'items' => [
                    [
                        'label' => \Yii::t('yiisns/logdb', 'Logs Management'),
                        'url' => [
                            'logDbTarget/admin-log-db-target'
                        ],
                        'img' => [
                            '\yiisns\logDbTarget\assets\LogDbTargetAsset',
                            'icons/log.png'
                        ]
                    ],
                    
                    /*[
                        'label' => \Yii::t('yiisns/logdb', 'Logs Settings'),
                        'url' => [
                            'admin/admin-settings',
                            'component' => 'yiisns\LogDbTarget\components\LogDbTargetSettings'
                        ],
                        'img' => [
                            '\yiisns\admin\assets\AdminAsset',
                            'images/icons/settings.png'
                        ]
                    ]*/
                ]
                
            ]
        ]
    ]
];