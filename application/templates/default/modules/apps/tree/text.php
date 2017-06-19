<?
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 01.10.2016
 */
/* @var $this \yii\web\View */
/* @var \yiisns\kernel\models\Tree $model */

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

                        <?= \yiisns\apps\appsWidgets\contentElements\ContentElementsWidget::widget([
                            'namespace' => 'ContentElementsWidget-second',
                            'viewFile' 	=> '@app/views/widgets/ContentElementsWidget/publications',
                        ]); ?>

                    </div>
                </div>
            </div>
        </div>
</section>