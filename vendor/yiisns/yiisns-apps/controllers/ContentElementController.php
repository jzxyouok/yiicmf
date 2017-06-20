<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 14.04.2016
 */
namespace yiisns\apps\controllers;

use yiisns\kernel\base\Controller;
use yiisns\apps\filters\AccessControl;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\ContentElement;
use yiisns\kernel\models\Tree;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * @property ContentElement $model
 *
 * Class ContentElementController
 * @package yiisns\apps\controllers
 */
class ContentElementController extends Controller
{
    /**
     * @var ContentElement
     */
    public $_model = false;

    public function init()
    {
        if ($this->model && \Yii::$app->toolbar)
        {
            $controller = \Yii::$app->createController('admin/admin-content-element')[0];
            $adminControllerRoute = ['admin/admin-content-element/update', $controller->requestPkParamName => $this->model->{$controller->modelPkAttribute}];

            $urlEditModel = UrlHelper::construct($adminControllerRoute)->enableAdmin()
                ->setSystemParam(\yiisns\admin\Module::SYSTEM_QUERY_EMPTY_LAYOUT, 'true')->toString();

            \Yii::$app->toolbar->editUrl = $urlEditModel;
        }

        parent::init();
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'viewAccess' =>
            [
                'class'         => AccessControl::className(),
                'only'          => ['view'],
                'rules'         =>
                [
                    [
                        'allow'         => true,
                        'matchCallback' => function($rule, $action)
                        {
                            if ($this->model->content && $this->model->content->access_check_element == 'Y')
                            {
                                if ($permission = \Yii::$app->authManager->getPermission($this->model->permissionName))
                                {
                                    if (!\Yii::$app->user->can($permission->name))
                                    {
                                        return false;
                                    }
                                }
                            }

                            return true;
                        }
                    ],
                ],
            ]
        ]);
    }

    /**
     * @return array|bool|null|Tree|\yii\db\ActiveRecord
     */
    public function getModel()
    {
        if ($this->_model !== false)
        {
            return $this->_model;
        }

        if (!$id = \Yii::$app->request->get('id'))
        {
            $this->_model = null;
            return false;
        }

        $this->_model = ContentElement::findOne(['id' => $id]);

        return $this->_model;
    }

    /**
     * @return $this|string
     * @throws NotFoundHttpException
     */
    public function actionView()
    {
        if (!$this->model) {
            throw new NotFoundHttpException(\Yii::t('yiisns/kernel', 'Page not found'));
        }

        $contentElement     = $this->model;
        $tree               = $contentElement->tree;

        if ($tree)
        {
            \Yii::$app->appSettings->setCurrentTree($tree);
            \Yii::$app->breadcrumbs->setPartsByTree($tree);

            \Yii::$app->breadcrumbs->append([
                'url'   => $contentElement->url,
                'name'  => $contentElement->name
            ]);
        }

        $viewFile = $this->action->id;

        $content = $this->model->content;
        if ($content)
        {
            if ($content->viewFile)
            {
                $viewFile = $content->viewFile;
            } else
            {
                $viewFile = $content->code;
            }
        }

        $this->_initStandartMetaData();

        return $this->render($viewFile, [
            'model' => $this->model
        ]);
    }

    /**
     *
     * TODO: Вынести в seo компонент
     *
     * Установка метаданных страницы
     * @return $this
     */
    protected function _initStandartMetaData()
    {
        $model = $this->model;

        if ($title = $model->meta_title)
        {
            $this->view->title = $title;
        } else
        {
            if (isset($model->name))
            {
                $this->view->title = $model->name;
            }
        }

        if ($meta_keywords = $model->meta_keywords)
        {
            $this->view->registerMetaTag([
                'name'      => 'keywords',
                'content'   => $meta_keywords
            ], 'keywords');
        }

        if ($meta_descripption = $model->meta_description)
        {
            $this->view->registerMetaTag([
                'name'      => 'description',
                'content'   => $meta_descripption
            ], 'description');
        }
        else
        {
            if (isset($model->name))
            {
                $this->view->registerMetaTag([
                    'name'      => 'description',
                    'content'   => $model->name
                ], 'description');
            }
        }

        return $this;
    }
}