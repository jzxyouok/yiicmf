(function(sx, $, _)
{
    sx.createNamespace('classes.toolbar', sx);

    sx.classes.toolbar.Dialog = sx.classes.Component.extend({

        construct: function (url, opts)
        {
            var self = this;
            opts = opts || {};
            this.url = url;
            //this.parent.construct(opts);
            this.applyParentMethod(sx.classes.Component, 'construct', [opts]); // TODO: make a workaround for magic parent calling
        },

        _init: function()
        {
            this.window = new sx.classes.toolbar.Window(this.url);
            this.window.bind('close', function()
            {
                //sx.notify.info('重新加载该页面');

                _.defer(function()
                {
                    sx.block('body');
                    _.delay(function()
                    {
                        window.location.reload();
                    }, 100);

                });
            });

            this.window.open();
        },

        _onDomReady: function()
        {},

        _onWindowReady: function()
        {}
    });

})(sx, sx.$, sx._);