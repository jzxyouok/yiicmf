<?php

use yiisns\kernel\models\Tree;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Tree */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>

<?=\Yii::t('yiisns/kernel','Recalculate the priorities of childs')?><br />
По полю: <?= Html::dropDownList('column', null, ['name' => \Yii::t('yiisns/kernel','Name'), 'created_at' => \Yii::t('yiisns/kernel','Created At'), 'updated_at' => \Yii::t('yiisns/kernel','Updated At')]) ?>
<br />
Порядок: <?= Html::dropDownList('sort', null, ['desc' => \Yii::t('yiisns/kernel','Descending'), 'asc' => \Yii::t('yiisns/kernel','Ascending')]) ?>
<br />
<?= Html::submitButton(\Yii::t('yiisns/kernel','Recalculate'), ['class' => 'btn btn-xs btn-primary', 'name' => 'recalculate_children_priorities', 'value' => '1']) ?>
<br /><br />

<?php ActiveForm::end(); ?>