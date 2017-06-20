<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 21.09.2016
 */

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$filter = new \yii\base\DynamicModel([
    'id',
]);
$filter->addRule('id', 'integer');

$filter->load(\Yii::$app->request->get());

if ($filter->id)
{
    $dataProvider->query->andWhere(['id' => $filter->id]);
}
?>
<? $form = \yiisns\admin\widgets\filters\AdminFiltersForm::begin([
        'action' => '/' . \Yii::$app->request->pathInfo,
    ]); ?>
    <?= $form->field($searchModel, 'form_id')->listBox(\yii\helpers\ArrayHelper::merge(['' => null],
        \yii\helpers\ArrayHelper::map(
            \yiisns\form2\models\Form2Form::find()->all(),
            'id',
            'name'
        )
    ), ['size' => 1])->setVisible(); ?>

    <?= $form->field($searchModel, 'status')->listBox(\yii\helpers\ArrayHelper::merge(['' => null],
        \yiisns\form2\models\Form2FormSend::getStatuses()
    ), ['size' => 1]); ?>
<? $form::end(); ?>