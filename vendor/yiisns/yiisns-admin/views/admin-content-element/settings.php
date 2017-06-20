<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 02.06.2016
 */
/* @var $this yii\web\View */
/* @var $action \yiisns\admin\actions\modelEditor\AdminModelEditorAction */
/* @var $controller \yiisns\admin\controllers\AdminContentElementController  */
$controller = $action->controller;
?>
<?= $this->render('@yiisns/admin/views/admin-content/_form.php', [
    'model' => $controller->content
]); ?>