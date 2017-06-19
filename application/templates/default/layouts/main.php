<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 01.10.2016
 */
use yii\helpers\Html;
use application\assets\AppAsset;
/* @var $this \yii\web\View */
/* @var $content string */
AppAsset::register($this);
\Yii::$app->templateBoomerang->initTheme();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" href="/favicon.ico?v=<?= @filemtime(\Yii::getAlias('@app/web/favicon.ico'));?>"  type="image/x-icon" />
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
		<!-- wrapper -->
		<div class="body-wrap <?= \Yii::$app->templateBoomerang->bodyCssClasses; ?>">	
            <?= $this->render('@app/views/header'); ?>
                <?= $content; ?>
            <?= $this->render('@app/views/footer'); ?>
        </div>
		<!-- /wrapper -->
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>