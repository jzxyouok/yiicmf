(function(sx, $, _)
{
    sx.createNamespace('classes', sx);

    sx.classes._AjaxLoader = sx.classes.Component.extend({

        _init: function()
        {
            this.defaultOpts({
                "enable"    : true,
                "bindAjax"  : true,
                "imageSrc"  : "images/1.gif"
            });
        },

        /**
         * @returns {*|mixed|null}
         */
        isEnabled: function()
        {
            return this.get("enable", true);
        },


        _onDomReady: function()
        {
            var self = this;

            this._buildLoader();

            if (this.get("bindAjax"))
            {
                sx.EventManager.bind(sx.ajax.ajaxStart, function(e, data)
                {
                    if (sx.ajax.hasExecutingQueries())
                    {
                        self.show();
                    }
                });

                sx.EventManager.bind(sx.ajax.ajaxStop, function(e, data)
                {
                    if (!sx.ajax.hasExecutingQueries())
                    {
                        self.hide();
                    }
                });
            }
        },

        /**
         * @returns {sx.classes._core._GlobalLoader}
         * @private
         */
        _buildLoader: function()
        {
            this.$_loader = $("<div>" ,{
                "id"     :   "sx-classes-ajaxLoader-1",
                "style"  :   "position: fixed; top: 50%; left: 50%; z-index: 10000; display: none;"
            }).append(
               /*$("<img>", {
                   'src'    : this.get("imageSrc")
               })*/
            );

            $("body").append(this.$_loader);

            return this;
        },

        hide: function()
        {
            this.$_loader.hide();
        },

        /**
         * @returns {sx.classes._core._GlobalLoader}
         */
        show: function()
        {
            if (this.isEnabled())
            {
                this._show();
            }

            return this;
        },

        _show: function()
        {
            this.$_loader.show();
        }
    });

    sx.classes.AjaxLoader = sx.classes._AjaxLoader.extend({});

    /**
     * Ajax处理程序, 不显示全局加载程序
     */
    sx.classes.AjaxHandlerNoLoader = sx.classes.AjaxHandler.extend({

        _init: function()
        {
            //禁用 Ajax查询状态的内部计数
            this.getAjaxQuery().set('allowCountExecuting', false);
        }

    });

})(sx, sx.$, sx._);