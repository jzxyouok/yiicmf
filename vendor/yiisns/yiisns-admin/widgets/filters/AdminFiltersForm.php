<?php
/**
 * ActiveForm
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 11.11.2016
 * @since 1.0.0
 */
namespace yiisns\admin\widgets\filters;

use yiisns\apps\base\widgets\ActiveFormAjaxSubmit;
use yiisns\apps\helpers\StringHelper;
use yiisns\apps\helpers\UrlHelper;

use yiisns\kernel\traits\ActiveFormAjaxSubmitTrait;
use yiisns\kernel\models\AdminFilter;
use yiisns\admin\assets\AdminFormAsset;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\traits\ActiveFormTrait;
use yiisns\admin\traits\AdminActiveFormTrait;
use yiisns\admin\widgets\Pjax;

use yii\base\Exception;
use yii\base\Model;
use yii\bootstrap\Modal;
use yii\bootstrap\Tabs;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\jui\Dialog;
use yii\widget\chosen\Chosen;

/**
 *
 * @property AdminFilter[] $savedFilters
 * @property AdminFilter $filter Class ActiveForm
 * @package yiisns\admin\widgets
 */
class AdminFiltersForm extends \yiisns\apps\base\widgets\ActiveForm
{
    public $fieldClass = 'yiisns\admin\widgets\filters\FilterActiveField';

    public $namespace;

    public $method = 'get';

    public $enableClientValidation = false;

    public $options = [
        'data-pjax' => true
    ];

    public $indexUrl = null;

    public $filterParametrName = 'yiisns-filter';

    public $filterApplyedParametrName = 'sx-applyed';

    /**
     * Initializes the widget.
     * This renders the form open tag.
     */
    public function init()
    {
        if (! $this->namespace) {
            $this->namespace = \Yii::$app->controller->uniqueId;
        }
        
        if (! $this->indexUrl) {
            $this->indexUrl = \Yii::$app->controller->indexUrl;
        }
        
        $this->filter;
        
        if ($classes = ArrayHelper::getValue($this->options, 'class')) {
            $this->options = ArrayHelper::merge($this->options, [
                'class' => $classes . 'sx-admin-filters-form form-horizontal'
            ]);
        } else {
            $this->options = ArrayHelper::merge($this->options, [
                'class' => 'sx-admin-filters-form form-horizontal'
            ]);
        }
        
        echo $this->render('_header');
        
        parent::init();
    }

    /**
     *
     * @return AdminFilter[]
     */
    public function getSavedFilters()
    {
        $query = AdminFilter::find()->where([
            'namespace' => $this->namespace
        ])
            ->andWhere([
            'or',
            [
                'user_id' => null
            ],
            [
                'user_id' => ''
            ],
            [
                'user_id' => \Yii::$app->user->id
            ]
        ])
            ->orderBy([
            'is_default' => SORT_DESC
        ]);
        
        return $query->all();
    }

    /**
     *
     * @var AdminFilter
     */
    protected $_filter = null;

    public function getFilter()
    {
        if ($this->_filter === null || ! $this->_filter instanceof AdminFilter) {
            // Find in get params
            if ($activeFilterId = (int) \Yii::$app->request->get($this->filterParametrName)) {
                if ($filter = AdminFilter::findOne($activeFilterId)) {
                    $this->_filter = $filter;
                    return $this->_filter;
                } else {
                    \Yii::$app->response->redirect($this->indexUrl);
                    \Yii::$app->end();
                }
            }
            
            // Defauilt filter
            $filter = AdminFilter::find()->where([
                'namespace' => $this->namespace
            ])
                ->andWhere([
                'user_id' => \Yii::$app->user->id
            ])
                ->andWhere([
                'is_default' => 1
            ])
                ->one();
            
            if (! $filter) {
                $filter = new AdminFilter([
                    'namespace' => $this->namespace,
                    'user_id' => \Yii::$app->user->id,
                    'is_default' => 1
                ]);
                $filter->loadDefaultValues();
                
                if ($filter->save()) {} else {
                    throw new Exception('Filter not saved');
                }
            }
            
            $this->_filter = $filter;
        }
        
        return $this->_filter;
    }

    /**
     *
     * @param AdminFilter $filter            
     * @return string
     */
    public function getFilterUrl(AdminFilter $filter)
    {
        $query = [];
        $url = $this->indexUrl;
        
        if ($pos = strpos($this->indexUrl, '?')) {
            $url = StringHelper::substr($this->indexUrl, 0, $pos);
            $stringQuery = StringHelper::substr($this->indexUrl, $pos + 1, StringHelper::strlen($this->indexUrl));
            parse_str($stringQuery, $query);
        }
        
        if ($filter->values) {
            $query = ArrayHelper::merge($query, $filter->values);
        }
        
        $query[$this->filterParametrName] = $filter->id;
        
        return $url . '?' . http_build_query($query);
    }

    public function run()
    {
        $closeUrl = $this->indexUrl;
        
        echo Html::hiddenInput($this->filterParametrName, $this->filter->id);
        
        echo $this->render('_footer-group');
        
        parent::run();
        
        echo <<<HTML

                </div>
            </div>
        </div>
    </div>
</div>
HTML;
        ;
        
        echo $this->render('_edit-filter-form');
        
        AdminFiltersFormAsset::register($this->view);
        
        $jsOptions = Json::encode([
            'id' => $this->id,
            'createModalId' => $this->getCreateModalId(),
            'backendSaveVisibles' => Url::to([
                '/admin/admin-filter/save-visibles',
                'pk' => $this->filter->id
            ]),
            'backendSaveValues' => Url::to([
                '/admin/admin-filter/save-values',
                'pk' => $this->filter->id
            ]),
            'backendDelete' => Url::to([
                '/admin/admin-filter/delete',
                'pk' => $this->filter->id
            ]),
            'visibles' => $this->filter->visibles,
            'indexUrl' => $this->indexUrl,
            'showAllTitle' => \Yii::t('yiisns/admin', 'Show all conditions'),
            'hideAllTitle' => \Yii::t('yiisns/admin', 'Hide all conditions')
        ]);
        
        $this->view->registerJs(<<<JS
        new sx.classes.filters.Form({$jsOptions});
JS
);
    }

    public function getEditFilterFormModalId()
    {
        return $this->id . '-modal-update-filter';
    }

    public function getCreateModalId()
    {
        return $this->id . '-modal-create-filter';
    }

    public function fieldSet($name, $options = [])
    {
        return <<<HTML
        <div class="sx-form-fieldset">
            <h3 class="sx-form-fieldset-title">{$name}</h3>
            <div class="sx-form-fieldset-content">
HTML;
    }

    public function fieldSetEnd()
    {
        return <<<HTML
            </div>
        </div>
HTML;
    }

    public $fields = [];

    /**
     *
     * @param Model $model            
     * @param string $attribute            
     * @param array $options            
     * @return FilterActiveField
     */
    public function field($model, $attribute, $options = [])
    {
        $field = parent::field($model, $attribute, $options);
        
        if ($model && $attribute) {
            $this->fields[Html::getInputId($model, $attribute)] = Html::getInputId($model, $attribute);
        }
        return $field;
    }

    /**
     *
     * @param $model
     */
    public function relatedFields($searchRelatedPropertiesModel)
    {
        echo $this->render('_related-fields', [
            'searchRelatedPropertiesModel' => $searchRelatedPropertiesModel
        ]);
    }
}