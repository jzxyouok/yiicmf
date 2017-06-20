(function(sx, $, _)
{
    sx.createNamespace('classes', sx);
    sx.createNamespace('classes.notify', sx);

    //全局设置
    $(function()
    {
        $.jGrowl.defaults.closer        = false;
        $.jGrowl.defaults.closeTemplate = '×';
        $.jGrowl.defaults.position      = 'center';
        $.jGrowl.defaults.life          = 5000;
    });

    /**
     * Базовый класс
     */
    sx.classes.notify.NotifyJgrowl  = sx.classes.notify._Notify.extend({
        /**
         * @returns {sx.classes.NotifyJgrowl}
         * @private
         */
        _show: function()
        {
            var self = this;

            this.onDomReady(function()
            {
                var text = self.get('text');
                if (self.getImageSrc())
                {
                    text = '<img src="' + self.getImageSrc() + '" />' + text;
                }

                $.jGrowl(text, self.getOpts());
            });

            return this;
        },


        /**
         * @returns {string|*|String}
         */
        getImageSrc: function()
        {
            return String(this.get('image', ''));
        }
    });

    sx.classes.notify.Defaul    = sx.classes.notify.NotifyJgrowl.extend({});

    sx.classes.notify.Error    = sx.classes.notify.NotifyJgrowl.extend({
        /**
         * @returns {string|*|String}
         */
        getImageSrc: function()
        {
            return sx.config.get('notify').imageError;
        }
    });

    sx.classes.notify.Success    = sx.classes.notify.NotifyJgrowl.extend({
        /**
         * @returns {string|*|String}
         */
        getImageSrc: function()
        {
            return sx.config.get('notify').imageSuccess;
        }
    });

    sx.classes.notify.Info    = sx.classes.notify.NotifyJgrowl.extend({
        /**
         * @returns {string|*|String}
         */
        getImageSrc: function()
        {
            return sx.config.get('notify').imageInfo;
        }
    });


    sx.classes.notify.Warning    = sx.classes.notify.NotifyJgrowl.extend({
        /**
         * @returns {string|*|String}
         */
        getImageSrc: function()
        {
            return sx.config.get('notify').imageWarning;
        }
    });

    sx.classes.notify.Fail    = sx.classes.notify.NotifyJgrowl.extend({
        /**
         * @returns {string|*|String}
         */
        getImageSrc: function()
        {
            return sx.config.get('notify').imageFail;
        }
    });

})(sx, sx.$, sx._);