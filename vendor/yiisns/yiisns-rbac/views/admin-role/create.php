<?php
use yii\helpers\Html;
/**
 * @var yii\web\View $this
 * @var \yiisns\kernel\models\AuthItem $model
 */
?>
<div class="auth-item-create">

	<?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>