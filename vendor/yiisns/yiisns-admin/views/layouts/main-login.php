<?php
use yiisns\admin\assets\AdminAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yiisns\apps\helpers\UrlHelper;

\yiisns\admin\assets\AdminLoginAsset::register($this);
\Yii::$app->admin->registerAsset($this)->initJs();

$urlBg = \Yii::$app->assetManager->getAssetUrl(\yiisns\admin\assets\AdminAsset::register($this), 'images/bg/582738_www.Gde-Fon.com.jpg');
$blockerLoader = \Yii::$app->getAssetManager()->getAssetUrl(\Yii::$app->getAssetManager()
    ->getBundle(\yiisns\admin\assets\AdminAsset::className()), 'images/loaders/circulare-blue-24_24.gif');

$this->registerCss(<<<CSS
    body.sx-styled
    {
        background: url({$urlBg}) center fixed;
    }
CSS
);
$this->registerJs(<<<JS
    (function(sx, $, _)
    {
        sx.AppUnAuthorized = new sx.classes.AppUnAuthorized({
            'blockerLoader': '{$blockerLoader}'
        });
    })(sx, sx.$, sx._);
JS
);
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags()?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" href="http://www.yiisns.cn/favicon.ico" type="image/x-icon" />
    <?php $this->head()?>
</head>
<body>
<?php $this->beginBody()?>
	<!--渲染动画背景 -->
	<div id="canvas-wrapper">
		<canvas id="demo-canvas"></canvas>
	</div>
    <?= \yiisns\admin\widgets\Alert::widget(); ?>
    <?= $content?>
    <div style='display: none;'>
		<img src="<?= $urlBg; ?>" id="sx-auth-bg" />
	</div>
	</div>
    <?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>