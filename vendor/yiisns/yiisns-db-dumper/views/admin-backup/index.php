<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 08.06.2016
 */
/* @var $this yii\web\View */
$filesObjects = [];
$files = \yii\helpers\FileHelper::findFiles(\Yii::$app->dbDumper->backupDirPath);
foreach ($files as $filePath) {
    $filesObjects[] = [
        'path' => $filePath,
        'filemtime' => filemtime($filePath)
    ];
}
\yii\helpers\ArrayHelper::multisort($filesObjects, 'filemtime', SORT_DESC);

$backend = \yii\helpers\Url::to([
    '/dbDumper/admin-backup/dump',
    \yiisns\admin\components\UrlRule::ADMIN_PARAM_NAME => \yiisns\admin\components\UrlRule::ADMIN_PARAM_VALUE
]);
?>
<div id="sx-backups">
    <?
    $this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.DbDumper = sx.classes.Component.extend({

        _onDomReady: function()
        {
            var self = this;

            $(".sx-btn-make").on('click', function()
            {
                self.make();
                return false;
            });
        },

        make: function()
        {
            var ajax = sx.ajax.preparePostQuery(this.get("backend"));
            var rr = new sx.classes.AjaxHandlerStandartRespose(ajax);
            rr.bind('error', function(e, data)
            {
                $.pjax.reload('#sx-backups', {});
                return false;
            });

            rr.bind('success', function(e, data)
            {
                $.pjax.reload('#sx-backups', {});
                return false;
            });

            ajax.execute();
        }
    });


    sx.DbDumper = new sx.classes.DbDumper({
        'backend' : '{$backend}'
    });

})(sx, sx.$, sx._);
JS
);
    
    ?>
    <?=\yii\helpers\Html::a("<i class=\"glyphicon glyphicon-save\"></i> " . \Yii::t('yiisns/dbDumper', 'Make a backup'), "#", ['class' => 'btn btn-primary sx-btn-make']);?>

    <br /> <br />
    <? if (file_exists(\Yii::$app->dbDumper->backupDirPath)) : ?>
        <?=\yiisns\admin\widgets\GridView::widget(['dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $filesObjects]),'columns' => [['class' => 'yii\grid\SerialColumn'],['class' => \yii\grid\DataColumn::className(),'format' => 'raw','attribute' => 'filemtime','label' => \Yii::t('yiisns/dbDumper', 'Time of creation'),'value' => function ($data) {return \Yii::$app->formatter->asDatetime(\yii\helpers\ArrayHelper::getValue($data, 'filemtime')) . " <small>" . \Yii::$app->formatter->asRelativeTime(\yii\helpers\ArrayHelper::getValue($data, 'filemtime')) . "</small>";}],['class' => \yii\grid\DataColumn::className(),'value' => function ($data) {return basename(\yii\helpers\ArrayHelper::getValue($data, 'path'));}],['class' => \yii\grid\DataColumn::className(),'value' => function ($data) {return \Yii::$app->formatter->asShortSize(filesize(\yii\helpers\ArrayHelper::getValue($data, 'path')));}]]]);?>

        <?
        echo \mihaildev\elfinder\ElFinder::widget([
            'language' => \Yii::$app->language,
            'controller' => 'apps/elfinder-full',
            'path' => \Yii::$app->dbDumper->backupDirPath,
            // 'filter' => 'image',
            'callbackFunction' => new \yii\web\JsExpression('function(file, id){}'), // id - id виджета
            'frameOptions' => [
                'style' => 'width: 100%; height: 800px;'
            ]
        ]);
        ?>
    <? else: ?>
        <p><?=\Yii::t('yiisns/dbDumper','Directory with files of backups database is not found.')?></p>
    <? endif; ?>
</div>