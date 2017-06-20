<?php
/**
 * AdminTreeController
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 04.11.2016
 * @since 1.0.0
 */

namespace yiisns\admin\controllers;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\Site;
use yiisns\kernel\models\Search;
use yiisns\kernel\models\Tree;
use yiisns\kernel\models\User;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\actions\modelEditor\AdminOneModelEditAction;
use yiisns\admin\controllers\AdminController;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\controllers\helpers\rules\HasModel;
use yiisns\admin\widgets\ControllerActions;
use yiisns\admin\widgets\DropdownControllerActions;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Cookie;

/**
 * Class AdminUserController
 * @package yiisns\admin\controllers
 */
class AdminTreeController extends AdminModelEditorController
{
    public function init()
    {
        $this->name                   = 'A tree of pages';
        $this->modelShowAttribute     = 'name';
        $this->modelClassName         = Tree::className();

        parent::init();
    }

    public function actions()
    {
        $actions = ArrayHelper::merge(parent::actions(), [
            'index' =>
            [
                'class'         => AdminAction::className(),
                'name'          => 'Sections',
                'viewParams'    => $this->indexData()
            ],

            'create' =>
            [
                'visible'    => false
            ],

            'update' =>
            [
                'class'         => AdminOneModelEditAction::className(),
                'callback'      => [$this, 'update'],
            ],

        ]);

        unset($actions['create']);

        return $actions;
    }

    public function update(AdminAction $adminAction)
    {
        /**
         * @var $model Tree
         */
        $model = $this->model;
        $relatedModel = $model->relatedPropertiesModel;

        $rr = new RequestResponse();

        if (\Yii::$app->request->isAjax && !\Yii::$app->request->isPjax)
        {
            $model->load(\Yii::$app->request->post());
            $relatedModel->load(\Yii::$app->request->post());
            return \yii\widgets\ActiveForm::validateMultiple([
                $model, $relatedModel
            ]);
        }

        if ($rr->isRequestPjaxPost())
        {
            $model->load(\Yii::$app->request->post());
            $relatedModel->load(\Yii::$app->request->post());

            if ($model->save() && $relatedModel->save())
            {
                \Yii::$app->getSession()->setFlash('success', \Yii::t('yiisns/kernel','Saved'));

                if (\Yii::$app->request->post('submit-btn') == 'apply')
                {

                } else
                {
                    return $this->redirect(
                        $this->indexUrl
                    );
                }

                $model->refresh();

            } else
            {
                $errors = [];

                if ($model->getErrors())
                {
                    foreach ($model->getErrors() as $error)
                    {
                        $errors[] = implode(', ', $error);
                    }
                }

                \Yii::$app->getSession()->setFlash('error', \Yii::t('yiisns/kernel', 'Could not save') . $errors);
            }
        }

        return $this->render('_form', [
            'model'           => $model,
            'relatedModel'    => $relatedModel
        ]);
    }

    static public $indexData = [];

    public function indexData()
    {
        if (self::$indexData)
        {
            return self::$indexData;
        }

        $models = Tree::findRoots()->joinWith('siteRelation')->orderBy([Site::tableName() . ".priority" => SORT_ASC])->all();

        self::$indexData =
        [
            'models' => $models
        ];

        return self::$indexData;
    }

    public function actionNewChildren()
    {
        /**
         * @var Tree $parent
         */
        $parent = $this->model;

        if (\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            $childTree = new Tree();
            $parent = Tree::find()->where(['id' => $post["pid"]])->one();

            $childTree->load($post);

            if (!$childTree->priority)
            {
                $childTree->priority = Tree::PRIORITY_STEP;

                if ($treeChildrens = $parent->getChildren()->orderBy(['priority' => SORT_DESC])->one())
                {
                    $childTree->priority = $treeChildrens->priority + Tree::PRIORITY_STEP;
                }
            }

            $response = ['success' => false];

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            try
            {
                if ($parent && $parent->processAddNode($childTree))
                {
                    $response['success'] = true;
                }
            } catch (\Exception $e)
            {
                $response['success'] = false;
                $response['message'] = $e->getMessage();
            }


            if (!$post["no_redirect"])
            {
                $this->redirect(Url::to(["new-children", "id" => $parent->primaryKey]));
            }
            else
            {
                return $response;
            }
        }
        else
        {
            $tree   = new Tree();
            $search = new Search(Tree::className());
            $dataProvider   = $search->search(\Yii::$app->request->queryParams);
            $searchModel    = $search->getLoadedModel();

            $dataProvider->query->andWhere(['pid' => $parent->primaryKey]);

            $controller = \Yii::$app->getModule('admin')->createControllerByID('admin-tree');

            return $this->render('new-children', [
                'model'         => new Tree(),
                'searchModel'   => $searchModel,
                'dataProvider'  => $dataProvider,
                'controller'    => $controller,
            ]);
        }
    }

    public function actionResort()
    {
        $response =
        [
            'success' => false
        ];

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (\Yii::$app->request->isPost)
        {
            $tree = new Tree();

            $post = \Yii::$app->request->post();

            //$ids = array_reverse(array_filter($post['ids']));
            $ids = array_filter($post['ids']);

            $priority = 100;

            foreach($ids as $id)
            {
                $node = $tree->find()->where(['id'=>$id])->one();
                $node->priority = $priority;
                $node->save(false);
                $priority += 100;
            }

            $response['success'] = true;
        }

        /*
        if (\Yii::$app->request->isPost)
        {
            $tree = new Tree();

            $post = \Yii::$app->request->post();

            $resortIds = array_filter($post['ids']);
            $changeId = intval($post['changeId']);

            $changeNode = $tree->find()->where(['id' => $changeId])->one();

            $nodes = $tree->find()->where(['pid' =>$changeNode->pid])->orderBy(["priority" => SORT_DESC])->all();
            $origIds = [];
            foreach($nodes as $node)
            {
                $origIds[] = $node->id;
            }

            $origPos = array_search($changeId, $origIds);
            $resortPos = array_search($changeId, $resortIds);

            if($origPos > $resortPos)
            {
                $origIds = array_reverse($origIds);
                $offset = count($origIds) - 1;
                $origPos = $offset - $origPos;
                $resortPos = $offset - $resortPos;
            }

            for($i = $origPos+1; $i <= $resortPos; $i++)
            {
                $id = $origIds[$i];
                $node = $tree->find()->where(['id'=>$id])->one();
                $changeNode->swapPriorities($node);
            }

            $response['success'] = true;
        }
        */

        return $response;
    }
}