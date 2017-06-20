<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.03.2015
 */
/* @var $this yii\web\View */

use yii\helpers\Html;
use yiisns\apps\base\widgets\ActiveFormAjaxSubmit as ActiveForm;
use \yiisns\apps\helpers\UrlHelper;

$this->title = \Yii::t('yiisns/kernel','Getting a new password');
\Yii::$app->breadcrumbs->createBase()->append($this->title);
?>
<div class="row">
   <section id="sidebar-main" class="col-md-12">
        <div id="content">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <h1><?= $message; ?></h1>
                    <?= Html::a(\Yii::t('yiisns/kernel', 'Request recovery again'), UrlHelper::constructCurrent()->setRoute('apps/auth/forget')->toString()) ?> |
                    <?= Html::a(\Yii::t('yiisns/kernel', 'Authorization'), UrlHelper::constructCurrent()->setRoute('apps/auth/login')->toString()) ?> |
                    <?= Html::a(\Yii::t('yiisns/kernel', 'Registration'), UrlHelper::constructCurrent()->setRoute('apps/auth/register')->toString()) ?>
                </div>
                <div class="col-lg-3"></div>
            </div>
        </div>
   </section>
</div>
