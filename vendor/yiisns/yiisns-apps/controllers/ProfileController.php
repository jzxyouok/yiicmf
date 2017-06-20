<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 13.04.2016
 */
namespace yiisns\apps\controllers;

use yiisns\apps\filters\AccessControl;
use yii\web\Controller;

/**
 * Class ProfileController
 * 
 * @package yiisns\apps\controllers
 */
class ProfileController extends Controller
{
    /**
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            // Closed all by default
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [
                            '@'
                        ],
                        'actions' => [
                            'index'
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     *
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        return $this->redirect(\Yii::$app->user->identity->profileUrl);
    }
}