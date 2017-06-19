<?
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.03.2016
 */
/* @var $this \yii\web\View */
/* @var \yiisns\kernel\models\ContentElement $model */
?>

<?= $this->render('@template/include/breadcrumbs', [
    'model' => $model
])?>

<!--=== Content Part ===-->
<section class="slice bg-white bb">
        <div class="wp-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?= $model->description_full; ?>

                        <?/*= \yiisns\apps\appsWidgets\treeMenu\TreeMenuWidget::widget([
                            'namespace'         => 'TreeMenuWidget-sub-catalog',
                            'viewFile'          => '@template/widgets/TreeMenuWidget/sub-catalog',
                            'treePid'           => $model->id,
                            'enabledRunCache'   => \yiisns\kernel\base\AppCore::BOOL_N,
                        ]); */?>

                    </div>
                </div>
            </div>
        </div>
</section>