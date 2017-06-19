<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.03.2016
 */
/* @var $this \yii\web\View */
?>
<!-- FOOTER -->
<footer class="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="col">
					<?=\yiisns\apps\appsWidgets\text\TextWidget::widget([
					    'namespace' => 'text-footer-left',
					    'text' =>
<<<HTML
					    <h4>联系我们</h4>
				        <ul>
						    <li>YiiSNS中文社区</li>
						    <li>联系电话：<a href="tel:86 (999) 9999-9999">86 (999) 9999-9999</a></li>
						    <li>邮箱：<a href="mailto:support@yiisns.cn" title="support@yiisns.cn">support@yiisns.cn</a></li>
					    </ul>
HTML
]);?>
				 </div>
			</div>

			<!--<div class="col-md-3">
				<div class="col">
					<?/*=\yiisns\apps\appsWidgets\contentElements\ContentElementsWidget::widget([
					    'namespace' => 'ContentElementsWidget-footer',
					    'viewFile' => '@template/widgets/ContentElementsWidget/articles-footer',
					    'label' => 'news and articles',
					    'enabledCurrentTree' => \yiisns\kernel\base\AppCore::BOOL_N,'limit' => 4]);
					*/?>
				</div>
			</div>

			<div class="col-md-3">
				<div class="col col-social-icons">
					<?/*=\yiisns\apps\appsWidgets\treeMenu\TreeMenuWidget::widget([
					    'namespace' => 'menu-footer-2',
					    'viewFile' => '@template/widgets/TreeMenuWidget/menu-footer.php',
					    'label' => 'Menu',
					    'level' => '1']);
					*/?>
				</div>
			</div>-->

			<div class="col-md-3">
				<div class="col">
					<?=\yiisns\apps\appsWidgets\text\TextWidget::widget([
					    'namespace' => 'text-footer-bout-us',
					    'text' => 
<<<HTML
					<h4>关于YiiSNS中文社区</h4>
					<p class="no-margin">
					YiiSNS中文社区致力于提供免费、优质、开源的Yii2.0中文学习资源，期待您的加入，让我们聚沙成塔，构建Yii中文学习资源第一平台！
					</p>
HTML
]);?>
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-8 copyright">2016-2017 © All rights reserved  
				Yii2 - Content management framework</div>
			<div class="col-lg-4">
				<div class=" pull-right">
					<a href="http://www.yiisns.cn" title="Development Site — YiiSNS"
						target="_blank">Development Site — YiiSNS</a> (<a
						href="http://www.yiisns.cn" title="" target="_blank">YiiSNS</a>)
				</div>
			</div>
		</div>
	</div>
</footer>
<!--
<a id="fca_phone_div" href="#callback"
	class="fca-phone fca-green fca-show fca-static sx-fancybox"
	style="right: 50px; bottom: 100px; display: block;">
	<div class="fca-ph-circle"></div>
	<div class="fca-ph-circle-fill"></div>
	<div class="fca-ph-img-circle"></div>
</a>
<div style="display: none;">
	<div id="callback" style="width: 600px;">
		<h2>Call Back</h2>
		<p>Leave your phone number and we'll call you back.</p>
		<?//=\yiisns\form2\cmsWidgets\form2\FormWidget::widget(['namespace' => 'FormWidget-all', 'form_code' => 'callback', 'viewFile' => 'whith-messages'])?>
	</div>
</div>  -->