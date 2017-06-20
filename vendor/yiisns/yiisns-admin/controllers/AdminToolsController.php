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
use yiisns\kernel\models\Site;
use yiisns\kernel\models\Tree;
use yiisns\kernel\models\forms\ViewFileEditModel;
use yiisns\admin\controllers\AdminController;
use yiisns\admin\filters\AdminAccessControl;
use yiisns\admin\widgets\UserLastActivityWidget;
use yiisns\rbac\SnsManager;
use yiisns\apps\widgets\formInputs\selectTree\SelectTree;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\Response;

/**
 * Class AdminUserController
 * @package yiisns\admin\controllers
 */
class AdminToolsController extends AdminController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),
        [
            'adminViewEditAccess' =>
            [
                'class' => AdminAccessControl::className(),
                'only' => ['view-file-edit'],
                'rules' =>
                [
                    [
                        'allow' => true,
                        'roles' =>
                        [
                            SnsManager::PERMISSION_EDIT_VIEW_FILES
                        ],
                    ],
                ]
            ],
        ]);
    }

    public function init()
    {
        $this->name = 'Management pattern';
        parent::init();
    }

    /**
     * The name of the privilege of access to this controller
     * @return string
     */
    public function getPermissionName()
    {
        return '';
    }

    public function actionViewFileEdit()
    {
        $rootViewFile = \Yii::$app->request->get('root-file');

        $model = new ViewFileEditModel([
            'rootViewFile' => $rootViewFile
        ]);

        $rr = new RequestResponse();

        if ($rr->isRequestAjaxPost())
        {
            if ($model->load(\Yii::$app->request->post()))
            {
                if (!$model->saveFile())
                {
                    $rr->success = false;
                    $rr->message = \Yii::t('yiisns/kernel', 'Could not save file');
                }

                $rr->message = \Yii::t('yiisns/kernel', 'Retained');
                $rr->success = true;
            }

            return $rr;
        }

        return $this->render($this->action->id, [
            'model' => $model
        ]);
    }

    /**
     * @return string
     */
    public function actionSelectFile()
    {
        $this->layout = '@yiisns/admin/views/layouts/main.php';
        \Yii::$app->toolbar->enabled = 0;

        $model = null;
        $className = \Yii::$app->request->get('className');
        $pk = \Yii::$app->request->get('pk');

        if ($className && $pk)
        {
            if ($model = $className::findOne($pk))
            {

            }
        }

        return $this->render($this->action->id, [
            'model' => $model
        ]);
    }

    /**
     * @return string
     */
    public function actionSelectElement()
    {
        $this->layout = '@yiisns/admin/views/layouts/main.php';
        \Yii::$app->toolbar->enabled = 0;

        return $this->render($this->action->id);
    }

    /**
     * @return string
     */
    public function actionSelectUser()
    {
        $this->layout = '@yiisns/admin/views/layouts/main.php';
        \Yii::$app->toolbar->enabled = 0;

        return $this->render($this->action->id);
    }

    /**
     * @return RequestResponse
     */
    public function actionGetUser()
    {
        $rr = new RequestResponse();

        $rr->data = [
            'identity'  => \Yii::$app->user->identity,
            'user'      => \Yii::$app->user,
        ];

        return $rr;
    }

    /**
     * @return RequestResponse
     */
    public function actionAdminLastActivity()
    {
        $rr = new RequestResponse();

        if (!\Yii::$app->user->isGuest)
        {
            $rr->data = (new UserLastActivityWidget())->getOptions();
        } else
        {
            $rr->data = [
                'isGuest' => true
            ];
        }

        return $rr;
    }

    /**
     * @return string
     */
    protected function _getMode()
    {
        if ($mode = \Yii::$app->request->getQueryParam('mode'))
        {
            return (string) $mode;
        }

        return '';
    }

    /**
     * @param $model
     *
     * @return string
     */
    public function renderNodeControll($model)
    {
        if ($this->_getMode() == SelectTree::MOD_MULTI)
        {
            $controllElement = Html::checkbox('tree_id', false, [
                'value'     => $model->id,
                'class'     => 'sx-checkbox',
                'style'     => 'float: left; margin-left: 5px; margin-right: 5px;',
                'onclick'   => new JsExpression(<<<JS
    sx.Tree.select("{$model->id}");
JS
)
            ]);
            
        } else if ($this->_getMode() == SelectTree::MOD_SINGLE)
        {

            $controllElement = Html::radio('tree_id', false, [
                'value'     => $model->id,
                'class'     => 'sx-readio',
                'style'     => 'float: left; margin-left: 5px; margin-right: 5px;',
                'onclick'   => new JsExpression(<<<JS
    sx.Tree.selectSingle("{$model->id}");
JS
)
            ]);

        }  else if ($this->_getMode() == SelectTree::MOD_COMBO)
        {

            $controllElement = Html::radio('tree_id', false, [
                                'value'     => $model->id,
                                'class'     => 'sx-readio',
                                'style'     => 'float: left; margin-left: 5px; margin-right: 5px;',
                                'onclick'   => new JsExpression(<<<JS
                    sx.Tree.selectSingle("{$model->id}");
JS
            )
                ]);

            $controllElement .= Html::checkbox('tree_id', false, [
                'value'     => $model->id,
                'class'     => 'sx-checkbox',
                'style'     => 'float: left; margin-left: 5px; margin-right: 5px;',
                'onclick'   => new JsExpression(<<<JS
    sx.Tree.select("{$model->id}");
JS
)
            ]);

        } else
        {
            $controllElement = '';
        }

        return $controllElement;
    }

    public function actionTree()
    {
        return $this->render($this->action->id, [
            'models' => Tree::findRoots()->joinWith('siteRelation')->orderBy([Site::tableName() . ".priority" => SORT_ASC])->all()
        ]);
    }
}