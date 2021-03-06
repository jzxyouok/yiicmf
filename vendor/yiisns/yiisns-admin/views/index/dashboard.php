<?php
/* @var $this yii\web\View */
/* @var $dashboard yiisns\kernel\models\Dashboard */
$this->title = $dashboard->name . ' - ' . \Yii::t('yiisns/kernel', 'Dashboard');

$this->registerCss(<<<CSS
.sx-dashboard-head
{
    padding: 10px 0;
    margin-bottom: 10px;
    border-left: 1px solid rgba(255, 255, 255, 0.46);
}

.sx-dashboard table tr td.sx-columns
{
    vertical-align: top;
}

.sx-dashboard table tr td.sx-first
{
    padding-left: 0;
}

#sx-dashboard-table {
    width: 100%;
}

.sx-dashboard-body
{
    margin-top: 10px;
}

CSS
);

$sortableString = [];
?>
<div class="col-md-12 sx-dashboard" id="sx-dashboard">
    <? if (\Yii::$app->user->can(\yiisns\rbac\SnsManager::PERMISSION_ADMIN_DASHBOARDS_EDIT)) : ?>
        <?= $this->render('_head', ['dashboard' => $dashboard]); ?>
    <? endif; ?>
    <div class="row sx-dashboard-body">
		<div class="col-lg-12 col-md-12">
            <? if (!$dashboard->dashboardWidgets) : ?>
                <?= yii\bootstrap\Alert::widget(['options' => ['class' => 'alert-info'], 'body' => \yii\helpers\Html::tag('h1', \Yii::t('yiisns/kernel', 'Welcome! You are in the site management system.'))]); ?>
            <? else : ?>          
                <table id="sx-dashboard-table">
				<tr>
                        <? for($i = 1; $i <= $dashboard->columns; $i++) : ?>
                            <? $sortableString[] = "#sx-column-" . $i; ?>
                            <td style="width: <? echo round(100/$dashboard->columns); ?>%;" id="sx-column-<?= $i; ?>" class="sx-columns <?= $i == 1 ? "sx-first": ""?>" data-column="<?= $i; ?>">
                                <? $widgets = $dashboard->getDashboardWidgets()->andWhere(['dashboard_column' => $i])->orderBy(['priority' => SORT_ASC])->all(); ?>
                                <? if ($widgets) : ?>
                                    <? foreach($widgets as $dashboardWidget) : ?>
                                        <? if (\Yii::$app->user->can(\yiisns\rbac\SnsManager::PERMISSION_ADMIN_DASHBOARDS_EDIT)) : ?>
                                        <? 
                                        $widgetData = $dashboardWidget->toArray(['id']); 
                                        $requestData = ['pk' => $dashboardWidget->id];
                                        $widgetData = \yii\helpers\ArrayHelper::merge($widgetData, [
                                        'editConfigUrl' => \yiisns\apps\helpers\UrlHelper::construct('/admin/index/edit-dashboard-widget', $requestData)->setSystemParam(\yiisns\admin\Module::SYSTEM_QUERY_EMPTY_LAYOUT, 'true')
                                        ->enableAdmin()
                                        ->toString()
                                ]);
                                
                                $widgetData = \yii\helpers\Json::encode($widgetData);
                                
                                $openClose = \Yii::t('yiisns/kernel', 'Expand/Collapse');
                                
                                $actions = <<<HTML
<a href="#sx-permissions-for-controller" onclick='sx.Dashboard.editConfigWidget({$widgetData}); return false;'>
    <i class="glyphicon glyphicon-cog" data-sx-widget="tooltip-b" data-original-title="call" style="color: white;"></i>
</a>

<a href="#" class="sx-btn-trigger-full">
    <i class="glyphicon glyphicon-fullscreen" data-sx-widget="tooltip-b" data-original-title="{$openClose}" style="color: white;"></i>
</a>

<a href="#sx-permissions-for-controller" onclick='sx.Dashboard.removeWidget({$widgetData}); return false;'>
    <i class="glyphicon glyphicon-remove" data-sx-widget="tooltip-b" data-original-title="delete" style="color: white;"></i>
</a>
HTML;
                                ?>
                                        <? endif; ?>
                                        <?
                            \yiisns\admin\widgets\AdminPanelWidget::begin([
                                'name' => $dashboardWidget->name,
                                'actions' => $actions,          
                                'options' => [
                                    'class' => 'sx-dashboard-widget',
                                    'data' => $dashboardWidget->toArray([
                                        'id'
                                    ])
                                ]
                            ]);
                            ?>
                                            <? if ($dashboardWidget->widget) : ?>
                                                <?= $dashboardWidget->widget->run(); ?>
                                            <? else : ?>
                                                Widget removed
                                            <? endif; ?>
                                        <? \yiisns\admin\widgets\AdminPanelWidget::end(); ?>
                                    <? endforeach; ?>

                                <? endif; ?>
                            </td>
                            <? if ($dashboard->columns > 1 && $i != $dashboard->columns) : ?>
                                <td width="20">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <? endif; ?>
                        <? endfor; ?>
                    </tr>
			</table>
            <? endif; ?>
        </div>
	</div>
