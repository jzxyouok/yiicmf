<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 14.10.2016
 */
/* @var $this yii\web\View */
/* @var $action \yiisns\admin\actions\modelEditor\AdminMultiDialogModelEditAction*/
/* @var $content \yiisns\kernel\models\Content */

$model = new \yiisns\kernel\models\ContentElement();

$jsData = \yii\helpers\Json::encode([
    'id' => $action->id
]);

$this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.MultiRP = sx.classes.Component.extend({

        _onDomReady: function()
        {
            var self = this;
            this.jWrapper = $("#" + this.get('id'));
            this.jForm = $('form', this.jWrapper);
            this.jSelect = $('.sx-select', this.jWrapper);

            this.jSelect.on('change', function()
            {
                $(".sx-multi", self.jForm).slideUp();

                if (self.jSelect.val())
                {
                    self.jForm.show();
                } else
                {
                    self.jForm.hide();
                }

                _.each(self.jSelect.val(), function(element)
                {
                    $(".sx-multi-" + element, self.jForm).slideDown();

                });
            });
        }
    });

    new sx.classes.MultiRP({$jsData});
})(sx, sx.$, sx._);
JS
);
?>
<div id="<?= $action->id; ?>">
    <? if ($action->controller && $action->controller->content) : ?>

        <? $content = $action->controller->content; ?>
        <? $element = $content->createElement(); ?>
        <? $element->loadDefaultValues(); ?>

        <? if ($element && $element->relatedPropertiesModel) : ?>

            <? $form = \yiisns\admin\widgets\ActiveForm::begin([
                'options' => [
                    'class' => 'sx-form',
                ]
            ]); ?>
                <?= \yii\widget\chosen\Chosen::widget([
                    'multiple' => true,
                    'name' => 'fields',
                    'options' => [
                        'class' => 'sx-select'
                    ],
                    'items' => $element->relatedPropertiesModel->attributeLabels()
                ]); ?>

                <?= \yii\helpers\Html::hiddenInput('content_id', $content->id); ?>

                <? foreach ($element->relatedPropertiesModel->properties as $property) : ?>
                    <div class="sx-multi sx-multi-<?= $property->code; ?>" style="display: none;">
                        <?= $property->renderActiveForm($form); ?>
                    </div>
                <? endforeach; ?>
                <?= $form->buttonsStandart($model, ['save']);?>
            <? $form::end(); ?>
        <? else : ?>
            Not found properties
        <? endif; ?>
    <? endif; ?>
</div>