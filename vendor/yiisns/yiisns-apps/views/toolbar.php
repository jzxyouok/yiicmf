<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 20.03.2016
 */
/* @var $this yii\web\View */
use \yiisns\apps\helpers\UrlHelper;
$clientOptionsJson = \yii\helpers\Json::encode($clientOptions);
?>
<div id="yiisns-toolbar" class="yiisns-toolbar-top hidden-print" <?= \Yii::$app->toolbar->isOpen != \yiisns\kernel\base\AppCore::BOOL_Y ? "style='display: none;'": ""?>>
    <div class="yiisns-toolbar-block title">
        <a href="<?= \Yii::$app->appSettings->descriptor->homepage; ?>" title="<?=\Yii::t('yiisns/kernel', 'The current version {app} ', ['app' => 'YiiSNS'])?> <?= \Yii::$app->appSettings->descriptor->version; ?>" target="_blank">
            <img width="29" height="30" alt="" src="<?= \Yii::$app->appSettings->logo(); ?>">
             <span class="label"><?= \Yii::$app->appSettings->descriptor->version; ?></span>
        </a>
    </div>
    <? if (\Yii::$app->user->can(\yiisns\rbac\SnsManager::PERMISSION_ADMIN_ACCESS)) : ?>
        <div class="yiisns-toolbar-block">
            <a href="<?= UrlHelper::construct('')->enableAdmin()->toString(); ?>" title="<?=\Yii::t('yiisns/kernel', 'Go to the administration panel')?>"><span class="label label-info"><?=\Yii::t('yiisns/kernel', 'Administration')?></span></a>
        </div>
    <? endif; ?>
    <? if (\Yii::$app->user->can('admin/admin-settings')) : ?>
        <div class="yiisns-toolbar-block">
            <a onclick="new sx.classes.toolbar.Dialog('<?= $urlSettings; ?>'); return false;" href="<?= $urlSettings; ?>" title="<?=\Yii::t('yiisns/kernel', 'Managing project settings')?>"><span class="label label-info"><?=\Yii::t('yiisns/kernel', 'Project settings')?></span></a>
        </div>
    <? endif; ?>
    <div class="yiisns-toolbar-block sx-profile">
        <a href="<?= $urlUserEdit; ?>" onclick="new sx.classes.toolbar.Dialog('<?= $urlUserEdit; ?>'); return false;" title="<?=\Yii::t('yiisns/kernel', 'It is you, go to edit your data')?>">
            <img src="<?= \yiisns\apps\helpers\Image::getSrc(\Yii::$app->user->identity->avatarSrc); ?>"/>
            <span class="label label-info"><?= \Yii::$app->user->identity->displayName; ?></span>
        </a>
        <?= \yii\helpers\Html::a('<span class="label">'.\Yii::t('yiisns/kernel', 'Exit').'</span>', UrlHelper::construct("admin/auth/logout")->enableAdmin()->setCurrentRef(), ["data-method" => "post"])?>
    </div>
    <? if ($editUrl) : ?>
        <div class="yiisns-toolbar-block">
            <a href="<?= $editUrl; ?>" onclick="new sx.classes.toolbar.Dialog('<?= $editUrl; ?>'); return false;" title="<?=\Yii::t('yiisns/kernel', 'Edit the current page')?>">
                 <span class="label"><?=\Yii::t('yiisns/kernel', 'Edit')?></span>
            </a>
        </div>
    <? endif; ?>
    <? if (\Yii::$app->user->can('admin/admin-settings')) : ?>
        <div class="yiisns-toolbar-block">
            <input type="checkbox" value="1" onclick="sx.Toolbar.triggerEditWidgets();" <?= \Yii::$app->toolbar->editWidgets == \yiisns\kernel\base\AppCore::BOOL_Y ? 'checked' : ''; ?>/>
            <span><?=\Yii::t('yiisns/kernel', 'Editing widgets')?></span>
        </div>
    <? endif; ?>
    <? if (\Yii::$app->user->can(\yiisns\rbac\SnsManager::PERMISSION_EDIT_VIEW_FILES)) : ?>
        <div class="yiisns-toolbar-block">
            <input type="checkbox" value="1" onclick="sx.Toolbar.triggerEditViewFiles();" <?= \Yii::$app->toolbar->editViewFiles == \yiisns\kernel\base\AppCore::BOOL_Y ? 'checked' : ''; ?>/>
            <span><?=\Yii::t('yiisns/kernel', 'Editing view files')?></span>
        </div>
    <? endif; ?>
    <? if (\Yii::$app->user->can('admin/clear')) : ?>
        <?
            $clearCacheOptions = \yii\helpers\Json::encode([
                'backend' => UrlHelper::construct(['/admin/clear/index'])->enableAdmin()->toString()
            ]);

        $this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.ClearCache = sx.classes.Component.extend({

        execute: function(code)
        {
            this.ajaxQuery = sx.ajax.preparePostQuery(this.get('backend'), {
                'code' : code
            });

            var Handler = new sx.classes.AjaxHandlerStandartRespose(this.ajaxQuery);

            this.ajaxQuery.execute();
        }
    });

    sx.ClearCache = new sx.classes.ClearCache({$clearCacheOptions});

})(sx, sx.$, sx._);
JS
);
        ?>
        <div class="yiisns-toolbar-block">
            <a href="#" onclick="sx.ClearCache.execute(); return false;" title="<?=\Yii::t('yiisns/kernel', 'Clear cache and temporary files')?>">
                 <span class="label label-info"><?=\Yii::t('yiisns/kernel', 'Clear cache')?></span>
            </a>
            <span></span>
        </div>
    <? endif; ?>
    <span class="yiisns-toolbar-toggler" onclick="sx.Toolbar.close(); return false;">›</span>
</div>

<div id="yiisns-toolbar-min" <?= \Yii::$app->toolbar->isOpen == \yiisns\kernel\base\AppCore::BOOL_Y ? "style='display: none;'": ""?>>
    <a href="#" onclick="sx.Toolbar.open(); return false;" title="<?=\Yii::t('yiisns/kernel', 'Open the Control Panel {app}',['app' => 'YiiSNS'])?>" id="yiisns-toolbar-logo">
        <img width="29" height="30" alt="" src="<?= \Yii::$app->appSettings->logo(); ?>">
    </a>
    <span class="yiisns-toolbar-toggler" onclick="sx.Toolbar.open(); return false;">‹</span>
</div>
<?
$this->registerJs(<<<JS
    (function(sx, $, _)
    {
        sx.Toolbar = new sx.classes.Toolbar({$clientOptionsJson});
    })(sx, sx.$, sx._);
JS
);
?>