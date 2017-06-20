(function(sx, $, _)
{
    sx.createNamespace('classes', sx);

    sx.classes.modal.Confirm    = sx.classes.modal._Confirm.extend({

        _init: function()
        {
            this.applyParentMethod(sx.classes.modal._Confirm, '_init', []);
        },

        /**
         * @returns {sx.classes.modal._Confirm}
         */
        show: function()
        {
            var self = this;
            this._triggerYes = false;

            var jSubmit = $("<button>", {
                'class': "btn btn-primary",
                'type': "button"
            }).append(this.get('submitText', "确定"));

            var Dialog = new sx.classes.modal.Dialog({
                'title' : this.get("title", "请确认您的操作"),
                'content' : this.get("text"),
                'closeBtnText' : this.get('closeBtnText', '取消'),
            });

            Dialog.bind('afterHide', function(e, data)
            {
                if (self._triggerYes === false)
                {
                    self.trigger("no", self);
                }
            });

            jSubmit.on("click", function()
            {
                self._triggerYes = true;
                Dialog.hide();
                self.trigger("yes", self);
                return false;
            });

            Dialog.jFooter.prepend(jSubmit);
            Dialog.show();

            return this;
        },
    });

})(sx, sx.$, sx._);