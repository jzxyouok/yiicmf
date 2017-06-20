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

    <?= $form->field($model, 'treeIds')->widget(
        \yiisns\apps\widgets\formInputs\selectTree\SelectTreeInputWidget::class,
        [
            'multiple' => true
        ]
    ); ?>

    <?= \yii\helpers\Html::checkbox('removeCurrent', false); ?> <label><?=\Yii::t('yiisns/kernel','Get rid of the already linked (in this case, the selected records bind only to the selected section)')?></label>
    <?= $form->buttonsStandart($model, ['save']);?>

<? \yiisns\admin\widgets\ActiveForm::end(); ?>


<? \yii\bootstrap\Alert::begin([
    'options' => [
        'class' => 'alert-info',
        'style' => 'margin-top: 20px;',
    ],
])?>
    <p><?=\Yii::t('yiisns/kernel','You can specify some additional sections that will show your records.')?></p>
    <p><?=\Yii::t('yiisns/kernel','This does not affect the final address of the page, and hence safe.')?></p>
<? \yii\bootstrap\Alert::end(); ?>