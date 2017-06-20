<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 02.06.2016
 */
namespace yiisns\admin\traits;

use yii\helpers\Json;
use yii\jui\Sortable;
use yii\widgets\Pjax;

/**
 *
 * Class GridViewSortableTrait
 * 
 * @package yiisns\admin\traits
 */
trait GridViewSortableTrait
{
    /**
     *
     * @var bool
     */
    public $sortable = false;

    public $sortableOptions = [
        'backend' => ''
    ];

    public function registerSortableJs()
    {
        $pjaxId = '';
        if (property_exists($this, 'pjax')) {
            $pjax = $this->pjax;
            if ($pjax && ($pjax instanceof Pjax)) {
                $pjaxId = $pjax->id;
            }
        }
        
        if ($this->sortable) {
            Sortable::widget();
            
            $options = $this->sortableOptions;
            $options['pjaxId'] = $pjaxId;
            
            $sortableOptions = Json::encode($options);
            $this->view->registerCss(<<<Css
            table.sx-sortable tbody>tr
            {
                cursor: move;
            }
Css
);
            $this->view->registerJs(<<<JS
            (function(sx, $, _)
            {
                sx.classes.TableSortable = sx.classes.Widget.extend({

                    _init: function()
                    {},

                    _onDomReady: function()
                    {
                        var self = this;
                        this.Jtable = this.getWrapper().find('table');
                        this.Jtable.addClass('sx-sortable');
                        $('tbody', this.Jtable).sortable({

                            forceHelperSize: true,
                            forcePlaceholderSize: true,
                            opacity: 0.5,
                            placeholder: "ui-state-highlight",

                            out: function( event, ui )
                            {
                                var Jtbody = $(ui.item).closest("tbody");
                                var newSort = [];
                                Jtbody.children("tr").each(function(i, element)
                                {
                                    newSort.push($(this).data("key"));
                                });

                                var blocker = sx.block(self.getWrapper());

                                var ajax = sx.ajax.preparePostQuery(
                                    self.get('backend'),
                                    {
                                        "keys" : newSort,
                                        "changeKey" : $(ui.item).data("key")
                                    }
                                );

                                new sx.classes.AjaxHandlerNoLoader(ajax);
                                new sx.classes.AjaxHandlerNotifyErrors(ajax, {
                                    'error': "Changes not saved",
                                    'success': "Changes saved",
                                });

                                ajax.onError(function(e, data)
                                {
                                    if (self.get('pjaxId'))
                                    {
                                        $.pjax.reload($("#" + self.get('pjaxId')), {});
                                    }

                                    blocker.unblock();
                                    //sx.notify.info("let the page be rebooted");
                                    _.delay(function()
                                    {
                                        //window.location.reload();
                                        //blocker.unblock();
                                    }, 2000);
                                })
                                .onSuccess(function(e, data)
                                {
                                    if (self.get('pjaxId'))
                                    {
                                        $.pjax.reload($("#" + self.get('pjaxId')), {});
                                    }

                                    var response = data.response;
                                    if (response.success === false)
                                    {
                                        sx.notify.error(response.message);
                                    } else
                                    {
                                        sx.notify.success(response.message);
                                    }

                                    blocker.unblock();
                                })
                                .execute();
                            }

                        });
                    },

                    _onWindowReady: function()
                    {}
                });

                new sx.classes.TableSortable('#{$this->id}', {$sortableOptions});
            })(sx, sx.$, sx._);
JS
);
        }
    }
}