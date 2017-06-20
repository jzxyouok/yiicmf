(function(sx, $, _)
{
    sx.createNamespace('classes', sx);

    /**
     * @type {*|Function|void}
     * @private
     */
    sx.classes._Config = sx.classes.Entity.extend({

        _init: function()
        {
            this.mergeDefaults({
                env: "dev",             //Application Environment
                lang: "zh-cn",          //Application language
                loadedTime: null,       //Page loading time
                cookie:                 //Cookie Options
                {
                    namespace: "sx"
                },
            })
        },

        /**
         * dev environment?
         * @returns {boolean}
         */
        isDev: function()
        {
            return (this.get("env") == "dev") ? true : false;
        },

        /**
         * product environment?
         * @returns {boolean}
         */
        isProduct: function()
        {
            return (this.get("env") == "product") ? true : false;
        }
    });

    sx.classes.Config = sx.classes._Config.extend();

    /**
     * @type {Skeeks.classes.Config}
     */
    sx.config = new sx.classes.Config();

})(Skeeks, Skeeks.$, Skeeks._);