<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 01.09.2016
 */
/* @var $this yii\web\View */
/* @var $searchModel \yiisns\kernel\models\Search */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \yiisns\kernel\models\ContentElement */

$backend = \yii\helpers\Url::to(['load']);
$backendStop = \yii\helpers\Url::to(['stop-executable']);

$this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.Updater = sx.classes.Component.extend({

        _init: function()
        {
            setInterval(function()
            {
                $.pjax.reload('#sx-agents', {});
            }, 15000);
        }
    });

    new sx.classes.Updater();
})(sx, sx.$, sx._);



JS
);

?>


<? $pjax = \yiisns\admin\widgets\Pjax::begin([
    'id' => 'sx-agents'
]); ?>

    <?



    $this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.LoadAgents = sx.classes.Component.extend({

        _onDomReady: function()
        {
            var self = this;

            $(".sx-btn-make").on('click', function()
            {
                self.make();
                return false;
            });

            $(".sx-btn-stop-executable").on('click', function()
            {
                self.stop();
                return false;
            });
        },

        make: function()
        {
            var ajax = sx.ajax.preparePostQuery(this.get("backend"));
            var rr = new sx.classes.AjaxHandlerStandartRespose(ajax);

            rr.bind('error', function(e, data)
            {
                $.pjax.reload('#sx-agents', {});
                return false;
            });

            rr.bind('success', function(e, data)
            {
                $.pjax.reload('#sx-agents', {});
                return false;
            });

            ajax.execute();
        },

        stop: function()
        {
            var ajax = sx.ajax.preparePostQuery(this.get("backendStop"));
            var rr = new sx.classes.AjaxHandlerStandartRespose(ajax);

            rr.bind('error', function(e, data)
            {
                $.pjax.reload('#sx-agents', {});
                return false;
            });

            rr.bind('success', function(e, data)
            {
                $.pjax.reload('#sx-agents', {});
                return false;
            });

            ajax.execute();
        }
    });


    new sx.classes.LoadAgents({
        'backend' : '{$backend}',
        'backendStop' : '{$backendStop}'
    });

})(sx, sx.$, sx._);
JS
);
$this->registerCss(<<<CSS
.sx-legend
{
    font-size: 16px;
    margin-left: 20px;
}
.sx-orange
{
    color: orange;
    font-weight: bold;
}
.sx-green
{
    color: green;
    font-weight: bold;
}
CSS
);
    ?>


    <?php echo $this->render('_search', [
        'searchModel'   => $searchModel,
        'dataProvider'  => $dataProvider
    ]); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
            <?= \yii\helpers\Html::a("<i class=\"glyphicon glyphicon-stop\"></i> ". \Yii::t('yiisns/agent', 'Stop running'), "#", [
                'class'         => 'btn btn-primary sx-btn-stop-executable',
            ]); ?>
            </div>


            <div class="pull-right">
                <?= \yii\helpers\Html::a("<i class=\"glyphicon glyphicon-retweet\"></i> ". \Yii::t('yiisns/agent', 'Find and download of files'), "#", [
                    'class'         => 'btn btn-primary sx-btn-make',
                ]); ?>
                <span class="sx-legend">
                    <?= \Yii::t('yiisns/agent', 'Files with agents'); ?> <span class="sx-orange"><?= count(\Yii::$app->agent->agentsConfigFiles); ?></span>
                    | <?= \Yii::t('yiisns/agent', 'Found agents'); ?> <span class="sx-green"><?= count(\Yii::$app->agent->agentsConfig); ?></span>
                </span>
            </div>
        </div>
    </div>

    <br />

<?= \yiisns\admin\widgets\GridViewStandart::widget([
    'dataProvider'          => $dataProvider,
    'filterModel'           => $searchModel,
    'adminController'       => $controller,
    'pjax'                  => $pjax,

    "columns"      => [
        [
            'attribute' => 'is_running',
            'filter' => \Yii::$app->appCore->booleanFormat(),
            'format' => 'raw',
            'value' => function(\yiisns\apps\agent\models\Agent $agent)
            {
                if ($agent->is_running == 'Y')
                {
                    return \yii\helpers\Html::img(\yiisns\apps\agent\assets\agentAsset::getAssetUrl('loaders/loader.svg'), [
                        'height' => '30'
                    ]);
                }

                return '-';
            },
        ],
        'name',
        'description',

        [
            'class'         => \yiisns\kernel\grid\DateTimeColumnData::className(),
            'attribute'     => "last_exec_at"
        ],

        [
            'class'         => \yiisns\kernel\grid\DateTimeColumnData::className(),
            'attribute'     => "next_exec_at"
        ],

        [
            'attribute'     => "agent_interval"
        ],

        [
            'class'         => \yiisns\kernel\grid\BooleanColumn::className(),
            'attribute'     => "active"
        ],
    ],
]); ?>


<? \yiisns\admin\widgets\Pjax::end(); ?>

<? if (\Yii::$app->agent->onHitsEnabled) : ?>
    <? \yii\bootstrap\Alert::begin([
        'options' => [
            'class' => 'alert-warning',
        ],
    ])?>

        <?= \Yii::t('yiisns/agent', 'Attention! You use agents mechanism hits users. If possible, switch them on cron.'); ?>
        <br />
        <b>* * * * * cd <?= ROOT_DIR; ?> && php yii agent/execute > /dev/null 2>&1</b>

    <? \yii\bootstrap\Alert::end(); ?>
<? else: ?>
    <? \yii\bootstrap\Alert::begin([
        'options' => [
            'class' => 'alert-success',
        ],
    ])?>

        <?= \Yii::t('yiisns/agent', 'In the project settings specified that you are using a mechanism on the crown agents. If the agents do not work, check the entry in the file cron'); ?>
        <br />
        <b>* * * * * cd <?= ROOT_DIR; ?> && php yii agent/execute > /dev/null 2>&1</b>
    <? \yii\bootstrap\Alert::end(); ?>
<? endif; ?>

<!--<hr />-->

<!--<pre>
<?/*
print_r(Yii::$app->agent->agentsConfig);
*/?>
</pre>-->
<?/*=
    \yiisns\admin\widgets\GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'models' => \Yii::$app->agent->agentsConfigFiles
        ]),
        'columns' =>
        [

        ]
    ]);
*/?>
