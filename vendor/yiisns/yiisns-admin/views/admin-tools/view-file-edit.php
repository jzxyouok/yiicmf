<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 07.11.2016
 */
/* @var $this yii\web\View */
/* @var $rootViewFile string */
/* @var $model \yiisns\kernel\models\forms\ViewFileEditModel */
$this->registerCss(<<<CSS
.CodeMirror
{
    height: auto;
}
CSS
)
?>
<? $form = \yiisns\admin\widgets\form\ActiveFormStyled::begin([
    'useAjaxSubmit' => true,
    'usePjax' => false,
    'enableAjaxValidation' => false
]); ?>
    <?= $form->field($model, 'source')->label($model->rootViewFile)->widget(
        \yii\widget\codemirror\CodemirrorWidget::className(),
        [
            'preset' => 'htmlmixed',
            'assets' =>
            [
                \yii\widget\codemirror\CodemirrorAsset::THEME_NIGHT
            ],
            'clientOptions' =>
            [
                'theme' => 'night'
            ],
            'options'=>['rows' => 1],
        ]
    ); ?>
    <?= $form->buttonsStandart($model); ?>
<? \yiisns\admin\widgets\form\ActiveFormStyled::end(); ?>