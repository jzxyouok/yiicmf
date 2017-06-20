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

$result = $model->name;
$additionalName = '';
if ($model->level == 0)
{
    $site = \yiisns\kernel\models\Site::findOne(['code' => $model->site_code]);
    if ($site)
    {
        $additionalName = $site->name;
    }
} else
{
    if ($model->name_hidden)
    {
        $additionalName = $model->name_hidden;
    }
}

if ($additionalName)
{
    $result .= " [{$additionalName}]";
}

$controllElement = \Yii::$app->controller->renderNodeControll($model);
?>

<?= $controllElement; ?>
<div class="sx-label-node level-<?= $model->level; ?> status-<?= $model->active; ?>">
    <a href="<?= $widget->getOpenCloseLink($model); ?>">
        <?= $result; ?>
    </a>
</div>

<!-- Possible actions -->
<div class="sx-controll-node row">
    <div class="pull-left sx-controll-act">
        <a href="<?= $model->absoluteUrl; ?>" target="_blank" class="btn-tree-node-controll btn btn-default btn-sm show-at-site" title="<?= \Yii::t('yiisns/kernel',"Show at site"); ?>">
            <span class="glyphicon glyphicon-eye-open"></span>
        </a>
    </div>
</div>

<? if ($model->treeType) : ?>
    <div class="pull-right sx-tree-type">
        <?= $model->treeType->name; ?>
    </div>
<? endif; ?>