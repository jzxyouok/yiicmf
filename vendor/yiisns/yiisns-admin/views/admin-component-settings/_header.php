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

$this->registerCss(<<<CSS
li.divider
{
    height: 5px;
    margin: 0;
    background-color: #f8f9fa;
    border-top: 1px solid #d1d4d7;
    border-bottom: 1px solid #d1d4d7;
}
CSS
);
?>
<?
$clientSettings = [
    'remove' =>
    [
        'backend' => \yii\helpers\Url::to('remove') . "?" . http_build_query(\Yii::$app->request->get()),
    ],
    'cache' =>
    [
        'backend' => \yii\helpers\Url::to('cache') . "?" . http_build_query(\Yii::$app->request->get())
    ]
];

$componentSettingsJson = \yii\helpers\Json::encode($clientSettings);

$this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.createNamespace('classes', sx);

    sx.classes.ComponentSettings = sx.classes.Component.extend({

        _init: function()
        {
            this.Remove     = new sx.classes.ComponentSettingsRemove(this.get('remove'));
            this.Cache      = new sx.classes.ComponentSettingsCache(this.get('cache'));
        },
    });

    /**
    * Deleting settings
    */
    sx.classes.ComponentSettingsRemove = sx.classes.Component.extend({

        _init: function()
        {
            this.ajaxQuery      = sx.ajax.preparePostQuery(this.get('backend'));
            this.ajaxHandler    = new sx.classes.AjaxHandlerStandartRespose(this.ajaxQuery);

            this.ajaxHandler.bind('success', function(data, response)
            {
                window.location.reload();
            });
        },

        removeAll: function()
        {
            this.ajaxQuery.setData({
                'do': 'all'
            });

            this.ajaxQuery.execute();
        },

        removeDefault: function()
        {
            this.ajaxQuery.setData({
                'do': 'default'
            });

            this.ajaxQuery.execute();
        },

        removeSites: function()
        {
            this.ajaxQuery.setData({
                'do': 'sites'
            });

            this.ajaxQuery.execute();
        },

        removeUsers: function()
        {
            this.ajaxQuery.setData({
                'do': 'users'
            });

            this.ajaxQuery.execute();
        },

        removeBySite: function(site_code)
        {
            this.ajaxQuery.setData({
                'do': 'site',
                'code': site_code,
            });

            this.ajaxQuery.execute();
        },

        removeByUser: function(user_id)
        {
            this.ajaxQuery.setData({
                'do': 'user',
                'id': user_id,
            });

            this.ajaxQuery.execute();
        },
    });

    /**
    * removing settings
    */
    sx.classes.ComponentSettingsCache = sx.classes.Component.extend({

        _init: function()
        {
            this.ajaxQuery      = sx.ajax.preparePostQuery(this.get('backend'));
            this.ajaxHandler    = new sx.classes.AjaxHandlerStandartRespose(this.ajaxQuery);
        },

        clearAll: function()
        {
            this.ajaxQuery.setData({
                'do': 'all'
            });

            this.ajaxQuery.execute();
        },
    });

    sx.ComponentSettings = new sx.classes.ComponentSettings({$componentSettingsJson});
})(sx, sx.$, sx._);
JS
);
?>
<!--<h1>Management: < ? = //$component->descriptor->name; ? ></h1><hr />  -->
    <div class="row">
        <div class="col-lg-2">
            <ul class="nav nav-pills nav-stacked">
              <li role="presentation" class="<?= in_array(\Yii::$app->controller->action->id, ['index']) ? 'active' : '' ?>"><a href="<?= \yii\helpers\Url::to('index') . '?' . http_build_query(\Yii::$app->request->get()); ?>">
                 <i class="glyphicon glyphicon-asterisk"></i> <?=\Yii::t('yiisns/kernel', 'The default settings')?>
              </a></li>

                <? if (\yiisns\kernel\models\Site::find()->active()->count() > 1) : ?>
                  <li role="presentation" class="<?= in_array(\Yii::$app->controller->action->id, ['sites', 'site']) ? 'active' : '' ?>"><a href="<?= \yii\helpers\Url::to('sites') . '?' . http_build_query(\Yii::$app->request->get()); ?>">
                     <i class="glyphicon glyphicon-globe"></i> <?=\Yii::t('yiisns/kernel', 'Sites settings')?>
                  </a></li>
                <? endif; ?>

                <li role="presentation" class="<?= in_array(\Yii::$app->controller->action->id, ['users', 'user']) ? 'active' : '' ?>"><a href="<?= \yii\helpers\Url::to('users') . '?' . http_build_query(\Yii::$app->request->get()); ?>">
                    <i class="glyphicon glyphicon-user"></i> <?=\Yii::t('yiisns/kernel', 'Users settings')?>
                </a></li>
              <!--<li role="presentation" class="<?/*= \Yii::$app->controller->action->id == 'langs' ? 'active' : '' */?>"><a href="#">Language Settings</a></li>-->
              <!--<li role="presentation"><a href="#">Language Settings</a></li>-->
                <li class="divider"></li>
                <li role="presentation" class="<?= in_array(\Yii::$app->controller->action->id, ['cache']) ? 'active' : '' ?>"><a href="<?= \yii\helpers\Url::to('cache') . '?' . http_build_query(\Yii::$app->request->get()); ?>">
                   <i class="glyphicon glyphicon-retweet"></i> <?=\Yii::t('yiisns/kernel', 'Clearing cache')?></a>
                </li>

                <li role="presentation" class="<?= in_array(\Yii::$app->controller->action->id, ['remove']) ? 'active' : '' ?>"><a href="<?= \yii\helpers\Url::to('remove') . '?' . http_build_query(\Yii::$app->request->get()); ?>">
                   <i class="glyphicon glyphicon-remove"></i> <?=\Yii::t('yiisns/kernel', 'Remove{s}Recovery',['s' => '/'])?></a>
                </li>
            </ul>
        </div>
        <div class="col-lg-10">