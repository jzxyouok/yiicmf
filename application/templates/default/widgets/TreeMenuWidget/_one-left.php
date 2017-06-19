<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.05.2016
 */
/* @var $this   yii\web\View */
/* @var $widget \yiisns\apps\appsWidgets\treeMenu\TreeMenuWidget */
/* @var $model   \yiisns\kernel\models\Tree */
$hasChildrens = $model->children;

$activeClass = '';
if (strpos(\Yii::$app->request->pathInfo, $model->dir) !== false)
{
    $activeClass = ' active';
}
?>

<li class="list-group-item <?= $activeClass; ?>">
    <? if ($hasChildrens) : ?>
        <a href="<?= $model->url; ?>" title="<?= $model->name; ?>" class="dropdown-toggle">
            <?= $model->name; ?>
        </a>

        <ul>
        <? foreach($model->getChildren()
                       ->andWhere(['active' => $widget->active])
                       ->orderBy([$widget->orderBy => $widget->order])
                       ->all() as $childTree) : ?>
                <li class="<?= strpos(\Yii::$app->request->pathInfo, $childTree->dir) !== false ? "active" : ""?>">
                    <a href="<?= $childTree->url; ?>" title="<?= $childTree->name; ?>"><?= $childTree->name; ?></a>
                </li>
        <? endforeach; ?>
            </ul>
    <? else: ?>
        <a href="<?= $model->url; ?>" title="<?= $model->name; ?>"><?= $model->name; ?></a>
    <? endif; ?>
</li>