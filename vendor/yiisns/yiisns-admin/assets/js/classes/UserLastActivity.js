(function(sx, $, _)
{
    sx.classes.UserLastActivity = sx.classes.Component.extend({

        _init: function()
        {
            var self = this;

            this.mergeDefaults({
                'leftTimeInfo': 30,
                'ajaxLeftTimeInfo': 180,
                'interval': 5,
                'isGuest': false,
            });

            setInterval(function(){
                self.check();
            }, Number( this.get('interval') * 1000 ) );

        },

        check: function()
        {
            var self = this;

            if (this.getLeftTime() < Number(this.get('leftTimeInfo')) && this.getLeftTime() > 0)
            {
                sx.notify.info('You will be blocked through ' + this.getLeftTime() + ' Seconds because of the long-unactivity.');
            }

            if (this.getLeftTime() < Number(this.get('leftTimeInfo')) && this.getLeftTime() < 0)
            {
                sx.notify.info('You are blocked because of a long inactivity on the site');
            }

            if (this.get('isGuest'))
            {
               sx.notify.info('You need to authorize the site');
            }


            if (this.getLeftTime() < Number(this.get('ajaxLeftTimeInfo')))
            {
                var ajaxQuery = sx.ajax.preparePostQuery(this.get('backendGetUser'));

                new sx.classes.AjaxHandlerNoLoader(ajaxQuery);

                ajaxQuery.bind('success', function(e, data)
                {
                    self.merge(data.response.data);
                });

                ajaxQuery.execute();
            }
        },

        /**
         * Время сейчас
         * @returns {number}
         */
        getNowTime: function()
        {
            return Math.floor(Date.now() / 1000);
        },

        /**
         * @returns {number}
         */
        getPassedTime: function()
        {
            return (this.getNowTime()  - Number(this.get('startTime')));
        },

        /**
         * @returns {number}
         */
        getLeftTime: function()
        {
            return (this.getBlockedAfterTime()  - this.getPassedTime());
        },

        /**
         * @returns {number}
         */
        getBlockedAfterTime: function()
        {
            return Number(this.get('blockedAfterTime'));
        },

    });

})(sx, sx.$, sx._);