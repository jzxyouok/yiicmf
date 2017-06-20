<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 27.03.2016
 *
 * @var $component \yiisns\kernel\base\Component
 */
/* @var $this yii\web\View */
?>

<?= $this->render('_header', ['component' => $component]); ?>
    <div class="sx-box sx-mb-10 sx-p-10">
        <p><?= \Yii::t('yiisns/kernel','This component may have personal preferences. And it works differently depending on which of the sites is displayed.')?></p>
        <p><?= \Yii::t('yiisns/kernel','In that case, if the site not has personal settings will be used the default settings.')?></p>
        <? if ($settings = \yiisns\kernel\models\ComponentSettings::baseQuerySites($component)->count()) : ?>
            <p><b><?=\Yii::t('yiisns/kernel','Number of customized sites')?>:</b> <?= $settings; ?></p>
            <button type="submit" class="btn btn-danger btn-xs" onclick="sx.ComponentSettings.Remove.removeSites(); return false;">
                <i class="glyphicon glyphicon-remove"></i> <?=\Yii::t('yiisns/kernel','reset settings for all sites"')?>
            </button>
            <small>.</small>
        <? else: ?>
            <small><?= \Yii::t('yiisns/kernel', 'Neither site does not have personal settings for this component')?></small>
        <? endif; ?>
    </div>

    <?
        $search = new \yiisns\kernel\models\Search(\yiisns\kernel\models\Site::className());
        $search->search(\Yii::$app->request->get());
        $search->getDataProvider()->query->andWhere(['active' => \yiisns\kernel\base\AppCore::BOOL_Y]);

    ?>
    <?= \yiisns\admin\widgets\GridViewHasSettings::widget([
        'dataProvider' => $search->getDataProvider(),
        'filterModel' => $search->getLoadedModel(),
        'columns' => [
            [
                'class'     => \yii\grid\DataColumn::className(),
                'value'     => function(\yiisns\kernel\models\Site $model, $key, $index)
                {
                    return \yii\helpers\Html::a('<i class="glyphicon glyphicon-cog"></i>',
                    \yiisns\apps\helpers\UrlHelper::constructCurrent()->setRoute('admin/admin-component-settings/site')->set('site_id', $model->id)->toString(),
                    [
                        'class' => 'btn btn-default btn-xs',
                        'title' => \Yii::t('yiisns/kernel','Customize')
                    ]);
                },
                'format'    => 'raw',
            ],
            'name',
            'code',
            [
                'class'         => \yiisns\kernel\grid\ComponentSettingsColumn::className(),
                'component'     => $component,
            ],
        ]
    ])?>
<?= $this->render('_footer'); ?>