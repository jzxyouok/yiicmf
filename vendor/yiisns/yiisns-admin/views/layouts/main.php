<?php
use yiisns\admin\assets\AdminAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yiisns\apps\helpers\UrlHelper;

/* @var $this \yii\web\View */
/* @var $content string */

AdminAsset::register($this);
\Yii::$app->admin->registerAsset($this)->initJs();
\yiisns\admin\widgets\UserLastActivityWidget::widget();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="icon" href="http://www.yiisns.cn/favicon.ico"  type="image/x-icon" />
        <?php $this->head() ?>
    </head>
    <body class="<?= \Yii::$app->user->isGuest ? "sidebar-hidden" : ""?> <?= \Yii::$app->admin->isEmptyLayout() ? "empty" : ""?>">
<?php $this->beginBody() ?>
    <?= $this->render('_header'); ?>
    <? if (!\Yii::$app->user->isGuest): ?>
        <?= $this->render('_admin-menu'); ?>
    <? endif; ?>
        <div class="main">
            <?= $this->render('_main-head'); ?>
            <div class="col-lg-12 sx-main-body">
                <? $openClose = \Yii::t('yiisns/kernel', 'Expand/Collapse')?>
                <? \yiisns\admin\widgets\AdminPanelWidget::begin([
                    'name'      => property_exists(\Yii::$app->controller, 'name') ? \Yii::$app->controller->name : "",
                    'actions'   => <<<HTML
                        <a href="#" class="sx-btn-trigger-full">
                            <i class="glyphicon glyphicon-fullscreen" data-sx-widget="tooltip-b" data-original-title="{$openClose}" style="color: white;"></i>
                        </a>
HTML
,
                    'options' =>
                    [
                        'class' => 'sx-main-content-widget sx-panel-content',
                    ],
                ]); ?>
                   <div class="panel-content-before">
                        <? if (!UrlHelper::constructCurrent()->getSystem(\yiisns\admin\Module::SYSTEM_QUERY_NO_ACTIONS_MODEL)) : ?>
                            <?= \yii\helpers\ArrayHelper::getValue($this->params, 'actions'); ?>
                        <? endif; ?>
                    </div>
                    <div class="panel-content">
                        <?= \yiisns\admin\widgets\Alert::widget(); ?>
                        <?= $content ?>
                    </div>
                <? \yiisns\admin\widgets\AdminPanelWidget::end(); ?>
            </div>

        </div>
        <?php echo $this->render('_footer'); ?>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>