<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016 YiiSNS
 * @date 19.02.2016
 *
 * @var $this \yii\web\View
 * @var $model \yiisns\kernel\models\DashboardWidget
 */
?>

<? $form = \yiisns\admin\widgets\form\ActiveFormUseTab::begin(); ?>
    <? if ($model->widget) : ?>
        <? $model->widget->renderConfigForm($form); ?>
    <? else : ?>
        configuration not found
    <? endif;  ?>
    <?= $form->buttonsStandart($model->widget); ?>
<? \yiisns\admin\widgets\form\ActiveFormUseTab::end(); ?>