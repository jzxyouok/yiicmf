<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 24.05.2016
 */
/* @var $this \yii\web\View */
/* @var $model \yiisns\kernel\models\ContentElement */
?>
<?= $this->render('@template/include/breadcrumbs', [
    'model' => $model
])?>
<!-- Product page -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?= $model->description_full; ?>
            </div>
        </div>
    </div>
</section>