<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.04.2016
 */
return [
    'other' => [
        'items' => [
            [
                'label' => \Yii::t('yiisns/agent', 'Agents'),
                'img' => [
                    'yiisns\agent\assets\AgentAsset',
                    'icons/clock.png'
                ],
                
                'items' => [
                    [
                        'label' => \Yii::t('yiisns/agent', 'Agents'),
                        'url' => [
                            'agent/admin-agent'
                        ],
                        'img' => [
                            'yiisns\agent\assets\AgentAsset',
                            'icons/clock.png'
                        ]
                    ]
                ]
            ]
        ]
    ]
];