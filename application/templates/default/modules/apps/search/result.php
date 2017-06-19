<?
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.03.2015
 */
/* @var $this \yii\web\View */
?>

<?/*= $this->render('@template/include/breadcrumbs', [
    'title' => "Search results: " . \Yii::$app->cmsSearch->searchQuery
])*/?>

<section style="padding: 40px 0;">
    <div class="container sx-content">
        <div class="row">
            <div class="col-md-12">

                <? \yiisns\admin\widgets\Pjax::begin(); ?>

                    <div class="row">
                        <div class="col-md-12">
                            <form action="/search" method="get" data-pjax="true">
                                <div class="input-group animated fadeInDown">
                                    <input type="text" name="<?= \Yii::$app->cmsSearch->searchQueryParamName; ?>" class="form-control" placeholder="Search" value="<?= \Yii::$app->cmsSearch->searchQuery; ?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" onclick="$('.search-open form').submit(); return false;">For</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>

                <!--=== Content Part ===-->
                    <div class="row">
                        <div class="col-md-12">

                            <?= \yiisns\apps\appsWidgets\contentElements\ContentElementsWidget::widget([
                                'namespace'                     => 'ContentElementsWidget-search-result',
                                'viewFile'                      => '@app/views/modules/apps/search/_widget',
                                'enabledCurrentTree'            => \yiisns\kernel\base\AppCore::BOOL_N,
                                'dataProviderCallback'           => function(\yii\data\ActiveDataProvider $dataProvider)
                                {
                                    \Yii::$app->cmsSearch->buildElementsQuery($dataProvider->query);
                                    \Yii::$app->cmsSearch->logResult($dataProvider);
                                },
                            ])?>

                        </div>
                    </div>

                <? \yiisns\admin\widgets\Pjax::end(); ?>

            </div>
        </div>
    </div>
</section>
