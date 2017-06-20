<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 28.04.2015
 */
/* @var $this yii\web\View */
/* @var $model \yii\db\ActiveRecord */

use yiisns\admin\widgets\form\ActiveFormUseTab as ActiveForm;
?>

<?
$this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.SelectCmsElement = sx.classes.Component.extend({

        _onDomReady: function()
        {
            this.GetParams              = sx.helpers.Request.getParams();

            $('table tr').on('dblclick', function()
            {
                $(".sx-row-action", $(this)).click();
            });
        },

        submit: function(data)
        {
            if (this.GetParams['callbackEvent'])
            {
                if (window.opener)
                {
                    if (window.opener.sx)
                    {
                        window.opener.sx.EventManager.trigger(this.GetParams['callbackEvent'], data);
                        return this;
                    }
                } else if (window.parent)
                {
                    if (window.parent.sx)
                    {
                        window.parent.sx.EventManager.trigger(this.GetParams['callbackEvent'], data);
                        return this;
                    }
                }
            }

            return this;
        }
    });

    sx.SelectCmsElement = new sx.classes.SelectCmsElement();

})(sx, sx.$, sx._);
JS
);
?>
<?
    $search = new \yiisns\kernel\models\Search(\yiisns\kernel\models\User::className());
    $dataProvider = $search->getDataProvider();

    $dataProvider->sort->defaultOrder = [
        'created_at' => SORT_DESC
    ];

    $dataProvider   = $search->search(\Yii::$app->request->queryParams);
    $searchModel    = $search->loadedModel;
?>
<?= \yiisns\admin\widgets\GridViewStandart::widget([
    'dataProvider'      => $dataProvider,
    'filterModel'       => $searchModel,
    'adminController'   => @$controller,
    'enabledCheckbox'   => false,
    'columns' => [
        [
            'class'     => \yii\grid\DataColumn::className(),
            'value'     => function(\yiisns\kernel\models\User $model)
            {
                return \yii\helpers\Html::a('<i class="glyphicon glyphicon-circle-arrow-left"></i> '.\Yii::t('yiisns/kernel','Choose'), '#', [
                    'class' => 'btn btn-primary sx-row-action',
                    'onclick' => 'sx.SelectCmsElement.submit(' . \yii\helpers\Json::encode($model->toArray([], ['displayName'])) . '); return false;',
                    'data-pjax' => 0
                ]);
            },
            'format' => 'raw'
        ],

        [
            'class'             => \yiisns\kernel\grid\ImageColumn2::className(),
            'attribute'         => 'image_id',
            'relationName'      => 'image',
        ],

        'username',
        'name',
        'email',
        'phone',


        ['class' => \yiisns\kernel\grid\CreatedAtColumn::className()],
        [
            'class' => \yiisns\kernel\grid\DateTimeColumnData::className(),
            'attribute' => 'logged_at'
        ],

        [
            'class'     => \yii\grid\DataColumn::className(),
            'value'     => function(\yiisns\kernel\models\User $model)
            {
                $result = [];

                if ($roles = \Yii::$app->authManager->getRolesByUser($model->id))
                {
                    foreach ($roles as $role)
                    {
                        $result[] = $role->description . " ({$role->name})";
                    }
                }

                return implode(', ', $result);
            },
            'format'    => 'html',
            'label'     => \Yii::t('yiisns/kernel', 'Roles'),
        ],

        [
            'class'         => \yiisns\kernel\grid\BooleanColumn::className(),
            'attribute'     => "active",
        ],
    ],
]); 
?>