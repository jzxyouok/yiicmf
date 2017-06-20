<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.03.2016
 *
 * @var $component \yiisns\kernel\base\Component
 * @var $message string
 */
/* @var $this yii\web\View */
$jsData = \yii\helpers\Json::encode([
    'callableId' => $callableId,
    'saveCallabaleBackend' => \yii\helpers\Url::to('save-callable') . "?" . http_build_query(\Yii::$app->request->get()),
    'afterSaveUrl' => \yii\helpers\Url::to('index') . "?" . http_build_query(\Yii::$app->request->get())
]);

$this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.Callable = sx.classes.Component.extend({

        _onDomReady: function()
        {
            var self    =  this;

            this.callableData = '';

            if (window.opener)
            {
                if (window.opener)
                {
                    this.callableData = window.opener.sx.$("#" + this.get('callableId')).val();
                }
            } else if (window.parent)
            {

                if (window.parent)
                {
                    this.callableData = window.parent.sx.$("#" + this.get('callableId')).val();
                }
            }

            this.AjaxQuery = sx.ajax.preparePostQuery(this.get('saveCallabaleBackend'), {
                'data' : this.callableData
            });

            this.AjaxQuery.bind('complete', function()
            {
                window.location.href = self.get('afterSaveUrl');
            });

            this.AjaxQuery.execute();
        },

    });

    new sx.classes.Callable({$jsData});
})(sx, sx.$, sx._);
JS
)
?>
<h1 style="text-align: center; margin-top: 40px;">loading...</h1>