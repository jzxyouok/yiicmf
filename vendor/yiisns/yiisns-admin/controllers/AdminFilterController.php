<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 22.05.2016
 */
namespace yiisns\admin\controllers;

use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yiisns\kernel\helpers\RequestResponse;
use yiisns\kernel\models\AdminFilter;
use yiisns\admin\filters\AdminAccessControl;
use yiisns\admin\widgets\filters\EditFilterForm;

/**
 * @property AdminFilter $model
 *
 * Class AuthController
 * @package yiisns\admin\controllers
 */
class AdminFilterController extends AdminController
{
    /**
     *
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),
        [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                   'create' => ['post'],
                   'validate' => ['post'],
                   'save-visibles' => ['post'],
                   'save' => ['post'],
                   'delete' => ['post'],
                ]
            ]
        ]);
    }

    public function actionCreate()
    {
        $rr = new RequestResponse();

        if ($rr->isRequestAjaxPost())
        {
            $model = new AdminFilter();
            if ($model->load(\Yii::$app->request->post()) && $model->save())
            {
                if (\Yii::$app->request->post('visibles'))
                {
                    $model->visibles = explode(',', \Yii::$app->request->post('visibles'));
                }

                if ($values = \Yii::$app->request->post('values'))
                {
                    parse_str(\Yii::$app->request->post('values'), $values);
                    ArrayHelper::remove($values, 'sx-filter');
                    ArrayHelper::remove($values, '_pjax');
                    $model->values = $values;
                }

                $model->save();

                $rr->success = true;
                $rr->message = \Yii::t('yiisns/admin', 'Filter was successfully created');
            } else
            {
                $error = 'An error occurred in the time of saving' . Json::encode($model->getFirstErrors());
                $rr->success = false;
                $rr->message = \Yii::t('yiisns/kernel', $error);
            }

            return $rr;
        }

        return '1';
    }



    public function actionValidate()
    {
        $rr = new RequestResponse();

        if ($rr->isRequestAjaxPost())
        {
            $model = new AdminFilter();
            return $rr->ajaxValidateForm($model);
        }

        return '1';
    }


    public function actionSaveVisibles()
    {
        $rr = new RequestResponse();

        if ($rr->isRequestAjaxPost())
        {
            try
            {
                $model = $this->model;
                $model->visibles = \Yii::$app->request->post('visibles');

                if ($model->save())
                {
                    $rr->success = true;
                    $rr->message = \Yii::t('yiisns/admin', 'Filter was successfully saved');
                } else
                {
                    $error = 'An error occurred in the time of saving' . Json::encode($model->getFirstErrors());
                    $rr->success = false;
                    $rr->message = \Yii::t('yiisns/admin', $error);
                }

            } catch (\Exception $e)
            {
                $rr->success = false;
                $rr->message = $e->getMessage();
            }

            return $rr;
        }

        return '1';
    }


    public function actionSaveValues()
    {
        $rr = new RequestResponse();

        if ($rr->isRequestAjaxPost())
        {
            try
            {
                $model = $this->model;
                $values = [];
                parse_str(\Yii::$app->request->post('values'), $values);
                ArrayHelper::remove($values, 'sx-filter');
                ArrayHelper::remove($values, '_pjax');
                $model->values = $values;

                if ($model->save())
                {
                    $rr->success = true;
                    $rr->message = \Yii::t('yiisns/admin', 'Filter was successfully saved');
                } else
                {
                    $error = 'An error occurred in the time of saving' . Json::encode($model->getFirstErrors());
                    $rr->success = false;
                    $rr->message = \Yii::t('yiisns/admin', $error);
                }

            } catch (\Exception $e)
            {
                $rr->success = false;
                $rr->message = $e->getMessage();
            }

            return $rr;
        }

        return '1';
    }

    public function actionSave()
    {
        $rr = new RequestResponse();

        if ($rr->isRequestAjaxPost())
        {
            try
            {
                $model = $this->model;

                if ($model->load(\Yii::$app->request->post()) && $model->save())
                {
                    $rr->success = true;
                    $rr->message = \Yii::t('yiisns/admin', 'Filter was successfully saved');
                } else
                {
                    $error = 'An error occurred in the time of saving' . serialize($model->getFirstErrors());
                    $rr->success = false;
                    $rr->message = \Yii::t('yiisns/admin', $error);
                }

            } catch (\Exception $e)
            {
                $rr->success = false;
                $rr->message = $e->getMessage();
            }

            return $rr;
        }

        return '1';
    }


    public function actionDelete()
    {
        $rr = new RequestResponse();

        if ($rr->isRequestAjaxPost())
        {
            try
            {
                $model = $this->model;

                if ($model && $model->delete())
                {
                    $rr->success = true;
                    $rr->message = \Yii::t('yiisns/admin', 'Filter was successfully deleted');
                } else
                {
                    $error = 'An error occurred in the time of saving' . serialize($model->getFirstErrors());
                    $rr->success = false;
                    $rr->message = \Yii::t('yiisns/admin', $error);
                }

            } catch (\Exception $e)
            {
                $rr->success = false;
                $rr->message = $e->getMessage();
            }

            return $rr;
        }

        return '1';
    }


    /**
     * @var AdminFilter
     */
    protected $_model = null;

    /**
     * @return AdminFilter
     */
    public function getModel()
    {
        if ($this->_model !== null)
        {
            return $this->_model;
        }

        if ($pk = \Yii::$app->request->get('pk'))
        {
            $this->_model = AdminFilter::findOne($pk);
        }

        if ($pk = \Yii::$app->request->post('pk'))
        {
            $this->_model = AdminFilter::findOne($pk);
        }

        return $this->_model;
    }
}