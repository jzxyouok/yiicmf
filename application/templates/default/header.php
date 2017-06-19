<?
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 06.03.2016
 */
/* @var $this \yii\web\View */
?>
<!-- HEADER -->
<div id="divHeaderWrapper">
	<header class="header-standard-2">
		<!-- MAIN NAV -->
		<div class="navbar navbar-wp navbar-arrow mega-nav" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle navbar-toggle-aside-menu">
                        <i class="fa fa-outdent icon-custom"></i>
                    </button>
					<button type="button" class="navbar-toggle" data-toggle="collapse"
						data-target=".navbar-collapse">
						<i class="fa fa-bars icon-custom"></i>
					</button>
					<a class="navbar-brand" href="<?= \yii\helpers\Url::home(); ?>" title="首页">
                        <?=\yiisns\apps\appsWidgets\text\TextWidget::widget([
                            'namespace' => 'header-logo',
                            'text' => <<<HTML
                        <img src="/img/logo.png" style="float: left;" />
                        <span style="float: left; margin-top: 12px; margin-left: 10px;">
                            <span style="color: #006EEB; font-weight: bold;">YiiSNS</span>.cn
                        </span>
HTML
]);?>
                    </a>
				</div>
                <?=\yiisns\apps\appsWidgets\treeMenu\TreeMenuWidget::widget([
                    'namespace' => 'menu-top',
                    'viewFile' => '@app/views/widgets/TreeMenuWidget/menu-top.php',
                    'label' => '',
                    'level' => '1',
                    'enabledRunCache' => \yiisns\kernel\base\AppCore::BOOL_N]);
                ?>
            </div>
		</div>
	</header>
</div>