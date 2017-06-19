			<section>
				<div class="col">
					<?= \yiisns\apps\appsWidgets\contentElements\ContentElementsWidget::widget([
						'namespace'         => 'ContentElementsWidget-footer',
						'viewFile'          => '@template/widgets/ContentElementsWidget/articles-footer',
						'label'             => '文章主体区域最新文章',
						'enabledCurrentTree'=> \yiisns\kernel\base\AppCore::BOOL_N,
						'limit'             => 4,
					]); ?>

				</div>
			</section>