<?php
use yii\helpers\Html;
use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;
/* @var $this yii\web\View */
/* @var $action \yiisns\admin\actions\modelEditor\AdminOneModelEditAction */
/* @var $model \yiisns\form2\models\Form2FormSend */
$model = $action->controller->model;

if ($model->status == \yiisns\form2\models\Form2FormSend::STATUS_NEW && !$model->processed_by)
{
    $model->processed_by = \Yii::$app->user->identity->id;
    $model->processed_at = \Yii::$app->formatter->asTimestamp(time());
    $model->status = \yiisns\form2\models\Form2FormSend::STATUS_PROCESSED;

    $model->save();
}
?>
<? $form = ActiveForm::begin(); ?>
<?
$attribures = [];
if ($attrs = $model->relatedPropertiesModel->attributeLabels())
{
    foreach ($attrs as $code => $value)
    {
        $data['attribute']  = $code;
        $data['format']     = 'raw';

        $value              = $model->relatedPropertiesModel->getSmartAttribute($code);
        $data['value']      = $value;
        if (is_array($value))
        {
            $data['value']      = implode(', ', $value);
        }

        $attribures[]       = $data;
    }
};
?>
<?= $form->fieldSet(\Yii::t('yiisns/form2', 'Data from form')); ?>
    <?= \yii\widgets\DetailView::widget([
        'model'         => $model->relatedPropertiesModel,
        'attributes'    => $attribures
    ])?>
<?= $form->fieldSetEnd(); ?>
<?= $form->fieldSet(\Yii::t('yiisns/form2', 'Who has been notified')); ?>
    <?= \yii\widgets\DetailView::widget([
        'model'         => $model,
        'attributes'    =>
        [
            [
                'attribute' => 'emails',
                'format'    => 'raw',
                'label'     => \Yii::t('yiisns/form2', 'Email Message'),
                'value'     => $model->emails
            ],

            [
                'attribute' => 'phones',
                'format'    => 'raw',
                'label'     => \Yii::t('yiisns/form2', 'Phone Message'),
                'value'     => $model->phones
            ],

            [
                'attribute' => 'user_ids',
                'format'    => 'raw',
                'label'     => \Yii::t('yiisns/form2', 'Users messages'),
                'value'     => $model->user_ids
            ],
        ]
    ]); ?>
<?= $form->fieldSetEnd(); ?>
<?= $form->fieldSet(\Yii::t('yiisns/form2', 'Additional Data')); ?>
    <?= \yii\widgets\DetailView::widget([
        'model'         => $model,
        'attributes'    =>
        [
            [
                'attribute'     => 'id',
                'label'         => \Yii::t('yiisns/form2', 'Post Number'),
            ],

            [
                'attribute' => 'created_at',
                'value'     => \Yii::$app->formatter->asDatetime($model->created_at, 'medium') . "(" . \Yii::$app->formatter->asRelativeTime($model->created_at) . ")",
            ],

            [
                'format' => 'raw',
                'label'  => \Yii::t('yiisns/form2', 'Post Number'),
                'value'  => "<a href=\"{$model->site->url}\" target=\"_blank\" data-pjax=\"0\">{$model->site->name}</a>",
            ],

            [
                'format' => 'raw',
                'label'  => \Yii::t('yiisns/form2', 'Submitted by'),
                'value'  => "{$model->createdBy->displayName}",
            ],

            [
                'attribute' => 'ip',
                'label' => \Yii::t('yiisns/form2', 'Ip address of the sender'),
            ],

            [
                'attribute' => 'page_url',
                'format' => 'raw',
                'label' => \Yii::t('yiisns/form2', 'Ip address of the sender'),
                'value' => Html::a($model->page_url, $model->page_url, [
                    'target' => '_blank',
                    'data-pjax' => 0
                ])
            ],
        ]
    ]); ?>
<?= $form->fieldSetEnd(); ?>
<?= $form->fieldSet(\Yii::t('yiisns/form2', 'Control')); ?>
    <?= $form->fieldSelect($model, 'status', \yiisns\form2\models\Form2FormSend::getStatuses())
        ->hint(\Yii::t('yiisns/form2', 'If you are treated with this message, change the status for convenience')); ?>
    <?= $form->fieldSelect($model, 'processed_by', \yii\helpers\ArrayHelper::map(
            \yiisns\kernel\models\User::find()->active()->all(),
            'id',
            'displayName'
        ))
        ->hint(\Yii::t('yiisns/form2', 'If you are treated with this message, change the status for convenience')); ?>
    <?= $form->field($model, 'comment')->textarea(['rows' => 5])->hint(\Yii::t('yiisns/form2', 'Short note, personal notes on this ship. Not necessary.')); ?>
<?= $form->fieldSetEnd(); ?>
<?= $form->fieldSet(\Yii::t('yiisns/form2', 'For developers')); ?>
<div class="sx-block">
  <h3><?=\Yii::t('yiisns/form2', 'Additional information that may be useful in some cases, the developers.');?></h3>
  <small><?=\Yii::t('yiisns/form2', 'For the convenience of viewing the data, you can use the service:');?> <a href="http://jsonformatter.curiousconcept.com/#" target="_blank">http://jsonformatter.curiousconcept.com/#</a></small>
</div>
<hr />
    <?= \yii\widgets\DetailView::widget([
        'model'         => $model,
        'attributes'    =>
        [
            [
                'attribute' => 'data_server',
                'format' => 'raw',
                'label' => 'SERVER',
                'value' => "<textarea class='form-control' rows=\"10\">" . \yii\helpers\Json::encode($model->data_server) . "</textarea>"
            ],

            [
                'attribute' => 'data_cookie',
                'format' => 'raw',
                'label' => 'COOKIE',
                'value' => "<textarea class='form-control' rows=\"5\">" . \yii\helpers\Json::encode($model->data_cookie) . "</textarea>"
            ],

            [
                'attribute' => 'data_session',
                'format' => 'raw',
                'label' => 'SESSION',
                'value' => "<textarea class='form-control' rows=\"5\">" . \yii\helpers\Json::encode($model->data_session) . "</textarea>"
            ],

            [
                'attribute' => 'data_request',
                'format' => 'raw',
                'label' => 'REQUEST',
                'value' => "<textarea class='form-control' rows=\"10\">" . \yii\helpers\Json::encode($model->data_request) . "</textarea>"
            ],

            [
                'attribute' => 'data_labels',
                'format' => 'raw',
                'value' => "<textarea class='form-control' rows=\"10\">" . \yii\helpers\Json::encode($model->data_labels) . "</textarea>"
            ],
            [
                'attribute' => 'data_values',
                'format' => 'raw',
                'value' => "<textarea class='form-control' rows=\"10\">" . \yii\helpers\Json::encode($model->data_values) . "</textarea>"
            ],
        ]
    ]); ?>
<?= $form->fieldSetEnd(); ?>
<?= $form->buttonsStandart($model); ?>
<? ActiveForm::end(); ?>