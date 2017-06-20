<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.03.2016
 */
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model \yiisns\LogDbTarget\components\LogDbTargetSettings */
?>

<?= $form->fieldSet(\Yii::t('yiisns/logdb', 'Logging options')); ?>

    <?= $form->fieldRadioListBoolean($model, 'enabled'); ?>

    <?= $form->field($model, 'levels')->checkboxList(\yiisns\LogDbTarget\components\LogDbTargetSettings::$levelMap); ?>

    <?= $form->field($model, 'logVars')->checkboxList([
        '_GET' => '_GET',
        '_POST' => '_POST',
        '_FILES' => '_FILES',
        '_COOKIE' => '_COOKIE',
        '_SESSION' => '_SESSION',
        '_SERVER' => '_SERVER',
    ]); ?>

    <?= $form->field($model, 'exceptString')->textarea(); ?>
    <?= $form->field($model, 'categoriesString')->textarea(); ?>
    <?= $form->field($model, 'exportInterval'); ?>

<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet(\Yii::t('yiisns/logdb', 'Cleaning logs')); ?>
    <?= $form->fieldInputInt($model, 'storeLogsTime')->hint(\Yii::t('yiisns/logdb', 'If you do not want to deleted all logs, set to 0.')); ?>
<?= $form->fieldSetEnd(); ?>