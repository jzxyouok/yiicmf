<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.03.2016
 */
use yiisns\mail\helpers\Html;
/**
 *
 * @var $formSend \yiisns\form2\models\Form2FormSend
 * @var $form \yiisns\form2\models\Form2Form
 */
?>
<?= Html::beginTag('h1'); ?>
    <?= \Yii::t('yiisns/form2', 'Submitting forms');?>  «<?= \yii\helpers\Html::encode($form->name)?>» #<?= $formSend->id; ?>
<?= Html::endTag('h1'); ?>

<?= Html::beginTag('p'); ?>
    <?= \Yii::t('yiisns/form2', 'The form has been completed and successfully sent from the page');?>: <?= Html::a($formSend->page_url, $formSend->page_url); ?><br />
<?= \Yii::t('yiisns/form2', 'Date and time of sending');?>: <?= \Yii::$app->formatter->asDatetime($formSend->created_at) ?><br />
<?= \Yii::t('yiisns/form2', 'Unique message number');?>: <?= $formSend->id; ?>
<?= Html::endTag('p'); ?>

<?= Html::beginTag('h3'); ?>
    <?= \Yii::t('yiisns/form2', 'Data from form');?>:
<?= Html::endTag('h3'); ?>

<?= Html::beginTag('p'); ?>

<?
$attribures = [];
if ($attrs = $formSend->relatedPropertiesModel->attributeLabels()) {
    foreach ($attrs as $code => $value) {
        $data['attribute'] = $code;
        $data['format'] = 'raw';
        
        $value = $formSend->relatedPropertiesModel->getSmartAttribute($code);
        $data['value'] = $value;
        if (is_array($value)) {
            $data['value'] = implode(', ', $value);
        }
        
        $attribures[] = $data;
    }
};
?>
<?=\yii\widgets\DetailView::widget(['model' => $formSend->relatedPropertiesModel,'attributes' => $attribures])?>
<?= Html::endTag('p'); ?>
<?= Html::beginTag('h5'); ?>
    <?= \Yii::t('yiisns/form2', 'Additional Data');?>:
<?= Html::endTag('h5'); ?>
<?= Html::beginTag('p'); ?>
    <?= \Yii::t('yiisns/form2', 'Additional information on the report can be viewed');?> <?= Html::a(\Yii::t('yiisns/form2', 'here'), \yiisns\apps\helpers\UrlHelper::construct('form2/admin-form-send/update', ['pk' => $formSend->id])->enableAdmin()->enableAbsolute()->toString()); ?>.
<?= Html::endTag('p'); ?>