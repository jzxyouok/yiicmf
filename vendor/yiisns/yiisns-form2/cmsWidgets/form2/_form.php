<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.05.2016
 */
/* @var $this yii\web\View */
?>
<?= $form->fieldSet('Settings'); ?>

    <?/*= $form->fieldSelect($model, 'form_id', \yii\helpers\ArrayHelper::map(
        \yiisns\form2\models\Form2Form::find()->all(),
        'id',
        'name'
    )); */?>

    <?= $form->field($model, 'form_id')->widget(
        \yiisns\apps\widgets\formInputs\EditedSelect::className(),
        [
            'controllerRoute' => '/form2/admin-form',
            'items' => \yii\helpers\ArrayHelper::map(
            \yiisns\form2\models\Form2Form::find()->all(),
                'id',
                'name'
            ),
        ]
    ); ?>
    <?= $form->field($model, 'btnSubmit')->textInput(); ?>
    <?= $form->field($model, 'btnSubmitClass')->textInput(); ?>
<?= $form->fieldSetEnd(); ?>