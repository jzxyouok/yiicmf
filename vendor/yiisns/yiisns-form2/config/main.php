<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.06.2016
 */
return [
    'components' =>
    [
        'i18n' => [
            'translations' =>
            [
                'yiisns/form2' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yiisns/form2/messages',
                    'fileMap' => [
                        'yiisns/form2' => 'main.php',
                    ],
                ]
            ]
        ],
    ],

    'modules' =>
    [
        'form2' => [
            'class' => '\yiisns\form2\Module',
        ]
    ]
];