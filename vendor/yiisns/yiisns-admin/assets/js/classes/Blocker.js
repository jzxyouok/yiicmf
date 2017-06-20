(function(sx, $, _)
{
    sx.createNamespace('classes', sx);

    /**
     * Настройка блокировщика для админки по умолчанию. Глобальное перекрытие
     * @type {void|*|Function}
     */
    sx.classes.Blocker  = sx.classes.BlockerJqueyUi.extend({

        _init: function()
        {
            this.imageLoader = '';

            if (sx.App)
            {
                this.imageLoader = sx.App.get('BlockerImageLoader');
            }

            this.defaultOpts({
                message: "<div style='padding: 5px;'><img src='" + this.imageLoader + "' /> 请稍候...</div>",
                css: {
                    border: '1px solid #108acb',
                    padding: '10px;',
                }
            });

            this.applyParentMethod(sx.classes.BlockerJqueyUi, '_init', []);
        },
    });

})(sx, sx.$, sx._);