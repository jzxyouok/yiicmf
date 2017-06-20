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
        <p><?= \Yii::t('yiisns/kernel', 'Erase all the settings from the database for this component.')?></p>
        <? if ($settingsAllCount = \yiisns\kernel\models\ComponentSettings::baseQuery($component)->count()) : ?>
            <p><b><?=\Yii::t('yiisns/kernel', 'Total found')?>：</b> <?= $settingsAllCount; ?></p>
            <button type="submit" class="btn btn-danger btn-xs" onclick="sx.ComponentSettings.Remove.removeAll(); return false;">
                <i class="glyphicon glyphicon-remove"></i> <?=\Yii::t('yiisns/kernel', 'Reset all settings')?>
            </button>
        <? else: ?>
            <small><?= \Yii::t('yiisns/kernel', 'The database no settings for this component.')?></small>
        <? endif; ?>
    </div>
<?= $this->render('_footer'); ?>