(function(sx, $, _)
{
    sx.createNamespace('classes', sx);
    /**
     * @type {void|*|Function}
     */
    sx.classes.WindowOriginal  = sx.classes._Window.extend({});

    /**
     * @type {void|*|Function}
     */
    sx.classes.Window  = sx.classes._Window.extend({

        /**
         * @returns {Window}
         */
        open: function()
        {
            var self = this;
            this.trigger('beforeOpen');
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
        },

        close: function()
        {
            $.fancybox.close();
            return this;
        }
    });

})(sx, sx.$, sx._);