(function(sx, $, _)
{
    sx.createNamespace('classes.tasks', sx);

    sx.classes.tasks.AjaxTask = sx.classes.tasks._Task.extend({

        construct: function (ajaxQuery, opts)
        {
            var self = this;
            if (!ajaxQuery instanceof sx.classes._AjaxQuery)
            {
                throw new Error('AjaxQuery incorrect object');
            }

            opts = opts || {};
            opts.ajaxQuery = ajaxQuery;

            this.applyParentMethod(sx.classes.Component, 'construct', [opts]);
        },

        _init: function()
        {
            this._initQuery();
        },

        _initQuery: function()
        {
            var self = this;

            this.get("ajaxQuery").onComplete(function(e, data)
            {
                self.trigger("complete", {
                    'task'      : self,
                    'result'    : data
                });
            });

            return this;
        },

        execute: function()
        {
            var self = this;

            this.trigger("beforeExecute", {
                'task' : this
            });

            this.get("ajaxQuery").execute();
        },

        /**
         * @returns {sx.classes.shop._App.ajaxQuery|*}
         */
        getAjaxQuery: function()
        {
            return this.get("ajaxQuery");
        }
    });

})(sx, sx.$, sx._);