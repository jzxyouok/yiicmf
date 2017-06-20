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
                'label' => \Yii::t('yiisns/sshConsole', 'Ssh console'),
                'img' => [
                    'yiisns\sshConsole\assets\SshConsoleAsset',
                    'icons/ssh.png'
                ],
                
                'items' => [
                    [
                        'label' => \Yii::t('yiisns/sshConsole', 'Ssh console'),
                        'url' => [
                            "sshConsole/admin-ssh"
                        ],
                        'img' => [
                            'yiisns\sshConsole\assets\SshConsoleAsset',
                            'icons/ssh.png'
                        ]
                    ]
                ]
            ]
        ]
    ]
];