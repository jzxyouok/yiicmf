<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 08.11.2016
 * @since 1.0.0
 */
/* @var $this yii\web\View */

$url = \yiisns\apps\helpers\UrlHelper::construct('admin/clear/index')->enableAdmin()->toString();
$data = \yii\helpers\Json::encode([
    'backend' => $url
])
?>

<div class="sx-box sx-p-10 sx-bg-primary">
    <?= \yii\helpers\Html::a(\Yii::t('yiisns/kernel', 'Delete temporary files'), $url, [
        'class' => 'btn btn-primary',
        'onclick' => 'new sx.classes.Clear(' . $data . '); return false;'
    ]); ?>
    <hr />

    <?= \yiisns\admin\widgets\GridView::widget([
            'dataProvider'  => new \yii\data\ArrayDataProvider([
                'allModels' => $clearDirs
            ]),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'label',
                [
                    'class' => \yii\grid\DataColumn::className(),
                    'value' => function($data)
                    {
                        /**
                         * @var $dir \yiisns\sx\Dir
                         */
                        $dir = $data['dir'];
                        return $dir->getPath();
                    }
                ],

                [
                    'class' => \yii\grid\DataColumn::className(),
                    'value' => function($data)
                    {
                        /**
                         * @var $dir \yiisns\sx\Dir
                         */
                        $dir = $data['dir'];
                        return $dir->getSize()->formatedShortSize();
                    }
                ],
            ]
        ]);
    ?>
</div>
<?
    $this->registerJs(<<<JS
    (function(sx, $, _)
    {
        sx.classes.Clear = sx.classes.Component.extend({

            _init: function()
            {
                var ajax = sx.ajax.preparePostQuery(this.get("backend"));

                new sx.classes.AjaxHandlerStandartRespose(ajax);
                new sx.classes.AjaxHandlerNoLoader(ajax);

                new sx.classes.AjaxHandlerBlocker(ajax, {
                    'wrapper': '.sx-panel .panel-content'
                });

                /*ajax.onError(function(e, data)
                {
                    sx.notify.info("Let the page be rebooted");
                    _.delay(function()
                    {
                        window.location.reload();
                    }, 2000);
                })*/

                ajax.execute();
            },

            _onDomReady: function()
            {},

            _onWindowReady: function()
            {}
        });

    })(sx, sx.$, sx._);
JS
)
?>