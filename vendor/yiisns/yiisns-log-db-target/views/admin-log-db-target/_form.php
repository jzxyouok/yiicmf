<?php
use yii\helpers\Html;
use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;
/* @var $this yii\web\View */
/* @var $action \yiisns\admin\actions\modelEditor\AdminOneModelEditAction */
/* @var $model \yiisns\form2\models\Form2FormSend */
?>
<?=
\yii\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'level',
        'category',
        [
            'attribute' => 'log_time',
            'value'     => \Yii::$app->formatter->asDatetime($model->log_time, 'full') . " (" . \Yii::$app->formatter->asRelativeTime($model->log_time) . ")"
        ],
        'prefix',
        [
            'attribute'     => 'message',
            'format'        => 'html',
            'value'         => "<pre><code>" . Html::encode($model->message) . "</code></pre>"
        ],
    ],
])
?>