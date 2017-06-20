<?php
/**
 * index
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.10.2016
 * @since 1.0.0
 */

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<? $pjax = \yiisns\admin\widgets\Pjax::begin(); ?>
    <?
        $user = new \yiisns\kernel\models\User();
        $searchRelatedPropertiesModel = new \yiisns\kernel\models\searchs\SearchRelatedPropertiesModel();
        $searchRelatedPropertiesModel->propertyElementClassName = \yiisns\kernel\models\UserProperty::className();
        $searchRelatedPropertiesModel->initProperties( $user->relatedProperties );
        $searchRelatedPropertiesModel->load(\Yii::$app->request->get());
        if ($dataProvider)
        {
            $searchRelatedPropertiesModel->search($dataProvider, $user->tableName());
        }

        if ($user->relatedPropertiesModel)
        {
            $autoColumns = \yiisns\admin\widgets\GridViewStandart::getColumnsByRelatedPropertiesModel($user->relatedPropertiesModel, $searchRelatedPropertiesModel);
        }
    ?>
    <?php echo $this->render('_search', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider
    ]); ?>

    <?= \yiisns\admin\widgets\GridViewStandart::widget([
        'dataProvider'  => $dataProvider,
        'filterModel'   => $searchModel,
        'adminController'   => $controller,
        'pjax'              => $pjax,
        'columns' => \yii\helpers\ArrayHelper::merge([
            [
                'class'             => \yiisns\kernel\grid\ImageColumn2::className(),
                'attribute'         => 'image_id',
                'relationName'      => 'image',
            ],
            'username',
            'name',
            'email',
            [
                'class'         => \yiisns\kernel\grid\BooleanColumn::className(),
                'attribute'     => 'email_is_approved',
                'trueValue'     => 1,
                'falseValue'     => 0,
            ],

            'phone',
            
            [
                'class'         => \yiisns\kernel\grid\BooleanColumn::className(),
                'attribute'     => 'phone_is_approved',
                'trueValue'     => 1,
                'falseValue'     => 0,
            ],

            ['class' => \yiisns\kernel\grid\CreatedAtColumn::className()],
            [
                'class' => \yiisns\kernel\grid\DateTimeColumnData::className(),
                'attribute' => 'logged_at'
            ],

            [
                'class'     => \yii\grid\DataColumn::className(),
                'filter'     => \yii\helpers\Html::activeListBox($searchModel, 'role',
                    \yii\helpers\ArrayHelper::merge([
                        '' => ' - '
                    ], \yii\helpers\ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description'))
                    , [
                    'size' => 1,
                    'class' => 'form-control'
                ]),
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
                'label'     => \Yii::t('yiisns/kernel','Roles'),
            ],

            [
                'class'         => \yiisns\kernel\grid\BooleanColumn::className(),
                'attribute'     => "active",
            ],

            [
                'class'     => \yii\grid\DataColumn::className(),
                'label'     => \Yii::t('yiisns/kernel', 'Watch'),
                'value'     => function(\yiisns\kernel\models\User $model)
                {

                    return \yii\helpers\Html::a('<i class="glyphicon glyphicon-arrow-right"></i>', $model->getProfileUrl(), [
                        'target' => '_blank',
                        'title' => \Yii::t('yiisns/kernel','Watch to site (opens new window)'),
                        'data-pjax' => '0',
                        'class' => 'btn btn-default btn-sm'
                    ]);

                },
                'format' => 'raw'
            ],

            [
                'class' => \yiisns\kernel\grid\DateTimeColumnData::className(),
                'attribute' => 'last_activity_at',
                'visible' => false,
            ],
        ], $autoColumns),
    ]); ?>
<? $pjax::end(); ?>