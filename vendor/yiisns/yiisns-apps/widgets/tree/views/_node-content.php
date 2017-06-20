<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 18.12.2016
 */
/* @var $this yii\web\View */
/* @var $widget \yiisns\apps\widgets\tree\TreeWidget */
/* @var $model \yiisns\kernel\models\Tree */
$widget = $this->context;
?>
<div class="sx-label-node level-<?= $model->level; ?> status-<?= $model->active; ?>">
    <a href="<?= $widget->getOpenCloseLink($model); ?>">
        <?= $model->name; ?>
    </a>
</div>