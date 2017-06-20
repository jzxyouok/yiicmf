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
    <?= $form->field($searchModel, 'level')->listBox(\yii\helpers\ArrayHelper::merge(['' => \Yii::t('yiisns/logdb', 'All levels')], [
            \yii\log\Logger::LEVEL_ERROR => 'error',
            \yii\log\Logger::LEVEL_WARNING => 'warning',
            \yii\log\Logger::LEVEL_INFO => 'info',
            \yii\log\Logger::LEVEL_TRACE => 'trace',
            \yii\log\Logger::LEVEL_PROFILE_BEGIN => 'profile begin',
            \yii\log\Logger::LEVEL_PROFILE_END => 'profile end',
        ]), ['size' => 1])->setVisible(); ?>
    <?= $form->field($searchModel, 'category'); ?>
    <?= $form->field($searchModel, 'message'); ?>
<? $form::end(); ?>