<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 26.05.2016
 */
?>
<? $form = \yiisns\admin\widgets\filters\AdminFiltersForm::begin([
    'action' => '/' . \Yii::$app->request->pathInfo,
]); ?>

    <?= $form->field($searchModel, 'name')->setVisible(true)->textInput([
        'placeholder' => \Yii::t('yiisns/kernel', 'Search by name')
    ]) ?>

    <?= $form->field($searchModel, 'id') ?>

    <?= $form->field($searchModel, 'code'); ?>

    <?= $form->field($searchModel, 'active')->listBox(\yii\helpers\ArrayHelper::merge([
        '' => ' - '
    ], \Yii::$app->appCore->booleanFormat()), [
        'size' => 1
    ]); ?>

<? $form::end(); ?>