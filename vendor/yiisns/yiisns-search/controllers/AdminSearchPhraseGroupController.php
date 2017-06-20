<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.04.2016
 */
namespace yiisns\search\controllers;

use yiisns\kernel\grid\SiteColumn;
use yiisns\kernel\models\Agent;
use yiisns\kernel\models\Content;
use yiisns\kernel\models\SearchPhrase;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\actions\modelEditor\AdminMultiModelEditAction;
use yiisns\admin\actions\modelEditor\ModelEditorGridAction;
use yiisns\admin\controllers\AdminController;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\traits\AdminModelEditorStandartControllerTrait;
use yii\helpers\ArrayHelper;

/**
 * Class AdminSearchPhraseGroupController
 * @package yiisns\search\controllers
 */
class AdminSearchPhraseGroupController extends AdminController
{
    public function init()
    {
        $this->name = \Yii::t('yiisns/search', 'Jump list');

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(),
            [
                'index' =>
                [
                    'class'         => AdminAction::className(),
                    'icon'          => 'glyphicon glyphicon-th-list',
                    'priority'      => 0,
                    'name'          => \Yii::t('yiisns/search', 'List'),
                ],
            ]
        );
    }
}