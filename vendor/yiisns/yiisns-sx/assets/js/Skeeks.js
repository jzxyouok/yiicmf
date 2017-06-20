(function(global, $, _)
{
    if (global.Skeeks || global.sx)
    {
        throw new Error("Object is already defined in global namespace.");
    }

    //create Skeeks
    var sx = global.sx = global.Skeeks = {};

    //register Underscore
    sx._ = _;

    //register jQuery
    sx.$ = $;

    /**
     * Creating namespace using a spec
     *
     * @param  {String} spec
     * @param  {Object} where (Optional) By default we create namespaces within Tiks
     * @return {Object}
     */
    sx.createNamespace = function(spec, where)
    {
        where = where || sx;

        var path = spec.split('.');
        var ns = where;

        for (var i = 0, l = path.length; i < l; ++i) {
            var part = path[i];
            if (!ns[part]) {
                ns[part] = {};
            }

            ns = ns[part];
        }

        return ns;
    };

    sx.version = "1.2";

    /**
     * The library is ready or not
     * @type {boolean}
     */
    sx._readyTrigger = false;

    /**
     * Called once when the library is ready
     * @private
     */
    sx._ready = function()
    {
        sx._readyTrigger = true;
        //The sx library is ready
        sx.EventManager.trigger("ready");
    };

    /**
     *
     * @returns {boolean}
     */
    sx.isReady = function()
    {
        return sx._readyTrigger;
    };

    /**
     * Initializing important components
     */
    sx.init = function(data)
    {
        sx.config.merge(data);
        sx._ready();
    };

    /**
     * @param callback
     * @returns {*}
     */
    sx.onReady = function(callback)
    {
        if (sx.isReady())
        {
            callback();
        } else
        {
            sx.EventManager.bind("ready", callback);
        }

        return this;
    };

})(window, jQuery, _);