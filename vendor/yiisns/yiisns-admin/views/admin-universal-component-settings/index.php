<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 09.06.2016
 */
/* @var $this yii\web\View */
/* @var $component \yiisns\kernel\relatedProperties\PropertyType */
/* @var $saved bool */
$getData            = \Yii::$app->request->get();
$clientOptions      = $getData;
$clientOptions['saveUrl'] = \yiisns\apps\helpers\UrlHelper::constructCurrent()->setRoute('/admin/admin-universal-component-settings/save')->toString();
$clientOptions      = \yii\helpers\Json::encode($clientOptions);


?>
<? if ($forSave) : ?>
    <?= $forSave; ?>
<? endif; ?>

<? if ($component instanceof \yiisns\kernel\base\ConfigFormInterface) : ?>


    <? $form = \yiisns\admin\widgets\form\ActiveFormUseTab::begin(); ?>
        <? $component->renderConfigForm($form); ?>
        <?= $form->buttonsStandart($component); ?>
    <? \yiisns\admin\widgets\form\ActiveFormUseTab::end(); ?>

<? else: ?>
    <? if ($component->existsConfigFormFile()) : ?>
        <?= $component->renderConfigForm(); ?>
    <? else: ?>
        <p>No settings</p>
    <? endif; ?>
<? endif; ?>

<? $this->registerJs(<<<JS

(function(sx, $, _)
{
    sx.classes.ComponentSettingsSaver = sx.classes.Component.extend({

        _init: function()
        {
            if (!window.parent)
            {
                throw new Error("Parent component not Found");
            }
        },

        _onDomReady: function()
        {
            var self = this;

            $(document).on('pjax:complete', function() {
               self.save();
            });
        },

        save: function()
        {
            var self = this;
            var ajax = sx.ajax.preparePostQuery(this.get('saveUrl'));
            var ajaxHandler = new sx.classes.AjaxHandlerStandartRespose(ajax);
            ajaxHandler.bind('success', function(e, response)
            {
                self.getCallbackComponent().save(response.data.forSave);
            });
            ajax.setData($("form").serialize());
            ajax.execute();
        },

        _onWindowReady: function()
        {},

        /**
        * @returns {sx.classes.Component}
        */
        getCallbackComponent: function()
        {
            var self = this;

            return _.find(window.parent.sx.components, function(Component)
            {
                if (Component instanceof window.parent.sx.classes.Component)
                {
                    if (Component.get('id') == self.get('callbackComonentId'))
                    {
                        return Component;
                    }
                }
            });
        }
    });

    new sx.classes.ComponentSettingsSaver({$clientOptions});

})(sx, sx.$, sx._);


JS
);?>