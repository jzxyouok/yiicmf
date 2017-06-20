<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 08.06.2016
 */
/* @var $this yii\web\View */
$backend = \yii\helpers\Url::to([
    'refresh'
]);
$this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.RefreshDb = sx.classes.Component.extend({

        _onDomReady: function()
        {
            var self = this;

            $(".sx-btn-refresh").on('click', function()
            {
                self.refresh();
                return false;
            });
        },

        refresh: function()
        {
            var Ajax = sx.ajax.preparePostQuery(this.get('backend'));
            var Handler = new sx.classes.AjaxHandlerStandartRespose(Ajax);
            Ajax.execute();
        }
    });
    sx.RefreshDb = new sx.classes.RefreshDb({
        'backend' : '{$backend}'
    });
})(sx, sx.$, sx._);
JS
)?>
<?=
\yii\helpers\Html::a("<i class=\"glyphicon glyphicon-retweet\"></i> " . \Yii::t('yiisns/dbDumper', 'Refresh cache table structure'), "#", [
    'class' => 'btn btn-primary sx-btn-refresh',
    'data-method' => 'post'
])?>
<br />
<br />
<?=\yiisns\admin\widgets\GridView::widget(['dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => [['name' => \Yii::t('yiisns/dbDumper', 'Cache table structure'), 'value' => \Yii::$app->db->enableSchemaCache ? 'Y' : 'N'],['name' => \Yii::t('yiisns/dbDumper', 'Cache query'), 'value' => \Yii::$app->db->enableSchemaCache ? 'Y' : 'N']]]), 'columns' => [['attribute' => 'name','label' => \Yii::t('yiisns/dbDumper', 'Name setting')], ['class' => \yiisns\kernel\grid\BooleanColumn::className(),'attribute' => 'value']]]);?>