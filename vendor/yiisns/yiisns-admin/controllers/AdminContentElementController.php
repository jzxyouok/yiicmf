<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 15.05.2016
 */
namespace yiisns\admin\controllers;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\Content;
use yiisns\kernel\models\ContentElement;
use yiisns\kernel\models\ContentType;
use yiisns\kernel\models\User;
use yiisns\kernel\models\searchs\ContentElementSearch;

use yiisns\admin\actions\AdminAction;
use yiisns\admin\actions\modelEditor\AdminModelEditorAction;
use yiisns\admin\actions\modelEditor\AdminModelEditorCreateAction;
use yiisns\admin\actions\modelEditor\AdminMultiDialogModelEditAction;
use yiisns\admin\actions\modelEditor\AdminMultiModelEditAction;
use yiisns\admin\actions\modelEditor\AdminOneModelEditAction;
use yiisns\admin\controllers\AdminController;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\traits\AdminModelEditorStandartControllerTrait;
use yiisns\admin\widgets\GridViewStandart;

use yii\base\ActionEvent;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

use Yii;

/**
 * @property Content|static $content
 *
 * Class AdminContentTypeController
 * @package yiisns\admin\controllers
 */
class AdminContentElementController extends AdminModelEditorController
{
    use AdminModelEditorStandartControllerTrait;

    public function init()
    {
        $this->name                     = \Yii::t('yiisns/kernel', 'Content Elements');
        $this->modelShowAttribute       = 'name';
        $this->modelClassName           = ContentElement::className();

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = ArrayHelper::merge(parent::actions(),
            [

                'index' =>
                [
                    'modelSearchClassName' => ContentElementSearch::className()
                ],

                'create' =>
                [
                    'class'         => AdminModelEditorCreateAction::className(),
                    'callback'      => [$this, 'create'],
                ],

                'update' =>
                [
                    'class'         => AdminOneModelEditAction::className(),
                    'callback'      => [$this, 'update'],
                ],

                'activate-multi' =>
                [
                    'class' => AdminMultiModelEditAction::className(),
                    'name' => \Yii::t('yiisns/kernel', 'Activate'),
                    //'icon'              => 'glyphicon glyphicon-trash',
                    'eachCallback' => [$this, 'eachMultiActivate'],
                ],

                'inActivate-multi' =>
                [
                    'class' => AdminMultiModelEditAction::className(),
                    'name' => \Yii::t('yiisns/kernel', 'Deactivate'),
                    //'icon'              => 'glyphicon glyphicon-trash',
                    'eachCallback' => [$this, 'eachMultiInActivate'],
                ],

                'change-tree-multi' =>
                [
                    'class'             => AdminMultiDialogModelEditAction::className(),
                    'name'              => \Yii::t('yiisns/kernel', 'The main section'),
                    'viewDialog'        => 'change-tree-form',
                    'eachCallback'      => [$this, 'eachMultiChangeTree'],
                ],

                'change-trees-multi' =>
                [
                    'class'             => AdminMultiDialogModelEditAction::className(),
                    'name'              => \Yii::t('yiisns/kernel', 'Related topics'),
                    'viewDialog'        => 'change-trees-form',
                    'eachCallback'      => [$this, 'eachMultiChangeTrees'],
                ],

                'rp' =>
                [
                    'class'             => AdminMultiDialogModelEditAction::className(),
                    'name'              => \Yii::t('yiisns/kernel', 'Properties'),
                    'viewDialog'        => 'multi-rp',
                    'eachCallback'      => [$this, 'eachRelatedProperties'],
                ],
            ]
        );

        return $actions;
    }


