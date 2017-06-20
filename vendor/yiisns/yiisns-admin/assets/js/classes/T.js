(function(sx, $, _)
{
    sx.createNamespace('classes', sx);

    sx.classes.T  = sx.classes.Component.extend({

        _init: function()
        {
            this.get('db');
        },

        read: function(message)
        {

        },

        getDb: function()
        {
            return this.get('db');
        }
    });

})(sx, sx.$, sx._);