(function(window, sx, $, _)
{
    sx.createNamespace('classes', sx);

    /**
     *
     * @event beforeOpen
     * @event afterOpen
     * @event close
     * @event error(e, data)
     *
     * @type {void|Function|*}
     */
    sx.classes._Window = sx.classes.Component.extend({

        construct: function (src, name, opts)
        {
            opts = opts || {};
            this._name          = name ? name : "sx-new-window";
            this._src           = src;
            this._openedWindow  = null;

            this.applyParentMethod(sx.classes.Component, 'construct', [opts]); // TODO: make a workaround for magic parent calling
        },

        _init: function()
        {
            this
                .defaultOpts({
                    "left"          : "50",
                    "top"           : "50",
                    "width"         : "90%",
                    "height"        : "70%",
                    "menubar"       : "no",  //如果将此选项设置为 "是", 则新窗口将有一个菜单
                    "location"      : "yes", //如果将此选项设置为 "是", 则新窗口将具有地址栏
                    "toolbar"       : "no",  //当此选项设置为 "是" 时, 新窗口将导航 (后退、前进等) 和选项卡栏
                    "scrollbars"    : "yes", //如果此选项设置为 "是", 则新窗口可以根据需要显示滚动栏
                    "resizable"     : "yes", //如果此选项设置为 "是", 则用户可以调整新窗口的大小。建议您始终设置此选项。
                    "status"        : "yes", //如果此选项设置为 "是", 则新窗口将具有状态栏
                    "directories"   : "yes"  //如果此选项设置为 "是", 则新窗口将书签/收藏夹
                })
                .normalizeOptions()
            ;
        },

        /**
         *
         * @returns {sx.classes.Window}
         */
        normalizeOptions: function()
        {
            var windowWidth     = window.screen.width;
            var windowHeight    = window.screen.height;

            if (sx.helpers.String.strpos(this.get("width"), "%", 0))
            {
                var newWidth = (Number(sx.helpers.String.str_replace("%", "", this.get("width")))/100) * windowWidth;
                this.set("width", Number(newWidth).toFixed())
            }

            if (sx.helpers.String.strpos(this.get("height"), "%", 0))
            {
                var newHeight = (Number(sx.helpers.String.str_replace("%", "", this.get("height")))/100) * windowHeight;
                this.set("height", Number(newHeight).toFixed())
            }

            return this;
        },

        /**
         * @returns {Window}
         */
        open: function()
        {
            var self = this;
            this.trigger('beforeOpen');
            //从数组中收集的参数字符串
            var paramsSting = "";
            if (this.getOpts())
            {
                _.each(this.getOpts(), function(value, key)
                {
                    if (paramsSting)
                    {
                        paramsSting = paramsSting + ',';
                    }
                    paramsSting = paramsSting + String(key) + "=" + String(value);
                });
            }

            this._openedWindow = window.open(this._src, this._name, paramsSting);
            if (!this._openedWindow)
            {
                this.trigger('error', {
                    'message': '浏览器锁定窗口, 必须解析'
                });

                return this;
            }

            this.trigger('afterOpen');

            var timer = setInterval(function()
            {
                if(self._openedWindow.closed)
                {
                    clearInterval(timer);
                    self.trigger('close');
                }
            }, 1000);

            return this;
        },


        /**
         * @returns {sx.classes.Window}
         */
        focus: function()
        {
            if (this.getOpenedWindow())
            {
                this.getOpenedWindow().focus();
            }

            return this;
        },
        
        /**
         * @returns {sx.classes._Window}
         */
        close: function()
        {
            if (this.getOpenedWindow())
            {
                this.getOpenedWindow().close();
            }

            return this;
        },

        /**
         * @returns {boolean}
         */
        isOpened: function()
        {
            if (!this._openedWindow)
            {
                return false;
            }

            return true;
        },

        /**
         * @returns {Window}|null
         */
        getOpenedWindow: function()
        {
            return this._openedWindow;
        },

        /**
         * @returns {string}
         */
        getName: function()
        {
            return String(this._name);
        },

        /**
         * @returns {sx.classes.Window}
         */
        setCenterOptions: function()
        {
            var windowWidth     = window.screen.width;
            var windowHeight    = window.screen.height;

            var left = ((windowWidth - this.get("width"))/2);
            var top  = ((windowHeight - this.get("height"))/2);

            this
                .set("left", left)
                .set("top", top);

            return this;
        },

        /**
         * @returns {sx.classes.Window}
         */
        enableLocation: function()
        {
            this.set('location', 'yes');
            return this;
        },

        /**
         * @returns {sx.classes.Window}
         */
        disableLocation: function()
        {
            this.set('location', 'no');
            return this;
        },

        /**
         * @returns {sx.classes.Window}
         */
        enableResize: function()
        {
            this.set('resizable', 'yes');
            return this;
        },

        /**
         * @returns {sx.classes.Window}
         */
        disableResize: function()
        {
            this.set('resizable', 'no');
            return this;
        }

    });

    sx.classes.Window = sx.classes._Window.extend({});

    /**
     * @type {void|Function|*}
     */
    sx.classes.Windows = sx.classes.Component.extend({
        /**
         * @returns {Array.<T>|*}
         */
        findListRegistered: function()
        {
            return _.filter(sx.components, function(component)
            {
                if (component instanceof sx.classes._Window)
                {
                    return true;
                }
            });
        },

        /**
         *
         * @param name
         * @returns {sx.classes.Window|null}
         */
        findOneByName: function(name)
        {
            return _.find(this.findListRegistered(), function(component)
            {
                if (component.getName() == String(name))
                {
                    return true;
                }
            });
        }
    });

    /**
     * Поиск виджетов работы с окнами.
     * @type {{findListRegistered: Function, findOneByName: Function}}
     */
    sx.Windows = new sx.classes.Windows();


    /**
     * @type {void|Function|*}
     */
    sx.classes._CurrentWindow = sx.classes.Component.extend({

        _init: function()
        {
            var self = this;
            this._timer = null;

            //关闭此窗口
            this.listenParent = false;

            if (this.openerWindow())
            {
                this._timer = setInterval(function()
                {
                    if(!self.openerWindow())
                    {
                        clearInterval(self._timer);
                        if (self.listenParent)
                        {
                            window.close();
                        }
                    }
                }, 1000);
            }
        },

        /**
         * @returns {*}
         */
        openerWindow: function()
        {
            if (window.opener)
            {
                return window.opener;
            }

            /*if (window.parent)
            {
                return window.parent;
            }*/

            return null;
        },

        /**
         * 父窗口 sx 对象
         * @returns {Window.sx|*}
         */
        openerSx: function()
        {
            try
            {
                if (this.openerWindow())
                {
                    return this.openerWindow().sx;
                }
            } catch (e)
            {
                return null;
            }


            return null;
        },


        /**
         * 生成此窗口的父窗口部件
         * @returns {sx.classes._Window|null}
         */
        openerWidget: function()
        {
            if (this.openerSx())
            {
                return this.openerSx().Windows.findOneByName(window.name);
            }

            return null;
        },

        /**
         *
         * @param event
         * @param data
         * @returns {sx.classes._CurrentWindow}
         */
        openerWidgetTriggerEvent: function(event, data)
        {
            if (!this.openerWidget())
            {
                return this;
            }

            this.openerWidget().trigger(event, data);
            return this;
        }
    });

    /**
     * @type {void|Function|*}
     */
    sx.classes.CurrentWindow = sx.classes._CurrentWindow.extend({});

    /**
     * @type {sx.classes.CurrentWindow}
     */
    sx.Window = new sx.classes.CurrentWindow();
})(window, sx, sx.$, sx._);