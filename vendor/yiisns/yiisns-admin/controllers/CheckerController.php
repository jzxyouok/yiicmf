<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 26.04.2016
 */
namespace yiisns\admin\controllers;

use yiisns\apps\helpers\UrlHelper;
use yiisns\apps\base\CheckComponent;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\kernel\models\Search;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\controllers\helpers\rules\NoModel;
use yiisns\admin\models\forms\SshConsoleForm;
use yiisns\admin\widgets\ActiveForm;
use yiisns\sx\Dir;

use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Response;

/**
 * 
 * @package yiisns\admin\controllers
 */
class CheckerController extends AdminController
{

    public function init()
    {
        $this->name = \Yii::t('yiisns/kernel', 'Checking system');
        parent::init();
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => AdminAction::className(),
                'name' => \Yii::t('yiisns/kernel', 'Testing')
            ]
        ];
    }

    public function actionCheckTest()
    {
        $rr = new RequestResponse();
        
        if ($rr->isRequestAjaxPost()) {
            
            if (\Yii::$app->request->post('className')) {
                $className = \Yii::$app->request->post('className');
                if (! class_exists($className)) {
                    $rr->message = \Yii::t('yiisns/kernel', 'Test is not found');
                    return (array) $rr;
                }
                
                if (! is_subclass_of($className, CheckComponent::className())) {
                    $rr->message = \Yii::t('yiisns/kernel', 'Incorrect test');
                    return (array) $rr;
                }
                
                /**
                 *
                 * @var $checkTest CheckComponent
                 */
                try {
                    $checkTest = new $className();
                    if ($lastValue = \Yii::$app->request->post('lastValue')) {
                        $checkTest->lastValue = $lastValue;
                    }
                    $checkTest->run();
                    
                    $rr->success = true;
                    $rr->data = (array) $checkTest;
                } catch (\Exception $e) {
                    $rr->message = \Yii::t('yiisns/kernel', 'Test is not done') . ': ' . $e->getMessage();
                }
            }
        }     
        return (array) $rr;
    }
}