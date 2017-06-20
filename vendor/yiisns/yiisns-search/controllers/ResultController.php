<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.04.2016
 */
namespace yiisns\search\controllers;

use yiisns\kernel\base\Controller;
use yiisns\apps\helpers\StringHelper;
//use yiisns\search\models\ContentElement;
use yiisns\search\models\SearchPhrase;
use yiisns\kernel\models\Tree;
use Yii;
use yii\web\Response;

/**
 * Class SearchController
 * @package yiisns\search\controllers
 */
class ResultController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchQuery = \Yii::$app->search->searchQuery;
        $this->view->title = StringHelper::ucfirst($searchQuery) . ' — Search results';

        return $this->render($this->action->id);
    }
}