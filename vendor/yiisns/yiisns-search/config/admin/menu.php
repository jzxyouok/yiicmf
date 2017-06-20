<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.04.2016
 */
return
[
    'other' =>
    [
        'items' =>
        [
            [
                'label'     => \Yii::t('yiisns/search', 'Searching'),
                'img' => ['\yiisns\search\assets\SearchAsset', 'icons/search.png'],

                'items' =>
                [
                    [
                        'label'     => \Yii::t('yiisns/search', 'Statistic'),
                        'img'       => ['\yiisns\search\assets\SearchAsset', 'icons/statistics.png'],

                        'items' =>
                        [
                            [
                                'label' => \Yii::t('yiisns/search', 'Jump list'),
                                'url'   => ['search/admin-search-phrase'],
                            ],

                            [
                                'label' => \Yii::t('yiisns/search', 'Phrase list'),
                                'url'   => ['search/admin-search-phrase-group'],
                            ],
                        ],
                    ],
                ],
            ],
        ]
    ]
];