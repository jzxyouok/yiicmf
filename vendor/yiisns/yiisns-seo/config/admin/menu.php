<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.04.2016
 */
return [
    /*'other' => [
        'items' => [
            [
                'label' => \Yii::t('yiisns/seo', 'Seo'),
                'img' => [
                    '\yiisns\seo\assets\SeoAsset',
                    'icons/seo.png'
                ],
                
                'items' => [
                    [
                        'label' => \Yii::t('yiisns/seo', 'Seo Settings'),
                        'url' => [
                            'admin/admin-settings',
                            'component' => 'yiisns\seo\SeoComponent'
                        ],
                        'img' => [
                            '\yiisns\admin\assets\AdminAsset',
                            'images/icons/settings-big.png'
                        ],
                        'activeCallback' => function (\yiisns\admin\helpers\AdminMenuItem $adminMenuItem) {
                            return (bool) (\Yii::$app->request->getUrl() == $adminMenuItem->getUrl());
                        }
                    ]
                ]
            ]
        ]
    ]*/
];