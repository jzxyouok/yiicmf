<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 08.06.2016
 */
/* @var $this yii\web\View */

$db = \Yii::$app->db;
$schema = $db->getSchema();
$schema->refresh();
?>

<?= \yiisns\admin\widgets\GridView::widget([
    'dataProvider'  => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'fullName',
            'label' => \Yii::t('yiisns/dbDumper', 'Name'),
        ],

        [
            'attribute' => 'fullName',
            'label' => \Yii::t('yiisns/dbDumper', 'Full name'),
        ],

        [
            'class' => \yii\grid\DataColumn::className(),
            'label' => \Yii::t('yiisns/dbDumper', 'Number of columns'),
            'value' => function(yii\db\TableSchema $model)
            {
                return count($model->columns);
            }
        ],

        [
            'class' => \yii\grid\DataColumn::className(),
            'attribute' => 'primaryKey',
            'label' => \Yii::t('yiisns/dbDumper', 'Primary keys'),
            'value' => function(yii\db\TableSchema $model)
            {
                return implode(', ', $model->primaryKey);
            }
        ],
        
        [
            'class'         => \yii\grid\DataColumn::className(),
            'attribute'     => 'foreignKeys',
            'label'         => \Yii::t('yiisns/dbDumper', 'Number of foreign keys'),
            'value' => function(yii\db\TableSchema $model)
            {
                return count($model->foreignKeys);
            }
        ],
        'schemaName',
        'sequenceName'
    ],
]); ?>