<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.03.2015
 *
 * @var $component \yiisns\kernel\base\Component
 * @var $user \yiisns\kernel\models\User
 */
/* @var $this yii\web\View */
?>

<?= $this->render('_header', [
    'component' => $component
]); ?>


    <h2><?=\Yii::t('yiisns/kernel','User settings')?>: <?= $user->getDisplayName() ?></h2>
    <div class="sx-box sx-mb-10 sx-p-10">
        <? if ($settings = \yiisns\kernel\models\ComponentSettings::fetchByComponentUserId($component, $user->id)) : ?>
            <button type="submit" class="btn btn-danger btn-xs" onclick="sx.ComponentSettings.Remove.removeByUser('<?= $user->id; ?>'); return false;">
                <i class="glyphicon glyphicon-remove"></i> <?=\Yii::t('yiisns/kernel','Reset settings for this user')?>
            </button>
            <small><?=\Yii::t('yiisns/kernel','The settings for this component are stored in the database. This option will erase them from the database, but the component, restore the default values. As they have in the code the developer.')?></small>
        <? else: ?>
            <small><?=\Yii::t('yiisns/kernel','These settings not yet saved in the database')?></small>
        <? endif; ?>
    </div>

    <? $form = \yiisns\admin\widgets\form\ActiveFormUseTab::begin(); ?>
        <?= $component->renderConfigForm($form); ?>
        <?= $form->buttonsStandart($component); ?>
    <? \yiisns\admin\widgets\form\ActiveFormUseTab::end(); ?>


<?= $this->render('_footer'); ?>
