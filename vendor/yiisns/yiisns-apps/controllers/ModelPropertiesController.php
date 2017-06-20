<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 14.04.2016
 */
namespace yiisns\apps\controllers;

use yiisns\kernel\models\forms\PasswordChangeForm;
use yiisns\kernel\models\User;
use yiisns\kernel\relatedProperties\models\RelatedElementModel;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class ModelPropertiesController
 * @package yiisns\apps\controllers
 */
class ModelPropertiesController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'validate'  => ['post'],
                    'submit'    => ['post'],
                ],
            ],
        ]);
    }


    /**
     * @return array
     */
    public function actionSubmit()
    {
        if (\Yii::$app->request->isAjax && !\Yii::$app->request->isPjax)
        {
            \Yii::$app->response->format = Response::FORMAT_JSON;

            $response = [
                'success' => false,
                'message' => \Yii::t('yiisns/apps', 'An error has occurred'),
            ];

            if (\Yii::$app->request->post('sx-model') && \Yii::$app->request->post('sx-model-value'))
            {
                $modelClass = \Yii::$app->request->post('sx-model');
                $modelValue = \Yii::$app->request->post('sx-model-value');
                /**
                 * @var RelatedElementModel $modelForm
                 */
                $modelForm = $modelClass::find()->where(['id' => $modelValue])->one();

                if (method_exists($modelForm, 'createPropertiesValidateModel'))
                {
                    $validateModel = $modelForm->createPropertiesValidateModel();
                } else
                {
                    $validateModel = $modelForm->getRelatedPropertiesModel();
                }

                if ($validateModel->load(\Yii::$app->request->post()) && $validateModel->validate())
                {
                    $validateModel->save();
                    $response['success'] = true;
                    $response['message'] = \Yii::t('yiisns/apps', 'Successfully sent');

                } else
                {
                    $response['message'] = \Yii::t('yiisns/apps', 'The form has been filled out incorrectly');
                }

                return $response;
            }
        }
    }

    /**
     * @return array
     */
    public function actionValidate()
    {
        if (\Yii::$app->request->isAjax && !\Yii::$app->request->isPjax)
        {
            if (\Yii::$app->request->post('sx-model') && \Yii::$app->request->post('sx-model-value'))
            {
                $modelClass = \Yii::$app->request->post('sx-model');
                $modelValue = \Yii::$app->request->post('sx-model-value');

                /**
                 * @var $modelForm Form
                 */
                $modelForm = $modelClass::find()->where(['id' => $modelValue])->one();

                if (method_exists($modelForm, "createPropertiesValidateModel"))
                {
                    $model = $modelForm->createPropertiesValidateModel();
                } else
                {
                    $model = $modelForm->getRelatedPropertiesModel();
                }

                $model->load(\Yii::$app->request->post());

                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }
    }
}