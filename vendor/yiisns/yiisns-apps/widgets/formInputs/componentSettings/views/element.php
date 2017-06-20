<?
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.06.2016
 */
/* @var $this yii\web\View */
/* @var $widget \yiisns\apps\widgets\formInputs\componentSettings\ComponentSettingsWidget */
/* @var $element string */

$options        = $widget->clientOptions;
$clientOptions  = \yii\helpers\Json::encode($options);
?>
<div id="<?= $widget->id; ?>">
    <div class="sx-select-controll">
        <?= $element; ?>
    </div>
    <a href="#" class="<?= $widget->buttonClasses; ?>">
        <i class="glyphicon glyphicon-cog"></i> <?= $widget->buttonText; ?>
    </a>
</div>

<?

$this->registerJs(<<<JS
(function(sx, $, _)
{
    new sx.classes.ComponentSettingsWidget({$clientOptions});
})(sx, sx.$, sx._);
JS
)
?>