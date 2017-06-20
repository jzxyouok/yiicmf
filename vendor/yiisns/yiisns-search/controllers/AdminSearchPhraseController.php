<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.04.2016
 */
namespace yiisns\search\controllers;

use yiisns\kernel\grid\CreatedByColumn;
use yiisns\kernel\grid\SiteColumn;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\traits\AdminModelEditorStandartControllerTrait;
use yiisns\search\models\SearchPhrase;
use yii\helpers\ArrayHelper;

/**
 * Class AdminSearchPhraseController
 * @package yiisns\search\controllers
 */
class AdminSearchPhraseController extends AdminModelEditorController
{
    use AdminModelEditorStandartControllerTrait;

    public function init()
    {
        $this->name                     = \Yii::t('yiisns/search', 'Jump list');
        $this->modelShowAttribute       = 'phrase';
        $this->modelClassName           = SearchPhrase::className();

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(),
            [
                'create' =>
                [
                    'visible' => false
                ],

                'update' =>
                [
                    'visible' => false
                ],

                'index' =>
                [
                    "columns"      => [
                        'phrase',

                        [
                            'class'         => \yiisns\kernel\grid\DateTimeColumnData::className(),
                            'attribute'     => "created_at"
                        ],

                        [
                            'attribute'     => "result_count"
                        ],

                        [
                            'attribute'     => "pages"
                        ],

                        [
                            'class'         => SiteColumn::className(),
                            'visible' => false
                        ],

                        [
                            'class'         => CreatedByColumn::className(),
                        ],

                    ],
                ],

            ]
        );
    }
}