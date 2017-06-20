<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.04.2016
 */
namespace yiisns\seo\controllers;

use yiisns\kernel\models\Tree;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class RobotsController
 * 
 * @package yiisns\kernel\seo\controllers
 */
class RobotsController extends Controller
{
    /**
     *
     * @return string
     */
    public function actionOnRequest()
    {
        echo \Yii::$app->seo->robotsContent;
        \Yii::$app->response->format = Response::FORMAT_RAW;
        \Yii::$app->response->headers->set('Content-Type', 'text/plain');
        $this->layout = false;
    }
}