<?php
/**
 * ActionColumn
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.10.2016
 * @since 1.0.0
 */
namespace yiisns\admin\grid;

use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\widgets\ControllerActions;
use yiisns\admin\widgets\ControllerModelActions;
use yiisns\admin\widgets\DropdownControllerActions;

use yii\base\InvalidConfigException;
use yii\grid\DataColumn;

/**
 * Class ActionColumn
 * 
 * @package yiisns\admin\grid
 */
class ActionColumn extends DataColumn
{
    public $filter = false;

    /**
     *
     * @var AdminModelEditorController
     */
    public $controller = null;

    public $isOpenNewWindow = null;

    public $clientOptions = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        if (! $this->controller) {
            throw new InvalidConfigException('controller - ' . \Yii::t('yiisns/kernel', 'not specified') . '.');
        }
        
        if (! $this->controller instanceof AdminModelEditorController) {
            throw new InvalidConfigException(\Yii::t('yiisns/kernel', "{controller} must be inherited from") . ': ' . AdminModelEditorController::className());
        }
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        // print_r($this->grid->pjax);die;
        if ($this->grid->pjax) {
            $this->clientOptions['pjax-id'] = $this->grid->pjax->options['id'];
        }
        
        $controller = clone $this->controller;
        $controller->model = $model;
        
        $this->gridDoubleClickAction();
        
        return DropdownControllerActions::widget([
            'controller' => $controller,
            'isOpenNewWindow' => $this->isOpenNewWindow,
            'clientOptions' => $this->clientOptions
        ]);
    }

    public static $grids = [];

    protected function gridDoubleClickAction()
    {
        if (! isset(self::$grids[$this->grid->id])) {
            $this->grid->view->registerJs(<<<JS
            $('tr', $("#{$this->grid->id}")).on('dblclick', function()
            {
                $('.sx-row-action', $(this)).click();
            });
JS
);
            self::$grids[$this->grid->id] = $this->grid->id;
        }
    }
}