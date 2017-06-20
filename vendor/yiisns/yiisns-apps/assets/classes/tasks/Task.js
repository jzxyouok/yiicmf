(function(sx, $, _)
{
    sx.createNamespace('classes.tasks', sx);

    /**
     * 要执行的任务
     */
    sx.classes.tasks._Task = sx.classes.Component.extend({

        execute: function()
        {
            this.trigger("beforeExecute", {
                'task' : this
            });

            var result = {'message': '任务已经完成'};

            this.trigger("complete", {
                'task'      : this,
                'result'    : result
            });
        }
    });

    sx.classes.tasks.Task = sx.classes.tasks._Task.extend({});


    /*_init: function()
    {
        this.attachedManagers = {};
    },

    *//**
     * @param Manager
     * @returns {boolean}
     *//*
    isAttachedToManager: function(Manager)
    {
        if (! Manager instanceof sx.classes.tasks._Manager)
        {
            throw new Error("无法将此任务绑定到此管理器");
        }

        var id = Manager.getId();
        if (typeof this.attachedManagers[id] == "undefined")
        {
            return false;
        } else
        {
            return true;
        }
    },

    *//**
     * @param Manager
     * @returns {sx.classes.tasks._Task}
     *//*
    attachToManager: function(Manager)
    {
        if (! Manager instanceof sx.classes.tasks._Manager)
        {
            throw new Error("无法将此任务绑定到此管理器");
        }

        this.attachedManagers[Manager.getId()] = Manager;
        return this;
    },*/
})(sx, sx.$, sx._);