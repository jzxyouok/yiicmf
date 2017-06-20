<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.05.2016
 */
/* @var $this yii\web\View */
?>
<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Showing')); ?>
    <?= $form->field($model, 'viewFile')->textInput(); ?>
<?= $form->fieldSetEnd(); ?>
<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Pagination')); ?>
    <?= $form->fieldRadioListBoolean($model, 'enabledPaging', \Yii::$app->appCore->booleanFormat()); ?>
    <?= $form->fieldRadioListBoolean($model, 'enabledPjaxPagination', \Yii::$app->appCore->booleanFormat()); ?>
    <?= $form->fieldInputInt($model, 'pageSize'); ?>
    <?= $form->fieldInputInt($model, 'pageSizeLimitMin'); ?>
    <?= $form->fieldInputInt($model, 'pageSizeLimitMax'); ?>
    <?= $form->field($model, 'pageParamName')->textInput(); ?>
<?= $form->fieldSetEnd(); ?>
<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Filtering')); ?>
    <?= $form->fieldSelect($model, 'active', \Yii::$app->appCore->booleanFormat(), [
        'allowDeselect' => true
    ]); ?>
    <?= $form->fieldSelect($model, 'enabledActiveTime', \Yii::$app->appCore->booleanFormat())->hint(\Yii::t('yiisns/kernel',"Will be considered time of beginning and end of the publication")); ?>

    <?= $form->fieldSelectMulti($model, 'createdBy', \yii\helpers\ArrayHelper::map(
        \yiisns\kernel\models\User::find()->active()->all(),
        'id',
        'name'
    )); ?>
    <?= $form->fieldSelectMulti($model, 'content_ids', \yiisns\kernel\models\Content::getDataForSelect()); ?>
    <?= $form->fieldRadioListBoolean($model, 'enabledCurrentTree', \Yii::$app->appCore->booleanFormat()); ?>
    <?= $form->fieldRadioListBoolean($model, 'enabledCurrentTreeChild', \Yii::$app->appCore->booleanFormat()); ?>
    <?= $form->fieldRadioListBoolean($model, 'enabledCurrentTreeChildAll', \Yii::$app->appCore->booleanFormat()); ?>
    <?= $form->field($model, 'tree_ids')->widget(
        \yiisns\apps\widgets\formInputs\selectTree\SelectTree::className(),
        [
            'mode' => \yiisns\apps\widgets\formInputs\selectTree\SelectTree::MOD_MULTI,
            'attributeMulti' => 'tree_ids'
        ]
    ); ?>
    <?= $form->fieldRadioListBoolean($model, 'enabledSearchParams', \Yii::$app->appCore->booleanFormat()); ?>
<?= $form->fieldSetEnd(); ?>
<?= $form->fieldSet(\Yii::t('yiisns/kernel','Sorting and quantity')); ?>
    <?= $form->fieldInputInt($model, 'limit'); ?>
    <?= $form->fieldSelect($model, 'orderBy', (new \yiisns\kernel\models\ContentElement())->attributeLabels()); ?>
    <?= $form->fieldSelect($model, 'order', [
        SORT_ASC    => "ASC (".\Yii::t('yiisns/kernel', 'from smaller to larger').")",
        SORT_DESC   => "DESC (".\Yii::t('yiisns/kernel', 'from highest to lowest').")",
    ]); ?>
<?= $form->fieldSetEnd(); ?>
<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Additionally')); ?>
    <?= $form->field($model, 'label')->textInput(); ?>
<?= $form->fieldSetEnd(); ?>
<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Cache settings')); ?>
    <?= $form->fieldRadioListBoolean($model, 'enabledRunCache', \Yii::$app->appCore->booleanFormat()); ?>
    <?= $form->fieldInputInt($model, 'runCacheDuration'); ?>
<?= $form->fieldSetEnd(); ?>