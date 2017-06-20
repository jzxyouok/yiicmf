(function(sx, $, _)
{
    sx.createNamespace('classes.toolbar', sx);

    /**
     * fancybox窗口
     */
    sx.classes.toolbar.Window  = sx.classes._Window.extend({
        /**
         * @returns {Window}
         */
        open: function()
        {
            var self = this;

            this.trigger('beforeOpen');
            // 从数组中收集参数字符串
            var paramsSting = "";
            if (this.getOpts())
            {
                _.each(this.getOpts(), function(value, key)
                {
                    if (paramsSting)
                    {
                        paramsSting = paramsSting + ',';
                    }
                    paramsSting = paramsSting + String(key) + "=" + String(value);
                });
            }

            this.onDomReady(function()
            {
                var options = _.extend({
                    'afterClose' : function()
                    {
                        self.trigger('close');
                    },
                    'height'	: '100%',
                    'autoSize'  : false,
                    'width'		: '100%'
                }, self.toArray());

                $("<a>", {
                    'style' : 'display: none;',
                    'href' : self._src,
                    'data-fancybox-type' : 'iframe',
                }).appendTo('body').fancybox(options).click();
            });

            return this;
        }
    });
})(sx, sx.$, sx._);