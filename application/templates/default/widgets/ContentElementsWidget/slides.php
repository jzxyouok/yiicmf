<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.05.2016
 */
/* @var $this   yii\web\View */
/* @var $widget \yiisns\apps\appsWidgets\contentElements\ContentElementsWidget */


?>

<!-- OWL SLIDER -->

<? if ($widget->dataProvider->query->count()) : ?>

<?


if ($widget->dataProvider->query->count() >= 1)
{

    $timestamp = \Yii::$app->assetManager->appendTimestamp;
    \Yii::$app->assetManager->appendTimestamp = false;
    $skinsPath = \app\assets\BoomerangThemeAsset::getAssetUrl("assets/layerslider/skins/");

    \Yii::$app->assetManager->appendTimestamp = $timestamp;
    $this->registerJs(<<<JS
        jQuery("#layerslider").layerSlider({
            pauseOnHover: true,
            autoPlayVideos: false,
            skinsPath: '{$skinsPath}',
            responsive: false,
            responsiveUnder: 1280,
            layersContainer: 1280,
            skin: 'borderlessdark3d',
            hoverPrevNext: true,
        });
JS
    );
}


?>
    <section id="slider-wrapper" class="layer-slider-wrapper layer-slider-static">
        <? echo \yii\widgets\ListView::widget([
            'dataProvider'      => $widget->dataProvider,
            'itemView'          => 'slide-item',
            'emptyText'          => '',
            'options'           =>
            [
                'tag'       => 'div',
                'style' => "width: 100%; height: 500px",
                'id' => "layerslider"
            ],
            'itemOptions' => [
                'tag' => false,
            ],
            'layout'            => "{items}"
        ])?>
    </section>


<? endif; ?>

<!-- /OWL SLIDER -->
