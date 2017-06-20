<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yiisns\kernel\models\AuthItem $model
 */

$this->title = \Yii::t('yiisns/kernel', 'Create Rule');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('yiisns/kernel', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
