<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 18.06.2015
 */
return [

    [
        'class'     => \yii\grid\DataColumn::className(),
        'value'     => function($model)
        {
            return \yii\helpers\Html::a('<i class="glyphicon glyphicon-circle-arrow-left"></i> '.\Yii::t('yiisns/kernel','Choose'), $model->id, [
                'class' => 'btn btn-primary sx-row-action',
                'onclick' => 'sx.SelectCmsElement.submit(' . \yii\helpers\Json::encode(array_merge($model->toArray(), [
                    'url' => $model->url
                ])) . '); return false;',
                'data-pjax' => 0
            ]);
        },
        'format' => 'raw'
    ],


    [
        'class'     => \yii\grid\DataColumn::className(),
        'value'     => function(\yiisns\kernel\models\ContentElement $model)
        {
            return $model->content->name;
        },
        'format' => 'raw',
        'attribute' => 'content_id',
        'filter' => \yiisns\kernel\models\Content::getDataForSelect()
    ],


    [
        'class' => \yiisns\kernel\grid\ImageColumn2::className(),
    ],

    'name',
    ['class' => \yiisns\kernel\grid\CreatedAtColumn::className()],
    ///['class' => \yiisns\kernel\grid\UpdatedAtColumn::className()],
    ///['class' => \yiisns\kernel\grid\PublishedAtColumn::className()],
    /*[
        'class' => \yiisns\kernel\grid\DateTimeColumnData::className(),
        'attribute' => "published_to",
    ],*/

    //['class' => \yiisns\kernel\grid\CreatedByColumn::className()],
    //['class' => \yiisns\kernel\grid\UpdatedByColumn::className()],

    [
        'class'     => \yii\grid\DataColumn::className(),
        'value'     => function(\yiisns\kernel\models\ContentElement $model)
        {
            if (!$model->tree)
            {
                return null;
            }

            $path = [];

            if ($model->tree->parents)
            {
                foreach ($model->tree->parents as $parent)
                {
                    if ($parent->isRoot())
                    {
                        $path[] =  "[" . $parent->site->name . "] " . $parent->name;
                    } else
                    {
                        $path[] =  $parent->name;
                    }
                }
            }
            $path = implode(" / ", $path);
            return "<small><a href='{$model->tree->url}' target='_blank' data-pjax='0'>{$path} / {$model->tree->name}</a></small>";
        },
        'format'    => 'raw',
        'filter' => \yiisns\apps\helpers\TreeOptions::getAllMultiOptions(),
        'attribute' => 'tree_id'
    ],

    [
        'class'     => \yii\grid\DataColumn::className(),
        'value'     => function(\yiisns\kernel\models\ContentElement $model)
        {
            $result = [];

            if ($model->contentElementTrees)
            {
                foreach ($model->contentElementTrees as $contentElementTree)
                {

                    $site = $contentElementTree->tree->root->site;
                    $result[] = "<small><a href='{$contentElementTree->tree->url}' target='_blank' data-pjax='0'>[{$site->name}]/.../{$contentElementTree->tree->name}</a></small>";

                }
            }

            return implode('<br />', $result);

        },
        'format' => 'raw',
        'label' => \Yii::t('yiisns/kernel', 'Additional sections'),
    ],

    [
        'attribute' => 'active',
        'class' => \yiisns\kernel\grid\BooleanColumn::className()
    ],

    [
        'class'     => \yii\grid\DataColumn::className(),
        'value'     => function(\yiisns\kernel\models\ContentElement $model)
        {

            return \yii\helpers\Html::a('<i class="glyphicon glyphicon-arrow-right"></i>', $model->absoluteUrl, [
                'target' => '_blank',
                'title' => \Yii::t('yiisns/kernel', 'Watch to site (opens new window)'),
                'data-pjax' => '0',
                'class' => 'btn btn-default btn-sm'
            ]);

        },
        'format' => 'raw'
    ]
]
?>