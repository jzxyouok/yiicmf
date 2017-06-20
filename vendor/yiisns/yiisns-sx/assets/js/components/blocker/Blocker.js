(function(sx, $, _)
{
    sx.createNamespace('classes', sx);

    sx.classes._Blocker = sx.classes.Widget.extend({

        _init: function()
        {
            var self = this;
            /**
             * 当前状态
             * @type {boolean}
             * @private
             */
            this._isBlocked = false;

            this.defaultOpts({
                "autoStart" : false
            });

            if (this.isAutoStart())
            {
                this.block();
            }


            this.bind('beforeBlock', function()
            {
                this._isBlocked = true;
            });

            this.bind('afterUnblock', function()
            {
                this._isBlocked = false;
            });
        },

        /**
         * @returns {sx.classes._Blocker}
         */
        block: function()
        {
            this.trigger('beforeBlock');
            this._block();

            return this;
        },

        /**
         * @returns {sx.classes._Blocker}
         */
        unblock: function()
        {
            this.trigger('beforeUnblock');
            this._unblock();
            return this;
        },

        /**
         * @returns {sx.classes._Blocker}
         * @private
         */
        _block: function()
        {
            this.trigger('afterBlock');
            throw new Error('这是抽象类');
            return this;
        },

        /**
         * @returns {sx.classes._Blocker}
         * @private
         */
        _unblock: function()
        {
            this.trigger('afterUnblock');
            throw new Error('这是抽象类');
            return this;
        },

        /**
         * @returns {boolean}
         */
        isAutoStart: function()
        {
            return Boolean(this.get("autoStart"));
        }
    });

    sx.classes.Blocker  = sx.classes._Blocker.extend({});

    /**
     * @param wrapper
     * @param options
     * @returns {sx.classes._Blocker|*}
     */
    sx.block = function(wrapper, options)
    {
        return new sx.classes.Blocker(wrapper, options).block();
    };

    /**
     * Ajax处理程序, 显示通知
     */
    sx.classes.AjaxHandlerBlocker = sx.classes.AjaxHandler.extend({

        _init: function()
        {
            var self = this;
            this.blocker = new sx.classes.Blocker(this.get('wrapper'), this.toArray());

            //禁用 Ajax查询状态的内部计数
            this.getAjaxQuery()
                .onBeforeSend(function(e, data)
                {
                    self.blocker.block();
                })
                .onComplete(function(e, data)
                {
                    self.blocker.unblock();
                })
            ;
        }

    });
})(sx, sx.$, sx._);