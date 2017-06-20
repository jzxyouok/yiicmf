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
/* @var $selectTreeInputWidget \yiisns\apps\widgets\formInputs\selectTree\SelectTreeInputWidget */
$widget = $this->context;
$selectTreeInputWidget = \yii\helpers\ArrayHelper::getValue($widget->contextData, 'selectTreeInputWidget');
?>

<?= $selectTreeInputWidget->renderNodeControll($model); ?>
<div class="sx-label-node level-<?= $model->level; ?> status-<?= $model->active; ?>">
    <a href="<?= $widget->getOpenCloseLink($model); ?>"><?= $selectTreeInputWidget->renderNodeName($model); ?></a>
</div>

<!-- Possible actions -->
<!--<div class="sx-controll-node row">
    <div class="pull-left sx-controll-act">
        <a href="<?/*= $model->absoluteUrl; */?>" target="_blank" class="btn-tree-node-controll btn btn-default btn-sm show-at-site" title="<?/*= \Yii::t('yiisns/kernel',"Show at site"); */?>">
            <span class="glyphicon glyphicon-eye-open"></span>
        </a>
    </div>
</div>-->

<?/* if ($model->treeType) : */?><!--
    <div class="pull-right sx-tree-type">
        <?/*= $model->treeType->name; */?>
    </div>
--><?/* endif; */?>