    public function create(AdminAction $adminAction)
    {
        $modelClassName = $this->modelClassName;
        $model          = new $modelClassName();

        $model->loadDefaultValues();

        if ($content_id = \Yii::$app->request->get('content_id'))
        {
            $contentModel       = \yiisns\kernel\models\Content::findOne($content_id);
            $model->content_id  = $content_id;
        }

        $relatedModel = $model->relatedPropertiesModel;
        $relatedModel->loadDefaultValues();

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
                \Yii::$app->getSession()->setFlash('success', \Yii::t('yiisns/kernel', 'Saved'));

                if (\Yii::$app->request->post('submit-btn') == 'apply')
                {
                    return $this->redirect(
                        UrlHelper::constructCurrent()->setCurrentRef()->enableAdmin()->setRoute($this->modelDefaultAction)->normalizeCurrentRoute()
                            ->addData([$this->requestPkParamName => $model->{$this->modelPkAttribute}])
                            ->toString()
                    );
                } else
                {
                    return $this->redirect(
                        $this->indexUrl
                    );
                }

            } else
            {
                \Yii::$app->getSession()->setFlash('error', \Yii::t('yiisns/kernel', 'Could not save'));
            }
        }

        return $this->render('_form', [
            'model'           => $model,
            'relatedModel'    => $relatedModel
        ]);
    }

    public function update(AdminAction $adminAction)
    {
        /**
         * @var $model ContentElement
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
                \Yii::$app->getSession()->setFlash('success', \Yii::t('yiisns/kernel', 'Saved'));

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
                $errors = $model->errors;
                if (!$errors)
                {
                    $errors = $relatedModel->errors;
                }
                \Yii::$app->getSession()->setFlash('error', \Yii::t('yiisns/kernel', 'Could not save') . Json::encode($errors));
            }
        }

        return $this->render('_form', [
            'model'           => $model,
            'relatedModel'    => $relatedModel
        ]);
    }

    /**
     * @param ContentElement $model
     * @param $action
     * @return bool
     */
    public function eachMultiChangeTree($model, $action)
    {
        try
        {
            $formData = [];
            parse_str(\Yii::$app->request->post('formData'), $formData);
            $tmpModel = new ContentElement();
            $tmpModel->load($formData);
            if ($tmpModel->tree_id && $tmpModel->tree_id != $model->tree_id)
            {
                $model->tree_id = $tmpModel->tree_id;
                return $model->save(false);
            }

            return false;
        } catch (\Exception $e)
        {
            return false;
        }
    }

    public function eachRelatedProperties($model, $action)
    {
        try
        {
            $formData = [];
            parse_str(\Yii::$app->request->post('formData'), $formData);

            if (!$formData)
            {
                return false;
            }

            if (!$content_id = ArrayHelper::getValue($formData, 'content_id'))
            {
                return false;
            }

            if (!$fields = ArrayHelper::getValue($formData, 'fields'))
            {
                return false;
            }


            /**
             * @var Content $content
             */
            $content = Content::findOne($content_id);
            if (!$content)
            {
                return false;
            }
            
            $element            = $content->createElement();
            $relatedProperties  = $element->relatedPropertiesModel;
            $relatedProperties->load($formData);
            /**
             * @var $model ContentElement
             */
            $rpForSave = $model->relatedPropertiesModel;

            foreach ((array) ArrayHelper::getValue($formData, 'fields') as $code)
            {
                if ($rpForSave->hasAttribute($code))
                {
                    $rpForSave->setAttribute($code, ArrayHelper::getValue($formData, 'RelatedPropertiesModel.' . $code));
                }
            }

            return $rpForSave->save(false);
        } catch (\Exception $e)
        {
            return false;
        }
    }

    /**
     * @param ContentElement $model
     * @param $action
     * @return bool
     */
    public function eachMultiChangeTrees($model, $action)
    {
        try
        {
            $formData = [];
            parse_str(\Yii::$app->request->post('formData'), $formData);
            $tmpModel = new ContentElement();
            $tmpModel->load($formData);

            if (ArrayHelper::getValue($formData, 'removeCurrent'))
            {
                $model->treeIds = [];
            }

            if ($tmpModel->treeIds)
            {
                $model->treeIds = array_merge($model->treeIds, $tmpModel->treeIds);
                $model->treeIds = array_unique($model->treeIds);
            }

            return $model->save(false);
        } catch (\Exception $e)
        {
            return false;
        }
    }

    /**
     * @var Content
     */
    protected $_content = null;

    /**
     * @return string
     */
    public function getPermissionName()
    {
        if ($this->content)
        {
            return $this->content->adminPermissionName;
        }

        return parent::getPermissionName();
    }

    /**
     * @return Content|static
     */
    public function getContent()
    {
        if ($this->_content !== null)
        {
            return $this->_content;
        }

        if ($content_id = \Yii::$app->request->get('content_id'))
        {
            $this->_content = Content::findOne($content_id);
        }

        return $this->_content;
    }

    /**
     * @param $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->_content = $content;
        return $this;
    }

    public function beforeAction($action)
    {
        if ($this->content)
        {
            if ($this->content->name_meny)
            {
                $this->name = $this->content->name_meny;
            } else
            {
                $this->name = $this->content->name;
            }
        }

        return parent::beforeAction($action);
    }


    /**
     * @return string
     */
    public function getIndexUrl()
    {
        return UrlHelper::construct($this->id . '/' . $this->action->id, [
            'content_id' => \Yii::$app->request->get('content_id')
        ])->enableAdmin()->setRoute('index')->normalizeCurrentRoute()->toString();
    }

    /**
     * @param Content $content
     * @return array
     */
    static public function getColumnsByContent($content = null, $dataProvider = null)
    {
        $autoColumns = [];

        if (!$content)
        {
            return [];
        }

        $model = ContentElement::find()->where(['content_id' => $content->id])->one();

        if (!$model)
        {
            $model = new ContentElement([
                'content_id' => $content->id
            ]);
        }

        if (is_array($model) || is_object($model))
        {
            foreach ($model as $name => $value) {
                $autoColumns[] = [
                    'attribute' => $name,
                    'visible' => false,
                    'format' => 'raw',
                    'class' => \yii\grid\DataColumn::className(),
                    'value' => function($model, $key, $index) use ($name)
                    {
                        if (is_array($model->{$name}))
                        {
                            return implode(",", $model->{$name});
                        } else
                        {
                            return $model->{$name};
                        }
                    },
                ];
            }

            $searchRelatedPropertiesModel = new \yiisns\kernel\models\searchs\SearchRelatedPropertiesModel();
            $searchRelatedPropertiesModel->initProperties($content->contentProperties);
            $searchRelatedPropertiesModel->load(\Yii::$app->request->get());
            if ($dataProvider)
            {
                $searchRelatedPropertiesModel->search($dataProvider);
            }

            /**
             * @var $model \yiisns\kernel\models\ContentElement
             */
            if ($model->relatedPropertiesModel)
            {
                $autoColumns = ArrayHelper::merge($autoColumns, GridViewStandart::getColumnsByRelatedPropertiesModel($model->relatedPropertiesModel, $searchRelatedPropertiesModel));
            }
        }

        return $autoColumns;
    }

    /**
     * @param Content $content
     * @return array
     */
    static public function getDefaultColumns($content = null)
    {
        $columns = [
            [
                'class' => \yiisns\kernel\grid\ImageColumn2::className(),
            ],

            'name',
            ['class' => \yiisns\kernel\grid\CreatedAtColumn::className()],
            [
                'class' => \yiisns\kernel\grid\UpdatedAtColumn::className(),
                'visible' => false
            ],
            [
                'class' => \yiisns\kernel\grid\PublishedAtColumn::className(),
                'visible' => false
            ],
            [
                'class' => \yiisns\kernel\grid\DateTimeColumnData::className(),
                'attribute' => "published_to",
                'visible' => false
            ],

            ['class' => \yiisns\kernel\grid\CreatedByColumn::className()],
            //['class' => \yiisns\kernel\grid\UpdatedByColumn::className()],

            [
                'class'     => \yii\grid\DataColumn::className(),
                'value'     => function(\yiisns\kernel\models\ContentElement $model)
                {
                    if (!$model->tree)
                    {
                        return null;
                    }

                    $path = [];

                    if ($model->tree->parents)
                    {
                        foreach ($model->tree->parents as $parent)
                        {
                            if ($parent->isRoot())
                            {
                                $path[] =  "[" . $parent->site->name . "] " . $parent->name;
                            } else
                            {
                                $path[] =  $parent->name;
                            }
                        }
                    }
                    $path = implode(" / ", $path);
                    return "<small><a href='{$model->tree->url}' target='_blank' data-pjax='0'>{$path} / {$model->tree->name}</a></small>";
                },
                'format'    => 'raw',
                'filter' => \yiisns\apps\helpers\TreeOptions::getAllMultiOptions(),
                'attribute' => 'tree_id'
            ],

            'additionalSections' => [
                'class'     => \yii\grid\DataColumn::className(),
                'value'     => function(\yiisns\kernel\models\ContentElement $model)
                {
                    $result = [];

                    if ($model->contentElementTrees)
                    {
                        foreach ($model->contentElementTrees as $contentElementTree)
                        {

                            $site = $contentElementTree->tree->root->site;
                            $result[] = "<small><a href='{$contentElementTree->tree->url}' target='_blank' data-pjax='0'>[{$site->name}]/.../{$contentElementTree->tree->name}</a></small>";

                        }
                    }

                    return implode('<br />', $result);

                },
                'format' => 'raw',
                'label' => \Yii::t('yiisns/kernel','Additional sections'),
                'visible' => false
            ],

            [
                'attribute' => 'active',
                'class' => \yiisns\kernel\grid\BooleanColumn::className()
            ],

            [
                'class'     => \yii\grid\DataColumn::className(),
                'label'     => \Yii::t('yiisns/kernel', 'Watch'),
                'value'     => function(\yiisns\kernel\models\ContentElement $model)
                {

                    return \yii\helpers\Html::a('<i class="glyphicon glyphicon-arrow-right"></i>', $model->absoluteUrl, [
                        'target' => '_blank',
                        'title' => \Yii::t('yiisns/kernel','Watch to site (opens new window)'),
                        'data-pjax' => '0',
                        'class' => 'btn btn-default btn-sm'
                    ]);

                },
                'format' => 'raw'
            ]
        ];
        return $columns;
    }

    /**
     * @param Content $model
     * @return array
     */
    static public function getColumns($content = null, $dataProvider = null)
    {
        return \yii\helpers\ArrayHelper::merge(
            static::getDefaultColumns($content),
            static::getColumnsByContent($content, $dataProvider)
        );
    }
}