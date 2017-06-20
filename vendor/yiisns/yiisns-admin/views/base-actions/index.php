<?php
/**
 * index
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.10.2014
 * @since 1.0.0
 */
use yiisns\admin\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel \yiisns\kernel\models\Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$dataProvider->sort->defaultOrder = [
    'id' => 'DESC'
];
?>

<?= GridView::widget([
    'dataProvider'  => $dataProvider,
    'filterModel'   => $searchModel,
    'columns'       => $columns
    ,
]); ?>
