<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.05.2016
 */
namespace yiisns\form2\controllers;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\kernel\models\forms\PasswordChangeForm;
use yiisns\kernel\models\User;
use yiisns\kernel\relatedProperties\models\RelatedElementModel;
use yiisns\kernel\relatedProperties\models\RelatedPropertiesModel;
use yiisns\form2\models\Form2Form;
use yiisns\form2\models\Form2FormSend;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class BackendController
 * @package yiisns\form2\controllers
 */
class BackendController extends Controller
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
        $rr = new RequestResponse();

        if (\Yii::$app->request->isAjax && !\Yii::$app->request->isPjax)
        {
            if (\Yii::$app->request->post('sx-model') && \Yii::$app->request->post('sx-model-value'))
            {
                $modelClass = \Yii::$app->request->post('sx-model');
                $modelValue = \Yii::$app->request->post('sx-model-value');
                /**
                 * @var RelatedElementModel $modelForm
                 * @var Form2FormSend $modelFormSend
                 * @var RelatedPropertiesModel $validateModel
                 * @var Form2Form $modelForm
                 */
                $modelForm                  = $modelClass::find()->where(['id' => $modelValue])->one();
                $modelFormSend              = $modelForm->createModelFormSend();
                $modelFormSend->site_code   = \Yii::$app->appSettings->site->code;
                $modelFormSend->page_url    = \Yii::$app->request->referrer;

                $validateModel = $modelFormSend->relatedPropertiesModel;

                $modelFormSend->data_values     = $validateModel->toArray($validateModel->attributes());
                $modelFormSend->data_labels     = $validateModel->attributeLabels();
                $modelFormSend->emails          = $modelForm->emails;
                $modelFormSend->phones          = $modelForm->phones;


                if ($validateModel->load(\Yii::$app->request->post()) && $validateModel->validate())
                {
                    if (!$modelFormSend->save())
                    {
                        $rr->success = false;
                        $rr->message = \Yii::t('yiisns/form2', 'Failed to send the form');
                        return (array) $rr;
                    }

                    $validateModel->save();

                    $modelFormSend->notify();

                    $rr->success = true;
                    $rr->message = \Yii::t('yiisns/form2', 'Successfully sent');

                } else
                {
                    $rr->success = false;
                    $rr->message = \Yii::t('yiisns/form2', 'Check the correctness of filling the form fields');
                }

                return (array) $rr;
            }
        }
    }

    /**
     * @return array
     */
    public function actionValidate()
    {
        $rr = new RequestResponse();

        if (\Yii::$app->request->isAjax && !\Yii::$app->request->isPjax)
        {
            if (\Yii::$app->request->post('sx-model') && \Yii::$app->request->post('sx-model-value'))
            {
                $modelClass = \Yii::$app->request->post('sx-model');
                $modelValue = \Yii::$app->request->post('sx-model-value');

                /**
                 * @var $modelForm Form2Form
                 */
                $modelForm = $modelClass::find()->where(['id' => $modelValue])->one();
                $modelHasRelatedProperties = $modelForm->createModelFormSend();

                if (method_exists($modelHasRelatedProperties, "createPropertiesValidateModel"))
                {
                    $model = $modelHasRelatedProperties->createPropertiesValidateModel();
                } else
                {
                    $model = $modelHasRelatedProperties->getRelatedPropertiesModel();
                }

                return $rr->ajaxValidateForm($model);
            }
        }
    }
}