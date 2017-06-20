<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.03.2016
 *
 * @var $component \yiisns\kernel\base\Component
 */
/* @var $this yii\web\View */
?>

<?= $this->render('_header', ['component' => $component]); ?>
    <div class="sx-box sx-mb-10 sx-p-10">
        <? if ($settings = \yiisns\kernel\models\ComponentSettings::fetchByComponentDefault($component)) : ?>
            <button type="submit" class="btn btn-danger btn-xs" onclick="sx.ComponentSettings.Remove.removeDefault(); return false;">
                <i class="glyphicon glyphicon-remove"></i> <?=\Yii::t('yiisns/kernel', 'Reset Default Settings')?>
            </button>
            <small><?=\Yii::t('yiisns/kernel', 'The settings for this component are stored in the database. The action will erase them from the database, make the component restore the default values.')?></small>
        <? else: ?>
            <small><?=\Yii::t('yiisns/kernel', 'These settings not yet saved in the database')?></small>
        <? endif; ?>
    </div>
    <? $form = \yiisns\admin\widgets\form\ActiveFormUseTab::begin(); ?>
        <?= $component->renderConfigForm($form); ?>
        <?= $form->buttonsStandart($component); ?>
    <? \yiisns\admin\widgets\form\ActiveFormUseTab::end(); ?>
<?= $this->render('_footer'); ?>