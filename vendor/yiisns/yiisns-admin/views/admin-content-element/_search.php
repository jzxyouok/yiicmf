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
    'namespace' => \Yii::$app->controller->uniqueId . "_" . $content_id
]); ?>

    <?= \yii\helpers\Html::hiddenInput('content_id', $content_id) ?>

    <?= $form->field($searchModel, 'id'); ?>

    <?= $form->field($searchModel, 'q')->textInput([
        'placeholder' => \Yii::t('yiisns/kernel', 'Search name and description')
    ])->setVisible(); ?>

    <?= $form->field($searchModel, 'name')->textInput([
        'placeholder' => \Yii::t('yiisns/kernel', 'Search by name')
    ]) ?>

    <?= $form->field($searchModel, 'active')->listBox(\yii\helpers\ArrayHelper::merge([
        '' => ' - '
    ], \Yii::$app->appCore->booleanFormat()), [
        'size' => 1
    ]); ?>

    <?= $form->field($searchModel, 'section')->listBox(\yii\helpers\ArrayHelper::merge([
        '' => ' - '
    ], \yiisns\apps\helpers\TreeOptions::getAllMultiOptions()),
    [
        'unselect' => ' - ',
        'size' => 1
    ]); ?>


    <?= $form->field($searchModel, 'has_image')->checkbox(\Yii::$app->formatter->booleanFormat, false); ?>
    <?= $form->field($searchModel, 'has_full_image')->checkbox(\Yii::$app->formatter->booleanFormat, false); ?>


    <?= $form->field($searchModel, 'created_by')->widget(\yiisns\admin\widgets\formInputs\SelectModelDialogUserInput::className()); ?>
    <?= $form->field($searchModel, 'updated_by')->widget(\yiisns\admin\widgets\formInputs\SelectModelDialogUserInput::className()); ?>


    <?= $form->field($searchModel, 'created_at_from')->widget(
        \kartik\datetime\DateTimePicker::className()
    ); ?>
    <?= $form->field($searchModel, 'created_at_to')->widget(
        \kartik\datetime\DateTimePicker::className()
    ); ?>

    <?= $form->field($searchModel, 'updated_at_from')->widget(
        \kartik\datetime\DateTimePicker::className()
    ); ?>
    <?= $form->field($searchModel, 'updated_at_to')->widget(
        \kartik\datetime\DateTimePicker::className()
    ); ?>

    <?= $form->field($searchModel, 'published_at_from')->widget(
        \kartik\datetime\DateTimePicker::className()
    ); ?>
    <?= $form->field($searchModel, 'published_at_to')->widget(
        \kartik\datetime\DateTimePicker::className()
    ); ?>

    <?= $form->field($searchModel, 'code'); ?>


    <?
        $searchRelatedPropertiesModel = new \yiisns\kernel\models\searchs\SearchRelatedPropertiesModel();
        $searchRelatedPropertiesModel->initProperties($content->contentProperties);
        $searchRelatedPropertiesModel->load(\Yii::$app->request->get());
    ?>
    <?= $form->relatedFields($searchRelatedPropertiesModel); ?>

<? $form::end(); ?>