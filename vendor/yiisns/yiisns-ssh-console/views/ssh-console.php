<?
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 26.06.2016
 */
/* @var $this yii\web\View */
/* @var $widget \yiisns\apps\widgets\SshConsoleWidget */

$items[] = [
    'label' => '<i class="glyphicon glyphicon-question-sign"></i> '.\Yii::t('yiisns/sshConsole', 'Available commands'),
    'encode' => false,
    'active' => true,
    'content' => $this->render('_sx-cmds', ['widget' => $this]),
];
?>
<div class="sx-widget-ssh-console" id="<?= $widget->id; ?>">
    <div class="sx-blocked-area">
        <iframe id="<?= $widget->iframeId; ?>" style="border: none; width: <?= $widget->consoleWidth; ?>; height: <?= $widget->consoleHeight; ?>;" data-src="<?= \yiisns\apps\helpers\UrlHelper::construct(['/sshConsole/admin-ssh/console'])->enableAdmin()->toString(); ?>"></iframe>
    </div>

    <? if ($items) : ?>
        <?= \yii\bootstrap\Tabs::widget([
            'items' => $items
        ]); ?>
    <? endif; ?>

</div>

<?
$options = $widget->getClientOptionsJson();

$this->registerJs(<<<JS
    (function(sx, $, _)
    {
        sx.classes.SshConsole = sx.classes.Component.extend({

            _init: function()
            {
                this.isReady = false;
                this.Blocker = null;
            },

            _initIframeConsole: function()
            {
                var self = this;

                this.IframeConsole.bind('submit', function(e, data)
                {
                    self.trigger('submit', data);
                    self.getBlocker().block();
                });

                this.IframeConsole.bind('error', function(e, data)
                {
                    self.trigger('error', data);
                    self.getBlocker().unblock();
                });

                this.IframeConsole.bind('success', function(e, data)
                {
                    self.trigger('success', data);
                    self.getBlocker().unblock();
                });

                this.trigger('ready');
                this.isReady = true;
            },

            /**
            *
            * @param callback
            * @returns {sx.classes.SshConsole}
            */
            onReady: function(callback)
            {
                if (this.isReady)
                {
                    callback();
                } else
                {
                    this.bind('ready', callback);
                }

                return this;
            },

            execute: function(cmd)
            {
                var self = this;
                this.onReady(function()
                {
                    self._execute(cmd);
                });

                return this;
            },

            _execute: function(cmd)
            {
                console.log(this.IframeConsole);
                this.IframeConsole.input.val(cmd);
                this.IframeConsole.form.submit();

                return this;
            },

            /**
            * @returns {*|HTMLElement}
            */
            jWrapper: function()
            {
                return $("#" + this.get('id'));
            },


            /**
            *
            * @returns {null|*}
            */
            getBlocker: function()
            {
                if (!this.Blocker)
                {
                    this.Blocker = new sx.classes.Blocker(".sx-blocked-area");
                }

                return this.Blocker;
            },

            _onDomReady: function()
            {
                var self = this;
                this.IframeConsole = null;

                this.jIframe = $('#' + this.get('iframeId'));
                this.jIframe.attr('src', this.jIframe.data('src'));

                sx.Iframe = new sx.classes.Iframe(this.get('iframeId'), {
                   'autoHeight'     : false,
                   'heightTimer'    : 50000,
                   'scrolling'      : 'yes'
                });

                sx.Iframe.onSxReady(function()
                {
                    self.IframeConsole = sx.Iframe.sx.SshConsole;
                    self._initIframeConsole();
                });

            },

            _onWindowReady: function()
            {},
        });

        sx.SshConsole = new sx.classes.SshConsole($options);


    })(sx, sx.$, sx._);
JS
)
?>