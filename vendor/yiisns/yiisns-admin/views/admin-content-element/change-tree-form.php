<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 14.10.2016
 */
$model = new \yiisns\kernel\models\ContentElement();
?>
<? $form = \yiisns\admin\widgets\ActiveForm::begin(); ?>

    <?= $form->field($model, 'tree_id')->widget(
        \yiisns\apps\widgets\formInputs\selectTree\SelectTreeInputWidget::class
    ); ?>

    <?/*= $form->fieldSelect($model, 'tree_id', \yiisns\apps\helpers\TreeOptions::getAllMultiOptions());*/?>
    <?= $form->buttonsStandart($model, ['save']);?>

<? \yiisns\admin\widgets\ActiveForm::end(); ?>


<? \yii\bootstrap\Alert::begin([
    'options' => [
        'class' => 'alert-warning',
        'style' => 'margin-top: 20px;',
    ],
])?>
    <p><?=\Yii::t('yiisns/kernel','Attention! For checked items will be given a new primary section.')?></p>
    <p><?=\Yii::t('yiisns/kernel','This will alter the page record, and it will cease to be available at the old address.')?></p>
<? \yii\bootstrap\Alert::end(); ?>