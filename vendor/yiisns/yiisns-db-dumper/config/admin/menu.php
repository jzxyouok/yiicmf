<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 12.03.2015
 */
return
[
    'other' =>
    [
        'items' =>
        [
            [
                'label'     => \Yii::t('yiisns/dbDumper', 'Database'),
                'img'       => ['\yiisns\dbDumper\assets\DbDumperAsset', 'icons/bd-arch.png'],
                'items'     =>
                [
                    [
                        'label'     => \Yii::t('yiisns/dbDumper', 'The structure of the database'),
                        'url'       => ['dbDumper/admin-structure'],
                        'img'       => ['\yiisns\dbDumper\assets\DbDumperAsset', 'icons/bd-arch.png'],
                    ],

                    [
                        'label'     => \Yii::t('yiisns/dbDumper', 'Settings'),
                        'url'       => ['dbDumper/admin-settings'],
                        'img'       => ['\yiisns\dbDumper\assets\DbDumperAsset', 'icons/settings.png'],
                    ],

                    [
                        'label'     => \Yii::t('yiisns/dbDumper', 'Backups'),
                        'url'       => ['dbDumper/admin-backup'],
                        'img'       => ['\yiisns\dbDumper\assets\DbDumperAsset', 'icons/backup.png'],
                    ],
                ],
            ],
        ]
    ]
];