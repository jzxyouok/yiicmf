(function(sx, $, _)
{
    sx.createNamespace('classes', sx);

    /**
     * @type {void|*|Function}
     */
    sx.classes.AdminMenu = sx.classes.Component.extend({
        _init: function()
        {
            this.getCookieManager().setNamespace('admin-menu');
        },

        _onDomReady: function()
        {
            var self = this;

            if (this.get("toggles"))
            {
                _.each(this.get("toggles"), function(toggle, key)
                {
                    self.registerToggle(toggle);
                });
            }

            if (this.getSavedInstance() == "closed")
            {
                this.close();
            }

            /*$('.sidebar-menu').on('click', function()
            {
                sx.notify.info('success');
            });*/
        },

        /**
         * @returns {sx.classes.AdminMenu}
         */
        registerToggle: function(selector)
        {
            var self = this;

            this.onDomReady(function()
            {
                $(selector).on('click', function()
                {
                    self.toggleTrigger();
                });
            });

            return this;
        },

        /**
         * @returns {sx.classes.AdminMenu}
         */
        toggleTrigger: function()
        {
            this.trigger('toggle', this);

            if (this.isOpened())
            {
                this.close();
            } else
            {
                this.open();
            }

            return this;
        },

        /**
         * the menu is open?
         * @returns {boolean}
         */
        isOpened: function()
        {
            return Boolean( !$("body").hasClass(this.get("hidden-class", "sidebar-hidden")) );
        },

        /**
         * close the menu
         * @returns {sx.classes.AdminMenu}
         */
        close: function()
        {
            var self = this;

            this.onDomReady(function()
            {
                self.trigger('close', this);
                $("body").addClass(self.get("hidden-class", "sidebar-hidden"));
                self.saveInstance();
            });

            return this;
        },

        /**
         * @returns {sx.classes.AdminMenu}
         */
        open: function()
        {
            var self = this;

            this.onDomReady(function()
            {
                self.trigger('open', this);
                $("body").removeClass(self.get("hidden-class", "sidebar-hidden"));
                self.saveInstance();
            });

            return this;
        },

        /**
         * @returns {sx.classes.AdminMenu}
         */
        saveInstance: function()
        {
            if (this.isOpened())
            {
                this.getCookieManager().set('instance', 'opened');
            } else
            {
                this.getCookieManager().set('instance', 'closed');
            }

            return this;
        },

        /**
         * @returns {string}
         */
        getSavedInstance: function()
        {
            return String( this.getCookieManager().get('instance')) ;
        },

        /**
         * @returns {*|void|*|Function}
         */
        getBlocker: function()
        {
            if (!this.Blocker)
            {
                this.Blocker = new sx.classes.Blocker('.sx-sidebar');
            }

            return this.Blocker;
        },

        /**
         * @returns {sx.classes.AdminMenu}
         */
        block: function()
        {
            this.getBlocker().block();
            return this;
        },

        /**
         * @returns {sx.classes.AdminMenu}
         */
        unblock: function()
        {
            this.getBlocker().unblock();
            return this;
        }
    });

})(sx, sx.$, sx._);