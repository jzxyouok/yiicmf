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
                'label' => \Yii::t('yiisns/form2', 'Form designer'),
                'img' => [
                    '\yiisns\form2\assets\FormAsset',
                    'icons/forms.png'
                ],
                
                'items' => [
                    [
                        'label' => \Yii::t('yiisns/form2', 'Forms'),
                        'url' => [
                            'form2/admin-form'
                        ],
                        'img' => [
                            '\yiisns\form2\assets\FormAsset',
                            'icons/forms.png'
                        ]
                    ],
                    
                    [
                        'label' => \Yii::t('yiisns/form2', 'Messages'),
                        'url' => [
                            'form2/admin-form-send'
                        ],
                        'img' => [
                            '\yiisns\form2\assets\FormAsset',
                            'icons/form-submits.png'
                        ]
                    ]
                ]
                
            ]
        ]
    ]
];