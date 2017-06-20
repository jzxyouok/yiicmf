<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 12.03.2016
 */
return [
    
    'other' => [
        'items' => [
            [
                'label' => \Yii::t('yiisns/mail', 'Mailer'),
                'img' => [
                    '\yiisns\mail\assets\MailerAsset',
                    'icons/email.png'
                ],
                
                'items' => [
                    [
                        'label' => \Yii::t('yiisns/mail', 'Testing sending'),
                        'url' => [
                            'mailer/admin-test'
                        ],
                        'img' => [
                            '\yiisns\mail\assets\MailerAsset',
                            'icons/email.png'
                        ]
                    ]
                ]
            ]
        ]
    ]
];