</div>
<? if (\Yii::$app->user->can(\yiisns\rbac\SnsManager::PERMISSION_ADMIN_DASHBOARDS_EDIT)) : ?>
    <?   
    $this->registerCss(<<<CSS
.sx-panel .panel-heading
{
    cursor: move;
}
CSS
);
    \yii\jui\Sortable::widget();
    
    $sortableString = implode(', ', $sortableString);
    
    $jsonData = \yii\helpers\Json::encode([
        'model' => $dashboard,
        'sortableSelector' => $sortableString,
        'backendPrioritySave' => \yiisns\apps\helpers\UrlHelper::construct([
            '/admin/index/widget-priority-save',
            'pk' => $dashboard->id
        ])->enableAdmin()->toString(),
        'backendWidgetRemove' => \yiisns\apps\helpers\UrlHelper::construct([
            '/admin/index/widget-remove'
        ])->enableAdmin()->toString()
    ]);
    
    $this->registerJs(<<<JS

    (function(sx, $, _)
    {
        sx.classes.Dashboard = sx.classes.Component.extend({

            _init: function()
            {
                var self = this;

                this.bind('change', function(e, data)
                {
                    self.save();
                });
            },

            _onDomReady: function()
            {
                this._initSortable();


            },

            /**
            *
            * @returns {*|HTMLElement}
            */
            getJWrapper: function()
            {
                return $('#sx-dashboard');
            },

            /**
            *
            * @returns {{}|*}
            */
            getData: function()
            {
                data = {};

                $('table tr td.sx-columns', this.getJWrapper()).each(function()
                {
                    var ids = [];
                    $(".sx-dashboard-widget", $(this)).each(function()
                    {
                        ids.push($(this).data('id'));
                    });

                    data[ $(this).data('column') ] = ids;
                });

                return data;
            },

            save: function()
            {
                var self = this;
                var data = self.getData();

                var ajax = sx.ajax.preparePostQuery(this.get('backendPrioritySave'), data);

                new sx.classes.AjaxHandlerNoLoader(ajax);

                new sx.classes.AjaxHandlerStandartRespose(ajax, {
                    'enableBlocker' : true,
                    'blockerSelector' : this.getJWrapper()
                });

                ajax.onError(function(e, data)
                {
                    sx.notify.info("Now the page will restart, wait a moment...");
                    _.delay(function()
                    {
                        //window.location.reload();
                    }, 2000);
                })
                .onSuccess(function(e, data)
                {
                    //blocker.unblock();
                })
                .execute();
            },


            editConfigWidget: function(data)
            {
                new sx.classes.DashboardWidget(this, data).editConfig();
            },

            removeWidget: function(data)
            {
                new sx.classes.DashboardWidget(this, data).remove();
            },

            _initSortable: function()
            {
                var self = this;

                $(self.get('sortableSelector')).sortable(
                {
                    connectWith: ".sx-columns",
                    cursor: "move",
                    handle: ".panel-heading",
                    forceHelperSize: true,
                    forcePlaceholderSize: true,
                    //delay: 150,
                    opacity: 0.5,
                    placeholder: "ui-state-highlight",
                    stop: function( event, ui )
                    {
                        self.trigger('change', {
                            'event' : event,
                            'ui' : ui,
                        });
                    }

                }).disableSelection();
            }
        });

        sx.Dashboard = new sx.classes.Dashboard({$jsonData});


        sx.classes.DashboardWidget = sx.classes.Component.extend({

            construct: function (Dashboard, opts)
            {
                var self = this;
                opts = opts || {};
                this.Dashboard = Dashboard;
                //this.parent.construct(opts);
                this.applyParentMethod(sx.classes.Component, 'construct', [opts]); // TODO: make a workaround for magic parent calling
            },

            _init: function()
            {
                var self = this;
            },

            /**
            *
            * @returns {*|HTMLElement}
            */
            getJWrapper: function()
            {
                return $('.sx-dashboard-widget[data-id=' + this.get('id') + ']');
            },

            remove: function()
            {
                var self = this;
                var jWrapper = this.getJWrapper();

                var ajax = sx.ajax.preparePostQuery(this.Dashboard.get('backendWidgetRemove'), {
                    'id' : this.get('id')
                });

                new sx.classes.AjaxHandlerNoLoader(ajax);

                var Handler = new sx.classes.AjaxHandlerStandartRespose(ajax, {
                    'enableBlocker' : true,
                    'blockerSelector' : jWrapper
                });

                Handler.bind('success', function()
                {
                    jWrapper.fadeOut('fast', function()
                    {
                        $(this).remove();
                    });
                });

                ajax.onError(function(e, data)
                {
                    sx.notify.info("let the page be rebooted");
                    _.delay(function()
                    {
                        //window.location.reload();
                    }, 2000);
                })
                .onSuccess(function(e, data)
                {})
                .execute();
            },

            editConfig: function()
            {
                this.Window = new sx.classes.Window(this.get('editConfigUrl'), 'sx-edit-widget-' + this.get('id'));
                this.Window.open();

                this.Window.bind('close', function()
                {
                    window.location.reload();
                });
            }
        });

    })(sx, sx.$, sx._);

JS
);
    ?>
<? endif; ?>