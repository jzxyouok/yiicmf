<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.05.2016
 */
namespace yiisns\admin\actions\modelEditor;

use yiisns\apps\helpers\UrlHelper;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\admin\filters\AccessControl;
use yiisns\admin\filters\AdminAccessControl;
use yiisns\rbac\SnsManager;
use yii\base\InvalidParamException;
use yii\behaviors\BlameableBehavior;
use yii\web\Response;

/**
 * Class AdminModelsGridAction
 * @package yiisns\admin\actions\modelEditor
 */
class AdminModelEditorCreateAction extends AdminModelEditorAction
{
    /**
     * @var bool
     */
    public $modelValidate = true;

    /**
     * @var string
     */
    public $modelScenario = "";

    public function init()
    {
        parent::init();

        $this->controller->attachBehavior('accessCreate',
        [
            'class'         => AdminAccessControl::className(),
            'only'          => [$this->id],
            'rules'         =>
            [
                [
                    'allow'         => true,
                    'matchCallback' => function($rule, $action)
                    {
                        if ($permission = \Yii::$app->authManager->getPermission(SnsManager::PERMISSION_ALLOW_MODEL_CREATE))
                        {
                            if (!\Yii::$app->user->can($permission->name))
                            {
                                return false;
                            }
                        }

                        return true;
                    }
                ],
            ],
        ]);
    }

    public function run()
    {

        if ($this->callback)
        {
            return $this->runCallback();
        }


        $modelClassName = $this->controller->modelClassName;
        $model          = new $modelClassName();
        $scenarios      = $model->scenarios();

        if ($scenarios && $this->modelScenario)
        {
            if (isset($scenarios[$this->modelScenario]))
            {
                $model->scenario = $this->modelScenario;
            }
        }

        $model->loadDefaultValues();

        $rr = new RequestResponse();

        if (\Yii::$app->request->isAjax && !\Yii::$app->request->isPjax)
        {
            return $rr->ajaxValidateForm($model);
        }

        if ($rr->isRequestPjaxPost())
        {
            if ($model->load(\Yii::$app->request->post()) && $model->save($this->modelValidate))
            {
                \Yii::$app->getSession()->setFlash('success', \Yii::t('yiisns/kernel','Saved'));

                if (\Yii::$app->request->post('submit-btn') == 'apply')
                {
                    return $this->controller->redirect(
                        UrlHelper::constructCurrent()->setCurrentRef()->enableAdmin()->setRoute($this->controller->modelDefaultAction)->normalizeCurrentRoute()
                            ->addData([$this->controller->requestPkParamName => $model->{$this->controller->modelPkAttribute}])
                            ->toString()
                    );
                } else
                {
                    return $this->controller->redirect(
                        $this->controller->indexUrl
                    );
                }

            } else
            {
                \Yii::$app->getSession()->setFlash('error', \Yii::t('yiisns/kernel', 'Could not save'));
            }
        }

        $this->viewParams =
        [
            'model' => $model
        ];

        return parent::run();
    }

    /**
     * Renders a view
     *
     * @param string $viewName view name
     * @return string result of the rendering
     */
    protected function render($viewName)
    {
        $result = '';

        try
        {
            $result = parent::render($viewName);
        } catch (InvalidParamException $e)
        {
            if (!file_exists(\Yii::$app->view->viewFile))
            {
                \Yii::warning($e->getMessage(), 'template-render');
                $result = parent::render('_form');
            }
        }

        return $result;
    }
}