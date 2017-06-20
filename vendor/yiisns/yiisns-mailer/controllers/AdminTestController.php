<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 25.03.2016
 */
namespace yiisns\mail\controllers;

use yiisns\apps\helpers\UrlHelper;
use yiisns\mail\models\forms\EmailConsoleForm;
use yiisns\kernel\models\Search;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\controllers\AdminController;
use yiisns\admin\controllers\helpers\rules\NoModel;
use yiisns\admin\models\forms\SshConsoleForm;
use yiisns\admin\widgets\ActiveForm;
use yiisns\sx\Dir;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

use Yii;
use yii\web\Response;

/**
 * Class IndexController
 * 
 * @package yiisns\admin\controllers
 */
class AdminTestController extends AdminController
{

    public function init()
    {
        $this->name = \Yii::t('yiisns/mail', 'Testing send email messages from site');
        
        parent::init();
    }

    public function actionIndex()
    {
        $model = new EmailConsoleForm();
        
        if (\Yii::$app->request->isAjax && ! \Yii::$app->request->isPjax) {
            $model->load(\Yii::$app->request->post());
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        $result = "";
        
        if ($model->load(\Yii::$app->request->post()) && $model->execute()) {
            $result = \Yii::t('yiisns/mail', 'Submitted');
        } else {
            if (\Yii::$app->request->post()) {
                $result = \Yii::t('yiisns/mail', 'Not sent');
            }
        }
        
        return $this->render('index', [
            'model' => $model,
            'result' => $result
        ]);
    }
}