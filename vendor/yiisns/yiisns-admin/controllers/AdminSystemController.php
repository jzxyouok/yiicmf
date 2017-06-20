<?php
/**
 * AdminSystemController
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 18.11.2016
 * @since 1.0.0
 */
namespace yiisns\admin\controllers;

use yiisns\apps\helpers\UrlHelper;

use yiisns\kernel\models\Comment;
use yiisns\admin\controllers\AdminController;
use yiisns\kernel\models\User;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * Class AdminUserController
 * 
 * @package yiisns\admin\controllers
 */
class AdminSystemController extends AdminController
{
    public function init()
    {
        $this->_label = '';
        parent::init();
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            
            self::BEHAVIOR_ACTION_MANAGER => [],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'session' => [
                        'post'
                    ]
                ]
            ]
        ]);
    }

    public function actionSession()
    {
        if (\Yii::$app->request->get('site') !== null) {
            \Yii::$app->getSession()->set('site', \Yii::$app->request->get('site'));
        }
        
        if (\Yii::$app->request->get('lang') !== null) {
            \Yii::$app->getSession()->set('lang', \Yii::$app->request->get('lang'));
        }
        
        return $this->redirect(\Yii::$app->request->getReferrer());
    }
}