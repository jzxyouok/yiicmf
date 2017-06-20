<?php
/**
 * AppsController
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 12.11.2016
 * @since 1.0.0
 */

namespace yiisns\apps\controllers;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\apps\helpers\UrlHelper;

use yii\db\Exception;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Class SiteController
 * @package yiisns\apps\controllers
 */
class AppsController extends Controller
{
    public function actionIndex()
    {
        return $this->render($this->action->id);
    }
}