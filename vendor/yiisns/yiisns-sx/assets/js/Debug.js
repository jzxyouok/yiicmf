(function(global, sx, $, _)
{
    /**
     * @type {{init: Function}}
     */
    sx.console = global.console;

    sx.console.init = function()
    {
        if (sx.config.isProduct())
        {
            var methods = ['assert', 'count', 'debug', 'dir', 'dirxml', 'error', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log', 'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd', 'trace', 'warn'];
            for (var i = methods.length; i--;)
            {
                (function (methodName) {
                     global.console[methodName] = function ()
                     {

                     };
                })(methods[i]);
            }
        }

        sx.console = global.console;
    };

    sx.onReady(function()
    {
        //控制台的初始化
        sx.console.init();
    })

})(window, Skeeks, Skeeks.$, Skeeks._);