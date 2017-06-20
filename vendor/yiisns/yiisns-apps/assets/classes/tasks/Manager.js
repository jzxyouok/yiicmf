(function(sx, $, _)
{
    sx.createNamespace('classes.tasks', sx);

    sx.classes.tasks._Manager = sx.classes.Component.extend({

        _init: function()
        {
            this.reset();
        },

        reset: function()
        {
            //任务队列
            this.queue = [];

            //此任务是否在执行
            this.isExecuting = false;

            //当前正在运行的任务
            this.executingTask = null;

            return this;
        },

        /**
        * @returns {*|sx.classes.Task[]}
        */
        getTasks: function()
        {
            return this.get('tasks');
        },

        /**
         * @param tasks
         * @returns {sx.classes.tasks._Manager}
         */
        setTasks: function(tasks)
        {
            this.set('tasks', tasks );
            return this;
        },

        /**
         * @param Task
         * @returns {sx.classes.tasks._Manager}
         */
        addTask: function(Task)
        {
            if (!Task instanceof sx.classes.tasks._Task)
            {
                throw new Error("无效任务");
            }

            var tasks = this.getTasks();
            tasks.push(Task);
            this.setTasks(tasks);
            return this;
        },

        /**
         * 总任务
         * @returns {number|*|Number}
         */
        countTotalTasks: function()
        {
            return Number( _.size(this.getTasks()) );
        },

        /**
         * 队列中的任务（队列随每个任务而减少）
         * @returns {number|*|Number}
         */
        countQuequeTasks: function()
        {
            return Number( _.size(this.queue) );
        },

        /**
         * 加载队列
         * @returns {sx.classes.tasks._Manager}
         */
        _loadQueque: function()
        {
            //console.info('_loadQueque');
            this.queue = this.getTasks();
            return this;
        },

        /**
         * 初始化下一个任务
         * @returns {sx.classes.tasks._Manager}
         * @private
         */
        _initNextTask: function()
        {
            //console.info('init next task');

            //下面的任务从现在执行
            this.executingTask = _.first(this.queue);

            //这些任务将从队列中删除
            var queue   = this.queue;
            this.queue  = _.rest(queue);

            return this;
        },


        /**
         * 处理执行任务
         * @returns {sx.classes.tasks._Manager}
         * @private
         */
        _runProcessing: function()
        {
            //console.info('Task manager _runProcessing');

            var self = this;

            //停止所有执行
            if (!this.isExecuting)
            {
                return this;
            }

            //没有更多的任务在队列中, 必须停止它
            if (!this.countQuequeTasks())
            {
                //console.info('队列中没有其他任务, 请停止！');

                this.stop();
                return this;
            }


            //到下一个任务管理器
            this._initNextTask();

            if (!this.executingTask)
            {
                //console.info('没有要执行的任务, 请停止！');

                this.stop();
                return this;
            }

            /**
             * 执行任务之前
             */
            this.executingTask.bind("beforeExecute", function(e, data)
            {
                self.trigger("beforeExecuteTask", {
                    'task' : self.executingTask
                });
            });

            /**
             * 任务完成之后
             */
            this.executingTask.bind("complete", function(e, data)
            {
                self.trigger("completeTask", {
                    'task' : self.executingTask
                });

                _.delay(function()
                {
                    self._runProcessing();
                }, Number(self.get('delayQueque', 200)) );
            });

            this.executingTask.execute();

            return this;
        },


        /**
         * @returns {sx.classes.tasks._Manager}
         */
        restart: function()
        {
            this.reset();
            return this;
        },

        /**
         * @returns {sx.classes.tasks._Manager}
         */
        start: function()
        {
            //加载队列
            this._loadQueque();

            //没有任务
            if (this.countQuequeTasks() == 0)
            {
                this.trigger("error", {
                    'manager' : this,
                    'error' : "Задачи не найдены"
                });

                return this;
            }

            this.trigger("beforeStart", {
                'manager' : this
            });

            this.isExecuting   = true;

            this.trigger("start", {
                'manager' : this
            });

            this._runProcessing();

            return this;
        },

        /**
         * @returns {sx.classes.tasks._Manager}
         */
        stop: function()
        {
            this.trigger("beforeStop", {
                'manager' : this
            });

            this.reset();
            this.set("tasks", []);

            this.trigger("stop", {
                'manager' : this
            });

            return this;
        },
    });

    sx.classes.tasks.Manager = sx.classes.tasks._Manager.extend({});

})(sx, sx.$, sx._);