<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 17.03.2016
 *
 * @var $widget \yiisns\form2\cmsWidgets\form2\FormWidget
 */
use yiisns\form2\widgets\ActiveFormConstructForm as ActiveForm;

$modelHasRelatedProperties = $widget->modelForm->createModelFormSend();
?>
    <?php $form = ActiveForm::begin([
        'id'                                        => $widget->id . "-active-form",
        'modelForm'                                 => $widget->modelForm,
        'afterValidateCallback'                     => new \yii\web\JsExpression(<<<JS
            function(jForm, ajax)
            {
                var handler = new sx.classes.AjaxHandlerStandartRespose(ajax, {
                    'blockerSelector' : '#' + jForm.attr('id'),
                    'enableBlocker' : true,
                });

                handler.bind('error', function(e, data)
                {
                    $('.sx-success-message', jForm).hide();
                    $('.sx-error-message', jForm).show();
                    $('.sx-error-message .sx-body', jForm).empty().append(data.message);
                });

                handler.bind('success', function(e, data)
                {
                    $('.sx-error-message', jForm).hide();
                    $('.sx-success-message', jForm).show();
                    $('.sx-success-message .sx-body', jForm).empty().append(data.message);

                    $('input, textarea', jForm).each(function(value, key)
                    {
                        var name = $(this).attr('name');
                        if (name != '_csrf' && name != 'sx-model-value' && name != 'sx-model')
                        {
                            $(this).val('');
                        }
                    });

                    $.fancybox.close();
                });
            }
JS
),
    ]);
?>
<?= \yii\bootstrap\Alert::widget([
    'options' => [
        'class' => 'alert-success sx-success-message',
        'style' => 'display: none;',
    ],
    'closeButton' => false,
    'body' => '<div class="sx-body">Ok</div>',
])?>

<?= \yii\bootstrap\Alert::widget([
    'options' => [
        'class' => 'alert-danger sx-error-message',
        'style' => 'display: none;',
    ],
    'closeButton' => false,
    'body' => '<div class="sx-body">Ok</div>',
])?>
<? if ($properties = $modelHasRelatedProperties->relatedProperties) : ?>
    <? foreach ($properties as $property) : ?>
        <?= $property->renderActiveForm($form, $modelHasRelatedProperties); ?>
    <? endforeach; ?>
<? endif; ?>

<?= \yii\helpers\Html::submitButton('' . \Yii::t('yiisns/form2', $widget->btnSubmit), [
    'class' => $widget->btnSubmitClass,
]); ?>
<?php ActiveForm::end(); ?>