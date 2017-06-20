<?php
use yii\helpers\Html;
use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model \yiisns\form2\models\Form2Form */
/* @var $console \yiisns\apps\controllers\AdminUserController */
/* @var $action \yiisns\admin\actions\modelEditor\AdminOneModelEditAction */
?>
<?=
    \yiisns\form2\cmsWidgets\form2\FormWidget::widget([
        'namespace' => 'FormWidget-admin-' . $action->controller->model->id,
        'form_id'   => $action->controller->model->id
    ]);
?>