<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.03.2016
 *
 * @var $loadedComponents
 * @var $component \yiisns\kernel\base\Component
 */
/* @var $this yii\web\View */

?>
<form id="selector-component" action='' method='get' data-pjax>
    <label><?=\Yii::t('yiisns/kernel', 'Component settings')?></label>
    <?=
    \yii\widget\chosen\Chosen::widget([
        'name' => 'component',
        'items' => $loadedForSelect,
        'allowDeselect' => false,
        'value' => $component->className(),
        'hiddenDomain' => false,
    ])
    ?>
    <? if (\Yii::$app->admin->isEmptyLayout()) : ?>
        <input type="hidden" name="<?= \yiisns\apps\helpers\UrlHelper::SYSTEM_APP_NAME; ?>[<?= \yiisns\admin\Module::SYSTEM_QUERY_EMPTY_LAYOUT?>]" value="true" />
    <? endif; ?>
</form>
<hr />
<iframe data-src="<?= $component->getEditUrl(); ?>" width="100%;" height="200px;" id="sx-test">
</iframe>

<?
$this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.SelectorComponent = sx.classes.Component.extend({

        _init: function()
        {
            this.Iframe = new sx.classes.Iframe('sx-test', {
                'autoHeight'        : true,
                'heightSelector'    : '.sx-panel-content',
                'minHeight'         : 800
            });
        },

        _onDomReady: function()
        {
            $("#selector-component select").on('change', function()
            {
                $("#selector-component").submit();
            });

            _.delay(function()
            {
                $('#sx-test').attr('src', $('#sx-test').data('src'));
            }, 200);
        },

        _onWindowReady: function()
        {}
    });

    new sx.classes.SelectorComponent();
})(sx, sx.$, sx._);
JS
)
?>