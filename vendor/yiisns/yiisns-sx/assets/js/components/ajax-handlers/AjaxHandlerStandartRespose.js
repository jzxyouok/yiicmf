(function(sx, $, _)
{
    /**
     * {
     *     'success'                            : function(e, response){},
     *     'error'                              : function(e, response){},
     *
     *     'responseSuccess'                    : function(e, response){},
     *     'allowResponseSuccessMessage'        : true,
     *
     *     'responseError'                      : function(e, response){},
     *     'allowResponseErrorMessage'          : true,
     *
     *     'allowResponseRedirect'              : true,
     *     'redirectDelay'                      : 100,
     *
     *
     *     'blocker'                            : new sx.classes.Blocker(),
     *     'enableBlocker'                      : true,
     *     'blockerSelector'                    : 'body',
     *
     *
     *     'ajaxExecuteSuccess'                 : function(e, response){},
     *     'ajaxExecuteSuccessMessage'          : 'The error of the ajax request',
     *     'ajaxExecuteSuccessAllowMessage'     : false,
     *
     *     'ajaxExecuteError'                   : function(e, data){},
     *     'ajaxExecuteErrorMessage'            : 'The error of the ajax request',
     *     'ajaxExecuteErrorAllowMessage'       : true,
     *
     * }
     * Handler ajax, for displaying notifications
     */
    sx.classes.AjaxHandlerStandartRespose = sx.classes.AjaxHandler.extend({

        _init: function()
        {
            var self = this;

            //Disable internal calculation of the ajax request
            this.getAjaxQuery()
                .onBeforeSend(function(e, data)
                {
                    if (self.get('enableBlocker', false))
                    {
                        self.getBlocker().block();
                    }
                })
                .onComplete(function(e, data)
                {
                    if (self.get('enableBlocker', false))
                    {
                        self.getBlocker().unblock();
                    }
                })
                .onError(function(e, data)
                {
                    //The error of the ajax request.
                    self.trigger('ajaxExecuteError', data);
                    self.trigger('error', data);

                    //Whether to show the standard error message when the ajax request is not
                    if ( self.get('ajaxExecuteErrorAllowMessage', true) )
                    {
                        sx.notify.error(self.get('ajaxExecuteErrorMessage', 'Ajax请求错误'));
                    }
                })
                .onSuccess(function(e, data)
                {
                    var response = data.response;
                    self.trigger('ajaxExecuteSuccess', response);

                    //Whether to show the standard error message when the ajax request is completed
                    if ( self.get('ajaxExecuteSuccessAllowMessage', false) )
                    {
                        sx.notify.success(self.get('ajaxExecuteSuccessMessage', 'Ajax请求完成'));
                    }

                    //the generation of events based on the data of the answer
                    if (response.success)
                    {
                        self.trigger('responseSuccess', response);
                        self.trigger('success', response);

                        if (response.message && self.get('allowResponseSuccessMessage', true))
                        {
                            sx.notify.success(response.message);
                        }

                    } else
                    {
                        self.trigger('responseError', response);
                        self.trigger('error', response);

                        if (response.message && self.get('allowResponseErrorMessage', true))
                        {
                            sx.notify.error(response.message);
                        }
                    }

                    if (response.redirect)
                    {
                        self.redirect(response.redirect);
                    }

                })
            ;
        },

        /**
         * @returns {sx.classes.Blocker}
         */
        getBlocker: function()
        {
            if (this.get('blocker'))
            {
                if (this.get('blocker') instanceof sx.classes._Blocker)
                {
                    return this.get('blocker');
                }
            }

            var blocker = new sx.classes.Blocker(this.get('blockerSelector', 'body'));
            this.set('blocker', blocker);
            return blocker;
        },

        /**
         * @param redirect
         * @returns {sx.classes.AjaxHandlerStandartRespose}
         */
        redirect: function(redirect)
        {
            if (this.get('allowResponseRedirect', true))
            {
                _.delay(function()
                {
                    window.location.href = redirect;

                }, this.get('redirectDelay', 100))
            }

            return this;
        }
    });

})(sx, sx.$, sx._);