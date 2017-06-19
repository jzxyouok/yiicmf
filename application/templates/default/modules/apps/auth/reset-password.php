<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.03.2016
 */
/* @var $this yii\web\View */

use yii\helpers\Html;
use yiisns\apps\base\widgets\ActiveFormAjaxSubmit as ActiveForm;
use yiisns\apps\helpers\UrlHelper;
?>
<?= $this->render("_header", ['title' => 'Получение нового пароля']); ?>
<div class="col-md-6 col-md-offset-3">
    <div class="box-static box-border-top padding-30">
        <div class="box-title margin-bottom-30">
            <h2 class="size-20"><?= $message; ?></h2>
        </div>
        <?= Html::a('Request recovery again', UrlHelper::constructCurrent()->setRoute('apps/auth/forget')->toString()) ?> |
        <?= Html::a('Authorization', UrlHelper::constructCurrent()->setRoute('apps/auth/login')->toString()) ?> |
        <?= Html::a('Check in', UrlHelper::constructCurrent()->setRoute('apps/auth/register')->toString()) ?>
    </div>
</div>
<?= $this->render('_footer'); ?>