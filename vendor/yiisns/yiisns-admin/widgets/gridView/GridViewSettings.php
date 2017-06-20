<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 02.06.2016
 */
namespace yiisns\admin\widgets\gridView;

use yiisns\apps\components\AppSettings;
use yiisns\kernel\base\Component;
use yiisns\admin\widgets\GridViewHasSettings;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class GridViewSettings
 * 
 * @package yiisns\admin\widgets\gridView
 */
class GridViewSettings extends Component
{
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => \Yii::t('yiisns/admin', 'Table settings')
        ]);
    }

    public $enabledPjaxPagination;

    /**
     *
     * @var int
     */
    public $pageSize;

    public $pageSizeLimitMin;

    public $pageSizeLimitMax;

    /**
     *
     * @var string
     */
    public $pageParamName;

    /**
     *
     * @var array
     */
    public $visibleColumns = [];

    /**
     *
     * @var GridViewHasSettings
     */
    public $grid;
    
    public $orderBy = 'id';

    public $order = SORT_DESC;

    public function init()
    {
        if (! $this->pageSize) {
            $this->pageSize = \Yii::$app->admin->pageSize;
        }
        if (! $this->pageSizeLimitMin) {
            $this->pageSizeLimitMin = \Yii::$app->admin->pageSizeLimitMin;
        }
        if (! $this->pageSizeLimitMax) {
            $this->pageSizeLimitMax = \Yii::$app->admin->pageSizeLimitMax;
        }
        if (! $this->pageParamName) {
            $this->pageParamName = \Yii::$app->admin->pageParamName;
        }
        if (! $this->enabledPjaxPagination) {
            $this->enabledPjaxPagination = \Yii::$app->admin->enabledPjaxPagination;
        }
        
        parent::init();
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'enabledPjaxPagination' => \Yii::t('yiisns/kernel', 'Inclusion {ajax} navigation', [
                'ajax' => 'ajax'
            ]),
            'pageParamName' => \Yii::t('yiisns/kernel', 'Parameter name pages'),
            'pageSize' => \Yii::t('yiisns/kernel', 'Number of records on one page'),
            'pageSizeLimitMin' => \Yii::t('yiisns/kernel', 'The minimum number of records per page'),
            'pageSizeLimitMax' => \Yii::t('yiisns/kernel', 'The maximum number of records per page'),
            
            'orderBy' => \Yii::t('yiisns/kernel', 'Sort by what parameter'),
            'order' => \Yii::t('yiisns/admin', 'sorting direction'),
            
            'visibleColumns' => \Yii::t('yiisns/admin', 'Display column')
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                [
                    'enabledPjaxPagination'
                ],
                'string'
            ],
            [
                [
                    'pageParamName'
                ],
                'string'
            ],
            [
                [
                    'pageSize'
                ],
                'integer'
            ],
            [
                [
                    'pageSizeLimitMin'
                ],
                'integer'
            ],
            [
                [
                    'pageSizeLimitMax'
                ],
                'integer'
            ],
            [
                [
                    'orderBy'
                ],
                'string'
            ],
            [
                [
                    'order'
                ],
                'integer'
            ],
            [
                [
                    'visibleColumns'
                ],
                'safe'
            ]
        ]);
    }

    public function renderConfigForm(ActiveForm $form)
    {
        echo \Yii::$app->view->renderFile(__DIR__ . '/_form.php', [
            'form' => $form,
            'model' => $this
        ], $this);
    }

    /**
     *
     * @return array
     */
    public function getCallableData()
    {
        $result = parent::getCallableData();
        
        if ($this->grid) {
            $columnsData = $this->grid->getColumnsKeyLabels();
            
            $result['columns'] = $columnsData;
            $result['selectedColumns'] = array_keys($this->grid->columns);
        }
        
        return $result;
    }
}