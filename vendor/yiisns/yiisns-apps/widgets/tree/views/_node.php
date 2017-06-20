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
<?= \yii\helpers\Html::beginTag('li', [
    "class" => "sx-tree-node " . ($widget->isOpenNode($model) ? " open" : ""),
    "data-id" => $model->id,
    "title" => ""
]); ?>

    <div class="row">
        <? if ($model->children) : ?>
            <div class="sx-node-open-close">
                <? if ($widget->isOpenNode($model)) : ?>
                    <a href="<?= $widget->getOpenCloseLink($model); ?>" class="btn btn-sm btn-default">
                        <span class="glyphicon glyphicon-minus" title="<?= \Yii::t('yiisns/kernel',"Minimize"); ?>"></span>
                    </a>
                <? else : ?>
                    <a href="<?= $widget->getOpenCloseLink($model); ?>" class="btn btn-sm btn-default">
                        <span class="glyphicon glyphicon-plus" title="<?= \Yii::t('yiisns/kernel',"Restore"); ?>"></span>
                    </a>
                <? endif; ?>
            </div>
        <? endif; ?>

        <?= $widget->renderNodeContent($model); ?>

    </div>

    <!-- Construction of child elements -->
    <? if ($widget->isOpenNode($model) && $model->children) : ?>
        <?= $widget->renderNodes($model->children); ?>
    <? endif;  ?>

<?= \yii\helpers\Html::endTag('li'); ?>

