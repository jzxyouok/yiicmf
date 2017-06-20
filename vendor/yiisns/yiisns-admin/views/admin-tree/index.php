<?
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 31.05.2016
 */
/* @var $this yii\web\View */

$this->registerCss(<<<CSS

.sx-tree ul li.sx-tree-node .row .sx-controll-node
{
    display: none;
    float: left;
}

.sx-tree ul li.sx-tree-node .row .sx-controll-node .sx-btn-caret-action
{
    width: 21px;
    height: 22px;
}
.sx-tree ul li.sx-tree-node .row .sx-controll-node .btn
{
    height: 22px;
}


.sx-tree ul li.sx-tree-node .row:hover .sx-controll-node
{
    display: block;
}

.btn-tree-node-controll
{
    font-size: 8px;
}

    .sx-tree ul li.sx-tree-node .sx-controll-node
    {
        width: auto;
        float: left;
        margin-left: 10px;
        padding-top: 0px;
    }

        .sx-tree ul li.sx-tree-node .sx-controll-node > .dropdown button
        {
            font-size: 6px;
            color: #000000;
            background: white;
            padding: 2px 4px;
        }

.sx-tree-move
{
    cursor: move;
}
CSS
);
?>
<div class="col-md-12">
<? $widget = \yiisns\apps\widgets\tree\TreeWidget::begin([
    'models'        => $models,
    'viewNodeContentFile'  => '@yiisns/admin/views/admin-tree/_tree-node',

    'pjaxClass'     => \yiisns\admin\widgets\Pjax::class,
    'pjaxOptions'   =>
    [
        'blockPjaxContainer' => false,
        'blockContainer' => '.sx-panel',
    ]
]); ?>
    <?
        \yii\jui\Sortable::widget();

        $options    = \yii\helpers\Json::encode([
            'id'                => $widget->id,
            'pjaxid'            => $widget->pjax->id,
            'backendNewChild'   => \yiisns\apps\helpers\UrlHelper::construct(['/admin/admin-tree/new-children'])->enableAdmin()->toString(),
            'backendResort'     => \yiisns\apps\helpers\UrlHelper::construct(['/admin/admin-tree/resort'])->enableAdmin()->toString()
        ]);


        $this->registerJs(<<<JS
        (function(window, sx, $, _)
        {
            sx.createNamespace('classes.tree.admin', sx);

            sx.classes.tree.admin.CmsTreeWidget = sx.classes.Component.extend({

                _init: function()
                {
                    var self = this;
                },

                _onDomReady: function()
                {
                    var self = this;
                    /*$('.sx-tree-node').on('dblclick', function(event)
                    {
                        event.stopPropagation();
                        $(this).find(".sx-row-action:first").click();
                    });*/

                    $(".sx-tree ul").find("ul").sortable(
                    {
                        cursor: "move",
                        handle: ".sx-tree-move",
                        forceHelperSize: true,
                        forcePlaceholderSize: true,
                        opacity: 0.5,
                        placeholder: "ui-state-highlight",

                        out: function( event, ui )
                        {
                            var Jul = $(ui.item).closest("ul");
                            var newSort = [];
                            Jul.children("li").each(function(i, element)
                            {
                                newSort.push($(this).data("id"));
                            });

                            var blocker = sx.block(Jul);

                            var ajax = sx.ajax.preparePostQuery(
                                self.get('backendResort'),
                                {
                                    "ids" : newSort,
                                    "changeId" : $(ui.item).data("id")
                                }
                            );

                            new sx.classes.AjaxHandlerNoLoader(ajax); //the global loader
                            new sx.classes.AjaxHandlerNotify(ajax, {
                                'error': "修改失败",
                                'success': "修改成功",
                            });

                            ajax.onError(function(e, data)
                            {
                                sx.notify.info("let the page be rebooted");
                                _.delay(function()
                                {
                                    window.location.reload();
                                }, 2000);
                            })
                            .onSuccess(function(e, data)
                            {
                                blocker.unblock();
                            })
                            .execute();
                        }
                    });

                    var self = this;

                    $('.add-tree-child').on('click', function()
                    {
                        var jNode = $(this);
                        sx.prompt("请输入区块的名称", {
                            'yes' : function(e, result)
                            {
                                var blocker = sx.block(jNode);

                                var ajax = sx.ajax.preparePostQuery(
                                        self.get('backendNewChild'),
                                        {
                                            "pid" : jNode.data('id'),
                                            "Tree" : {"name" : result},
                                            "no_redirect": true
                                        }
                                );

                                new sx.classes.AjaxHandlerNoLoader(ajax); //the global loader

                                new sx.classes.AjaxHandlerNotify(ajax, {
                                    'error': "添加区块失败",
                                    'success': "成功添加区块"
                                }); //the global loader

                                ajax.onError(function(e, data)
                                {
                                    $.pjax.reload('#' + self.get('pjaxid'), {});
                                    /*sx.notify.info("let the page be rebooted");
                                    _.delay(function()
                                    {
                                        window.location.reload();
                                    }, 2000);*/
                                })
                                .onSuccess(function(e, data)
                                {
                                    blocker.unblock();

                                    $.pjax.reload('#' + self.get('pjaxid'), {});
                                    /*sx.notify.info("let the page be rebooted");
                                    _.delay(function()
                                    {
                                        window.location.reload();
                                    }, 2000);*/
                                })
                                .execute();
                            }
                        });

                        return false;
                    });

                    $('.show-at-site').on('click', function()
                    {
                        window.open($(this).attr('href'));

                        return false;
                    });
                },
            });

            new sx.classes.tree.admin.CmsTreeWidget({$options});

        })(window, sx, sx.$, sx._);
JS
);
    ?>
<? $widget::end(); ?>
</div>