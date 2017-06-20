<?
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.06.2016
 */
/* @var $this yii\web\View */
/* @var $widget \yiisns\apps\widgets\formInputs\comboText\ComboTextInputWidget */

$options        = $widget->clientOptions;
$clientOptions  = \yii\helpers\Json::encode($options);
?>
<div id="<?= $widget->id; ?>">
    <div class="sx-select-controll">
        <? if ($widget->modelAttributeSaveType) : ?>
            <?= \yii\helpers\Html::activeRadioList($widget->model, $widget->modelAttributeSaveType, \yiisns\apps\widgets\formInputs\comboText\ComboTextInputWidget::editors())?>
        <? else : ?>
            <?= \yii\helpers\Html::radioList(
                $widget->id . '-radio',
                $widget->defaultEditor,
                \yiisns\apps\widgets\formInputs\comboText\ComboTextInputWidget::editors()
            )?>
        <? endif; ?>
    </div>
    <div class="sx-controll">
        <?= $textarea; ?>
    </div>
</div>

<?
//TODO: убрать в файл


$this->registerCss(<<<CSS
    .CodeMirror
    {
        height: 400px;
    }
CSS
);


$this->registerJs(<<<JS
(function(sx, $, _)
{
    new sx.classes.combotext.ComboTextInputWidget({$clientOptions});
})(sx, sx.$, sx._);
JS
)
?>
