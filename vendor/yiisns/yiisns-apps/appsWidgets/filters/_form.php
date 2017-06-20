<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.05.2016
 */
/* @var $this yii\web\View */
/* @var $contentType \yiisns\kernel\models\ContentType */
/* @var $model \yiisns\apps\appsWidgets\filters\ShopProductFiltersWidget */

?>
<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Showing')); ?>
    <?= $form->field($model, 'viewFile')->textInput(); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/kernel', 'Data source')); ?>
    <?= $form->fieldSelect($model, 'content_id', \yiisns\kernel\models\Content::getDataForSelect()); ?>

    <?/*= $form->fieldSelectMulti($model, 'searchModelAttributes', [
        'image' => \Yii::t('yiisns/kernel', 'Filter by photo'),
        'hasQuantity' => \Yii::t('yiisns/kernel', 'Filter by availability')
    ]); */?>

    <?/*= $form->field($model, 'searchModelAttributes')->dropDownList([
        'image' => \Yii::t('yiisns/kernel', 'Filter by photo'),
        'hasQuantity' => \Yii::t('yiisns/kernel', 'Filter by availability')
    ], [
'multiple' => true,
'size' => 4
]); */?>
    <? if ($model->content) : ?>
        <?= $form->fieldSelectMulti($model, 'realatedProperties', \yii\helpers\ArrayHelper::map($model->content->contentProperties, 'code', 'name')); ?>
    <? else: ?>
        The additional features will appear after the preservation.
    <? endif; ?>
<?= $form->fieldSetEnd(); ?>