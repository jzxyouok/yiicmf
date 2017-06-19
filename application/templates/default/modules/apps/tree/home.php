<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 24.05.2016
 */
/* @var $this \yii\web\View */
/* @var $model \yiisns\kernel\models\Tree */

?>

<?= \yiisns\apps\appsWidgets\contentElements\ContentElementsWidget::widget([
    'namespace' => 'ContentElementsWidget-home-slides',
    'viewFile' 	=> '@app/views/widgets/ContentElementsWidget/slides',
]); ?>

<!-- MAIN CONTENT -->

    <section class="slice base inset-shadow-1">
        <div class="wp-section">
            <div class="section-title-wr">
                <h3 class="section-title center">
                    <?= \yiisns\apps\appsWidgets\text\TextWidget::widget([
					'namespace'         => 'home-title-1',
					'text'              => <<<HTML
                    <span class="c-white">О нас</span>
                    <small class="c-white">Тестовый сайт — тест, тест, тест, текст, текст, текст, текст</small>

HTML
	,
				]); ?>

                </h3>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">

                        <?= \yiisns\apps\appsWidgets\text\TextWidget::widget([
					'namespace'         => 'home-text-1',
					'text'              => <<<HTML
                    <p class="text-center">
                        Добро пожаловать на тестовый сайт! Наша стоматологическая клиника занимается всеми видами лечения зубов, общей и косметической стоматологией, ортодонтией, имплантацией и протезированием зубов.
Диапазон наших стоматологических услуг обширен, но базируется на сохранении естественной структуры зубов, безболезненном лечении и создании непревзойденных естественных результатов в кратчайший промежуток времени. А каждый этап лечения проводится с особой тщательностью и вниманием к деталям.

                    </p>
                     <p class="text-center">
                        <a href="/about" title="Подробнее о нас" class="btn btn-primary">Подробнее о нас</a>
                    </p>

HTML
	,
				]); ?>


                    </div>
                </div>
            </div>
        </div>
    </section>






<section class="slice bg-white">
<?= \yiisns\apps\appsWidgets\contentElements\ContentElementsWidget::widget([
    'namespace' => 'ContentElementsWidget-home',
    'viewFile' 	=> '@app/views/widgets/ContentElementsWidget/publications',
]); ?>
</section>

<section class="slice bg-white">
    <div class="container">
        <div class="row">
            <?= $model->description_full; ?>
        </div>
    </div>

</section>

<!--=== Content Part ===-->
<section class="slice no-padding">
    <?= \yiisns\apps\appsWidgets\text\TextWidget::widget([
					'namespace'         => 'home-map',
					'text'              => <<<HTML
                    <script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=mKvmwnHX1m5v7UeNQZp5k34sgPxhAUeU&width=100%&height=400px&lang=ru_RU&sourceType=constructor"></script>
HTML
	,
				]); ?>

</section>
