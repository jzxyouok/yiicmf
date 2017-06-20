<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 22.05.2016
 */
/* @var $this yii\web\View */
/* @var $widget \yiisns\admin\widgets\filters\AdminFiltersForm */
/* @var $filter \yiisns\kernel\models\AdminFilter */
$widget = $this->context;
?>
<?
$modelEdit = new \yiisns\kernel\models\AdminFilter($widget->filter->toArray());

$updateFormId = $widget->id . '-update-filter';
$updateModal = \yii\bootstrap\Modal::begin([
    'id' => $widget->getEditFilterFormModalId(),
    'header'    => '<b>' . \Yii::t('yiisns/admin', 'Edit filter') . '</b>',
    'footer'    => '
        <button class="btn btn-primary" onclick="$(\'#' . $updateFormId . '\').submit(); return false;">' . \Yii::t('yiisns/kernel', 'Save') . '</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">' . \Yii::t('yiisns/admin', 'Close') . '</button>
    ',
]);?>
    <? $form = \yiisns\apps\base\widgets\ActiveFormAjaxSubmit::begin([
            'id'                => $updateFormId,
            'action'            => \yii\helpers\Url::to(['/admin/admin-filter/save']),
            'validationUrl'     => \yii\helpers\Url::to(['/admin/admin-filter/validate']),
            'afterValidateCallback'     => new \yii\web\JsExpression(<<<JS
        function(jForm, AjaxQuery)
        {
            var Handler = new sx.classes.AjaxHandlerStandartRespose(AjaxQuery);
            var Blocker = new sx.classes.AjaxHandlerBlocker(AjaxQuery, {
                'wrapper' : jForm.closest('.modal-content')
            });

            Handler.bind('success', function()
            {
                _.delay(function()
                {
                    window.location.reload();
                }, 1000);
            });
        }
JS
            )
        ]); ?>
        <?= \yii\helpers\Html::hiddenInput('pk', $modelEdit->id); ?>
        <?= $form->field($modelEdit, 'name'); ?>
        <?= $form->field($modelEdit, 'isPublic')->checkbox(\Yii::$app->formatter->booleanFormat); ?>
        <button style="display: none;"></button>
    <? \yiisns\apps\base\widgets\ActiveFormAjaxSubmit::end(); ?>
<? \yii\bootstrap\Modal::end();?>