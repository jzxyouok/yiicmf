(function(sx, $, _)
{
    sx.createNamespace('classes', sx);

    /**
     * TODO: is deprecated
    * @type {void|Function|*}
    */
    sx.classes.Widget = sx.classes.Component.extend({

        construct: function (wrapper, opts)
        {
            var self = this;
            opts = opts || {};
            this._wrapper = wrapper;
            //this.parent.construct(opts);
            this.applyParentMethod(sx.classes.Component, 'construct', [opts]); // TODO: make a workaround for magic parent calling
        },

        /**
         * @returns {*|HTMLElement}
         */
        getWrapper: function()
        {
            if (typeof this._wrapper == 'string')
            {
                this._wrapper = $(this._wrapper);
            }

            return this._wrapper;
        }
    });

})(sx, sx.$, sx._);