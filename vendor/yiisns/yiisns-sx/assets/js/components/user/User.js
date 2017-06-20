(function(sx, $, _)
{
    sx.createNamespace('classes', sx);
    sx.createNamespace('users', sx);

    sx.classes._User = sx.classes.Entity.extend({

        _init: function()
        {
            this.mergeDefaults({
                name:           "guest",
                user_role:      "Guest",
                privileges:     []
            })
        },


        /**
         * 是否匿名用户
         * @returns {boolean}
         */
        isGuest: function()
        {
            return true;
        },

        /**
         * 用户权限
         * @returns {*}
         */
        getPrivileges: function()
        {
            return this.get("privileges");
        },

        /**
         * 用户角色
         * @returns {*}
         */
        getRole: function()
        {
            return this.get("user_role");
        },

        /**
         * 登录名称
         * @returns {*}
         */
        getName: function()
        {
            return this.get("name");
        }
    });

    sx.classes.User = sx.classes._User.extend();


    /**
     * 当前用户
     * @returns {*}
     */
    sx.onReady(function()
    {
        sx.users.Current = new sx.classes.User(sx.config.getUserData());
    });

})(Skeeks, Skeeks.$, Skeeks._);