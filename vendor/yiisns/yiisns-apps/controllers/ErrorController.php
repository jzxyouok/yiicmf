<?php
/**
 * ErrorController
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 04.11.2016
 * @since 1.0.0
 */
namespace yiisns\apps\controllers;

use yiisns\kernel\base\Controller;
use Yii;

/**
 * Site controller
 */
class ErrorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yiisns\kernel\actions\ErrorAction::className(),
            ],
        ];
    }
}