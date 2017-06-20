<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 31.10.2016
 */
/* @var $this yii\web\View */
/* @var $context \yiisns\admin\actions\modelEditor\AdminMultiDialogModelEditAction */
$context = $this->context;
?>
<? \yii\bootstrap\Modal::begin([
    'header' => '<b>' . $context->name . '</b>',
    'size' => \yii\bootstrap\Modal::SIZE_LARGE,
    'id' => $dialogId,
]); ?>
    <?= $content; ?>
<? \yii\bootstrap\Modal::end(); ?>
<?/* echo \yii\helpers\Html::tag('div', $content, \yii\helpers\ArrayHelper::merge($context->dialogOptions, [
    'id' => $dialogId
])); */?>