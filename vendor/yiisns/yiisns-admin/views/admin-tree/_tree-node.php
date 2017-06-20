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

?>
<div class="sx-label-node level-<?= $model->level; ?> status-<?= $model->active; ?>">
    <a href="<?= $widget->getOpenCloseLink($model); ?>">
        <?= $result; ?>
    </a>
    <? if ($model->redirect || $model->redirect_tree_id) : ?>
        →
    <? endif; ?>
    <? if ($model->redirect) : ?>
        <?= $model->redirect; ?>
    <? endif; ?>
    <? if ($model->redirectTree) : ?>
        <? if ($parents = $model->redirectTree->parents) : ?>
            <?
                $root = $parents[0];
                unset($parents[0]);
            /**
             * @var \yiisns\kernel\models\Tree $root
             */
                $names[] = $root->site->name;
                if ($parents)
                {
                    $names = \yii\helpers\ArrayHelper::merge($names, \yii\helpers\ArrayHelper::map($parents, 'name', 'name'));
                }
                $names[] = $model->redirectTree->name;
                echo implode(" / ", $names);
            ?>
        <? else : ?>
            <?
                $names[] = $model->redirectTree->site->name;
                echo implode(' / ', $names);
            ?>
        <? endif; ?>

    <? endif; ?>
</div>


<!-- Possible actions -->
<div class="sx-controll-node row">
    <?
        $controller = \Yii::$app->getModule('admin')->createControllerByID('admin-tree');
        $controller->setModel($model);
    ?>
    <?= \yiisns\admin\widgets\DropdownControllerActions::widget([
        'controller'            => $controller,
        'renderFirstAction'     => true,
        'containerClass'        => 'dropdown pull-left',
        'clientOptions'         =>
        [
            'pjax-id' => $widget->pjax->id
        ]
    ]); ?>
    <div class="pull-left sx-controll-act">
        <a href="#" class="btn-tree-node-controll btn btn-default btn-sm add-tree-child" title="<?= \Yii::t('yiisns/kernel','Create subsection'); ?>" data-id="<?= $model->id; ?>"><span class="glyphicon glyphicon-plus"></span></a>
    </div>
    <div class="pull-left sx-controll-act">
        <a href="<?= $model->absoluteUrl; ?>" target="_blank" class="btn-tree-node-controll btn btn-default btn-sm show-at-site" title="<?= \Yii::t('yiisns/kernel', 'Show at site'); ?>">
            <span class="glyphicon glyphicon-eye-open"></span>
        </a>
    </div>
    <? if ($model->level > 0) : ?>
        <div class="pull-left sx-controll-act">
            <a href="#" class="btn-tree-node-controll btn btn-default btn-sm sx-tree-move" title="<?= \Yii::t('yiisns/kernel', 'Change sorting'); ?>">
                <span class="glyphicon glyphicon-move"></span>
            </a>
        </div>
    <? endif; ?>
</div>

<? if ($model->treeType) : ?>
    <div class="pull-right sx-tree-type">
        <?= $model->treeType->name; ?>
    </div>
<? endif; ?>