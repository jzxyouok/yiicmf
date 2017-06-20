<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 01.09.2015
 */


?>

<?= \yiisns\admin\widgets\GridView::widget([
    'dataProvider'          => new \yii\data\ActiveDataProvider([
        'query' =>
            (new \yii\db\Query())
                ->select(['id', 'phrase', 'count(*) as count'])
                ->from(\yiisns\search\models\SearchPhrase::tableName())
                ->groupBy(['phrase'])
                ->orderBy(['count' => SORT_DESC])
    ]),
    'columns'               =>
    [
        [
            'attribute' => 'phrase',
            'label'     => \Yii::t('yiisns/search', 'Search Phrase'),
        ],

        [
            'attribute' => 'count',
            'label'     => \Yii::t('yiisns/search', 'The number of requests'),
        ],
    ]
]); ?><!--

-->