<?php
/**
 * new-children
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.11.2016
 * @since 1.0.0
 */
?>

<?= $this->render('_form', [
    'model' => $model
]); ?>

<hr />
<?= \yii\helpers\Html::a('Пересчитать приоритеты по алфавиту', '#', ['class' => 'btn btn-xs btn-primary']) ?> |
<?= \yii\helpers\Html::a('Пересчитать приоритеты по дате добавления', '#', ['class' => 'btn btn-xs btn-primary']) ?> |
<?= \yii\helpers\Html::a('Пересчитать приоритеты по дате обновления', '#', ['class' => 'btn btn-xs btn-primary']) ?>
<?= $this->render('_recalculate-children-priorities', [
    'model' => $model
]); ?>

<?= $this->render('list', [
    'searchModel'   => $searchModel,
    'dataProvider'  => $dataProvider,
    'controller'    => $controller,
]); ?>