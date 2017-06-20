<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 14.04.2016
 */
namespace yiisns\apps\controllers;

use yiisns\kernel\base\Controller;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\Tree;

use Yii;
use yii\web\NotFoundHttpException;

/**
 *
 * @property Tree $model Class TreeController
 * @package yiisns\apps\controllers
 */
class TreeController extends Controller
{
    /**
     * @var Tree
     */
    public $_model = false;

    public function init()
    {
        if ($this->model && \Yii::$app->toolbar) {
            $controller = \Yii::$app->createController('admin/admin-tree')[0];
            $adminControllerRoute = [
                'apps/admin-tree/update',
                $controller->requestPkParamName => $this->model->{$controller->modelPkAttribute}
            ];
            
            $urlEditModel = UrlHelper::construct($adminControllerRoute)->enableAdmin()
                ->setSystemParam(\yiisns\admin\Module::SYSTEM_QUERY_EMPTY_LAYOUT, 'true')
                ->toString();
            
            \Yii::$app->toolbar->editUrl = $urlEditModel;
        }
        parent::init();
    }

    /**
     *
     * @return array|bool|null|Tree|\yii\db\ActiveRecord
     */
    public function getModel()
    {
        if ($this->_model !== false) {
            return $this->_model;
        }
        
        if (! $id = \Yii::$app->request->get('id')) {
            $this->_model = null;
            return false;
        }
        
        $this->_model = Tree::find()->where([
            'id' => $id
        ])->one();
        
        return $this->_model;
    }

    /**
     *
     * @return $this|string
     * @throws NotFoundHttpException
     */
    public function actionView()
    {
        if (!$this->model) {
            throw new NotFoundHttpException(\Yii::t('yiisns/kernel', 'Page not found'));
        }
        
        \Yii::$app->appSettings->setCurrentTree($this->model);
        \Yii::$app->breadcrumbs->setPartsByTree($this->model);
        
        if ($this->model->redirect || $this->model->redirect_tree_id) {
            return \Yii::$app->response->redirect($this->model->url, $this->model->redirect_code);
        }
        
        $viewFile = $this->action->id;
        if ($this->model) {
            if ($this->model->view_file) {
                $viewFile = $this->model->view_file;
            } else 
                if ($this->model->treeType) {
                    if ($this->model->treeType->viewFile) {
                        $viewFile = $this->model->treeType->viewFile;
                    } else {
                        $viewFile = $this->model->treeType->code;
                    }
                }
        }
        
        $this->_initStandartMetaData();
        
        return $this->render($viewFile, [
            'model' => $this->model
        ]);
    }

    /**
     *
     * @return $this
     */
    protected function _initStandartMetaData()
    {
        $model = $this->model;
        
        if ($title = $model->meta_title) {
            $this->view->title = $title;
        } else {
            if (isset($model->name)) {
                $this->view->title = $model->name;
            }
        }
        
        if ($meta_keywords = $model->meta_keywords) {
            $this->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $meta_keywords
            ], 'keywords');
        }
        
        if ($meta_descripption = $model->meta_description) {
            $this->view->registerMetaTag([
                'name' => 'description',
                'content' => $meta_descripption
            ], 'description');
        } else {
            if (isset($model->name)) {
                $this->view->registerMetaTag([
                    'name' => 'description',
                    'content' => $model->name
                ], 'description');
            }
        }
        
        return $this;
    }
}