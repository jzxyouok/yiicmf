<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.01.2015
 * @since 1.0.0
 */
/* @var $this yii\web\View */
/* @var $model \yiisns\admin\models\forms\SshConsoleForm */
use yiisns\admin\widgets\ActiveForm;
use \yii\helpers\Html;

use Yii;
?>

<div class="sx-widget-ssh-console">
    <? $form = ActiveForm::begin() ?>
        <?= $form->field($model, 'command')->textarea([
            'placeholder' => 'php yii help'
        ]); ?>
        <div class="form-group sx-commands">
            <button type="button" class="btn btn-default btn-xs" data-sx-widget="tooltip" title="<?=\Yii::t('app','Execute command')?>" data-original-title="<?=\Yii::t('app', 'Execute command')?>">php yii</button>
            <button type="button" class="btn btn-default btn-xs" data-sx-widget="tooltip" title="<?=\Yii::t('app','Execute command')?>" data-original-title="<?=\Yii::t('app', 'Execute command')?>">php yii help apps/update</button>
            <button type="button" class="btn btn-default btn-xs" data-sx-widget="tooltip" title="<?=\Yii::t('app','Execute command')?>" data-original-title="<?=\Yii::t('app', 'Execute command')?>">php yii apps/update</button>
            <button type="button" class="btn btn-default btn-xs" data-sx-widget="tooltip" title="<?=\Yii::t('app','Execute command')?>" data-original-title="<?=\Yii::t('app', 'Execute command')?>">php yii apps/update/all --interactive=0</button>
        </div>
        <?= Html::tag('div',
            Html::submitButton(\Yii::t('app', 'Execute command'), ['class' => 'btn btn-primary']),
            ['class' => 'form-group']
        ); ?>

        <div class="sx-result-container">
            <pre id="sx-result">
<?= $result; ?>
            </pre>
        </div>

        <? $this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.Console = sx.classes.Component.extend({

        _init: function()
        {},

        _onDomReady: function()
        {
            jQuery('.sx-commands button').on('click', function()
            {
                $(".sx-widget-ssh-console textarea").empty().append($(this).text());
            });
        },

        _onWindowReady: function()
        {}
    });
    new sx.classes.Console();
})(sx, sx.$, sx._);
JS
);
        ?>
    <? ActiveForm::end() ?>
    <hr />
    root dir: <?= ROOT_DIR; ?>
</div>