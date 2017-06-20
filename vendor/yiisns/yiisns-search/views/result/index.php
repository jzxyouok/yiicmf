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
    'title' => "Search results: " . \Yii::$app->search->searchQuery
])*/?>
<? \yiisns\admin\widgets\Pjax::begin(); ?>

    <div class="container">
        <form action="/search" method="get" data-pjax="true">
            <div class="input-group animated fadeInDown">
                <input type="text" name="<?= \Yii::$app->search->searchQueryParamName; ?>" class="form-control" placeholder="<?=\Yii::t('yiisns/search', 'Searching')?>" value="<?= \Yii::$app->search->searchQuery; ?>">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="button" onclick="$('.search-open form').submit(); return false;"><?=\Yii::t('yiisns/search', 'Search')?></button>
                </span>
            </div>
        </form>
    </div>

<!--=== Content Part ===-->
<div class="container content">
    <div class="row magazine-page">
        <div class="col-md-12">

            <?= \yiisns\apps\appsWidgets\contentElements\ContentElementsWidget::widget([
                'namespace'                     => 'ContentElementsWidget-search-result',
                'viewFile'                      => '@yiisns/search/views/result/_widget',
                'enabledCurrentTree'            => \yiisns\kernel\base\AppCore::BOOL_N,
                'dataProviderCallback'           => function(\yii\data\ActiveDataProvider $dataProvider)
                {
                    \Yii::$app->search->buildElementsQuery($dataProvider->query);
                    \Yii::$app->search->logResult($dataProvider);
                },
            ])?>

        </div>
    </div>
</div>

<? \yiisns\admin\widgets\Pjax::end(); ?>