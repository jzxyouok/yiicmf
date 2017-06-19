<?
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.03.2015
 */
/* @var $this \yii\web\View */
/* @var \yiisns\kernel\models\Tree $model */

$catalogHelper = \common\helpers\CatalogTreeHelper::instance($model);
?>

<?= $this->render('@template/include/breadcrumbs', [
    'model' => $model
])?>

<!-- Product page -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-9 col-lg-push-3 col-md-push-3 col-sm-push-3">
                <div class="row">
                    <?= $model->description_full; ?>
                    <? if ($catalogHelper->viewType == \common\helpers\CatalogTreeHelper::VIEW_TREE) : ?>
                        <?= trim(\yiisns\apps\appsWidgets\treeMenu\TreeMenuWidget::widget([
                            'namespace'         => 'TreeMenuWidget-sub-catalog',
                            'viewFile'          => '@template/widgets/TreeMenuWidget/sub-catalog',
                            'treePid'           => $model->id,
                            'enabledRunCache'   => \yiisns\kernel\base\AppCore::BOOL_N,
                        ])); ?>
                    <? else : ?>
                        <?= \yiisns\apps\appsWidgets\contentElements\ContentElementsWidget::widget([
                            'namespace' => 'ContentElementsWidget-second',
                            'viewFile' 	=> '@app/views/widgets/ContentElementsWidget/products',
                        ]); ?>
                    <? endif; ?>
                </div>
            </div>
            <!-- LEFT -->
            <div class="col-lg-3 col-md-3 col-sm-3 col-lg-pull-9 col-md-pull-9 col-sm-pull-9">
                <!-- CATEGORIES -->
                <div class="side-nav margin-bottom-60">
                    <?= trim(\yiisns\apps\appsWidgets\treeMenu\TreeMenuWidget::widget([
                        'namespace'         => 'TreeMenuWidget-leftmenu',
                        'viewFile'          => '@template/widgets/TreeMenuWidget/left-menu',
                        'treePid'           => $model->id,
                        'enabledRunCache'   => \yiisns\kernel\base\AppCore::BOOL_N,
                        'label'             => '',
                    ])); ?>
                </div>
                <!-- /CATEGORIES -->
            </div>
        </div>
    </div>
</section>