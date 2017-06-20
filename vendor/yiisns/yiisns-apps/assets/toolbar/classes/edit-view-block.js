(function(sx, $, _)
{
    sx.createNamespace('classes.toolbar', sx);

    sx.classes.toolbar.EditViewBlock = sx.classes.Component.extend({

        _init: function()
        {
            this._isVisible = false;
        },

        _onDomReady: function()
        {
            var self = this;

            this.jWrapper = $('#' + this.get('id'));
            // 初始化不可见的容器
            this._createHiddenBorder()._createHiddenControlls();
            this.adjustWrapper();

            this.jWrapper.on("dblclick", function()
            {
                self.goEdit();
                return false;
            });

            this.jWrapper.hover(
                function ()
                {
                    self.adjustHidden().show();
                },
                function ()
                {
                    self._isVisible = false;
                    _.delay(function()
                    {
                        if (self._isVisible === false)
                        {
                            self.hide();
                        }
                    }, 200);
                }
            );

            this.jHiddenControllBtns.hover(
                function ()
                {
                    self.adjustHidden().show();
                },
                function ()
                {
                    self._isVisible = false;
                    _.delay(function()
                    {
                        if (self._isVisible === false)
                        {
                            self.hide();
                        }
                    }, 200);
                }
            );


            $(window).on('scroll', function()
            {
                if (self._isVisible === true)
                {
                    self.adjustHidden().show();
                }
            })
        },


        show: function()
        {
            var self = this;
            this._isVisible = true;
            self.jHiddenBorders.show();
            self.jHiddenControllBtns.show();
        },

        hide: function()
        {
            var self = this;

            self.jHiddenBorders.hide();
            self._isVisible = false;
            self.jHiddenControllBtns.hide();
        },

        /**
         * 阻止编辑操作
         */
        goEdit: function()
        {
            new sx.classes.toolbar.Dialog(this.jWrapper.data('config-url'));
        },

        /**
         * 创建不可见的按钮容器
         * @returns {sx.classes.toolbar.EditViewBlock}
         * @private
         */
        _createHiddenControlls: function()
        {
            var self = this;

            this.jHiddenControllBtns = $('<div>').addClass('sx-edit-view-block-controlls')
                                        .appendTo($('body'));

            this.jHiddenControllEdit = $('<a>').append('编辑').appendTo(this.jHiddenControllBtns).on('click', function()
            {
                self.goEdit();
                return false;
            });

            return this;
        },

        /**
         * 创建与区域重叠的不可见容器
         *
         * @returns {sx.classes.toolbar.EditViewBlock}
         * @private
         */
        _createHiddenBorder: function()
        {

            this.jHiddenBorders = $("<div>", {
                'style' : 'display: none; height: 0px; width: 0px;'
            }).appendTo($('body'));


            this.jBorderTop = $('<div>')
                                .css('position', 'fixed')
                                .css('height', '1px')
                                .css('fontSize', '1px')
                                .css('overflow', 'hidden')
                                .css('zIndex', '9990')
                                .css('background', this.getBorderColor())
                                .appendTo(this.jHiddenBorders);

            this.jBorderRight = $('<div>')
                                .css('position', 'fixed')
                                .css('width', '1px')
                                .css('fontSize', '1px')
                                .css('overflow', 'hidden')
                                .css('zIndex', '9990')
                                .css('background', this.getBorderColor())
                                .appendTo(this.jHiddenBorders);


            this.jBorderBottom = $('<div>')
                                .css('position', 'fixed')
                                .css('height', '1px')
                                .css('fontSize', '1px')
                                .css('overflow', 'hidden')
                                .css('zIndex', '9990')
                                .css('background', this.getBorderColor())
                                .appendTo(this.jHiddenBorders);

            this.jBorderLeft = $('<div>')
                                .css('position', 'fixed')
                                .css('width', '1px')
                                .css('fontSize', '1px')
                                .css('overflow', 'hidden')
                                .css('zIndex', '9990')
                                .css('background', this.getBorderColor())
                                .appendTo(this.jHiddenBorders);

            return this;

        },


        /**
         * 编辑模式下的边框颜色, 由toolbar相关组件在程序设置
         * @returns {*}
         */
        getBorderColor: function()
        {
            var settings = sx.Toolbar.getInfoblockSettings();
            if (settings.border)
            {
                if (settings.border.color)
                {
                    return String(settings.border.color);
                }
            }

            return 'red';
        },


        /**
         * 设置区域块
         * @returns {sx.classes.toolbar.EditViewBlock}
         */
        adjustWrapper : function()
        {
            var minHeight   = this.get('minHeight', 12);
            var height      = this.jWrapper.height();
            if (height <= minHeight)
            {
                this.jWrapper.addClass("skeeks-cms-toolbar-edit-view-block-empty");
                this.jWrapper.css('height', minHeight + 'px');
            } else
            {
                this.jWrapper.removeClass("skeeks-cms-toolbar-edit-view-block-empty");
            }

            return this;
        },

        /**
         * 定位和自定义不可见的容器
         *
         * @returns {sx.classes.toolbar.EditViewBlock}
         */
        adjustHidden : function()
        {
            this._adjustBorders()._adjustControlls();
            return this;
        },


        /**
         * 自定义按钮
         * @returns {sx.classes.toolbar.EditViewBlock}
         * @private
         */
        _adjustControlls : function()
        {
            var top     = this.jWrapper.offset().top - $(window).scrollTop();
            var left    = this.jWrapper.offset().left;

            var fromTop = top - 24;
            if (fromTop <= 120)
            {
                fromTop = this.jWrapper.height() + top;
            }

            this.jHiddenControllBtns
                .css('top', fromTop)
                .css('left', left)
            ;

            return this;
        },

        /**
         * 设置宿住区域块
         * @returns {sx.classes.toolbar.EditViewBlock}
         * @private
         */
        _adjustBorders: function()
        {
            var height  = this.jWrapper.height();
            var width   = this.jWrapper.width();
            var top     = this.jWrapper.offset().top - $(window).scrollTop();
            var left    = this.jWrapper.offset().left;

            this.jBorderTop
                .css('top', top)
                .css('left', left)
                .css('width', width)
            ;

            this.jBorderRight
                .css('top', top)
                .css('left', left + width)
                .css('height', height)
            ;

            this.jBorderBottom
                .css('top', top + height)
                .css('left', left)
                .css('width', width)
            ;

            this.jBorderLeft
                .css('top', top)
                .css('left', left)
                .css('height', height)
            ;

            return this;
        }
    });

})(sx, sx.$, sx._);