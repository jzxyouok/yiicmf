<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 02.06.2016
 */
/* @var $this yii\web\View */
/* @var $searchModel \yiisns\kernel\models\Search */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \yiisns\kernel\models\ContentElement */

$dataProvider->setSort(['defaultOrder' => ['published_at' => SORT_DESC]]);

if ($content_id = \Yii::$app->request->get('content_id'))
{
    $dataProvider->query->andWhere(['content_id' => $content_id]);
    /**
     * @var $content \yiisns\kernel\models\Content
     */
    $content = \yiisns\kernel\models\Content::findOne($content_id);
    $searchModel->content_id = $content_id;
}
?>
<? $pjax = \yii\widgets\Pjax::begin(); ?>

    <?php echo $this->render('_search', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'content_id' => $content_id,
        'content' => $content,
    ]); ?>

    <?= \yiisns\admin\widgets\GridViewStandart::widget([
        'dataProvider'      => $dataProvider,
        'filterModel'       => $searchModel,
        'autoColumns'       => false,
        'pjax'              => $pjax,
        'adminController'   => $controller,
        'settingsData'  =>
        [
            'namespace' => \Yii::$app->controller->action->getUniqueId() . $content_id
        ],
        'columns' => \yiisns\admin\controllers\AdminContentElementController::getColumns($content, $dataProvider)
    ]); ?>

<? \yii\widgets\Pjax::end(); ?>

<? \yii\bootstrap\Alert::begin([
    'options' => [
        'class' => 'alert-info',
    ],
]); ?>
    <?= \Yii::t('yiisns/kernel', 
        'You can change the properties and permissions of the information block in the {Placeholder}.', 
        ['Placeholder' => \yii\helpers\Html::a(\Yii::t('yiisns/kernel', 
            'Content settings'),
            \yiisns\apps\helpers\UrlHelper::construct([
                '/admin/admin-content/update', 
                'pk' => $content_id
    ])->enableAdmin()->toString())]); ?>
<? \yii\bootstrap\Alert::end(); ?>