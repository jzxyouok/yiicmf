<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016 YiiSNS
 * @date 15.04.2016
 */
return [
    'users' => [
        'items' => [
            [
                'label' => \Yii::t('yiisns/rbac', 'Roles management'),
                'url' => [
                    'rbac/admin-role'
                ],
                'img' => [
                    '\yiisns\rbac\assets\RbacAsset',
                    'icons/users-role.png'
                ],
                //'enabled' => true,
                'priority' => 300
            ],
            
            [
                'label' => \Yii::t('yiisns/rbac', 'Privileges management'),
                'url' => [
                    'rbac/admin-permission'
                ],
                'img' => [
                    '\yiisns\rbac\assets\RbacAsset',
                    'icons/access.png'
                ],
                //'enabled' => true,
                'priority' => 400
            ]
        ]
    ]
];