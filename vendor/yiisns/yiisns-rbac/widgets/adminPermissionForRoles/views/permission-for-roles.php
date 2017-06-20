<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.08.2016
 */
/* @var $this yii\web\View */
/* @var $widget \yiisns\apps\widgets\rbac\PermissionForRoles */
?>
<div id="<?= $widget->id; ?>" class="form-group">
    <? if ($widget->label): ?>
        <label><?= $widget->label; ?></label>
    <? endif;  ?>

    <?/*= \yii\helpers\Html::checkboxList(
        'sx-permission-' . $widget->permissionName,
        $widget->permissionRoles,
        \yii\helpers\ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description')
    ); */?>
    <?= \yii\widget\chosen\Chosen::widget([
        'multiple'          => true,
        'name'              => 'sx-permission-' . $widget->permissionName,
        'value'             => $widget->permissionRoles,
        'items'             => $widget->items
    ]); ?>

    <? $this->registerJs(<<<JS
    (function(sx, $, _)
    {
        new sx.classes.PermissionForRoles({$widget->getClientOptionsJson()});
    })(sx, sx.$, sx._);
JS
)?>
</div>