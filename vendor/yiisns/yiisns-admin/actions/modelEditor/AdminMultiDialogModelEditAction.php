<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.05.2016
 */
namespace yiisns\admin\actions\modelEditor;

use yiisns\kernel\helpers\RequestResponse;
use yiisns\apps\helpers\UrlHelper;
use yiisns\kernel\models\Search;
use yiisns\admin\actions\AdminAction;
use yiisns\admin\components\UrlRule;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\controllers\AdminController;
use yiisns\admin\filters\AdminAccessControl;
use yiisns\admin\widgets\ControllerActions;
use yiisns\admin\widgets\GridViewStandart;
use yiisns\rbac\SnsManager;
use yii\authclient\AuthAction;
use yii\base\View;
use yii\behaviors\BlameableBehavior;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\Application;
use yii\web\ViewAction;

/**
 * Class AdminMultiDialogModelEditAction
 * @package yiisns\admin\actions\modelEditor
 */
class AdminMultiDialogModelEditAction extends AdminMultiModelEditAction
{
    public $viewDialog      = '';

    public $dialogOptions   = [
        'style' => 'min-height: 500px; min-width: 600px;'
    ];

    /**
     * @param GridView $grid
     * @return string
     */
    public function registerForGrid(GridViewStandart $grid)
    {
        $dialogId = $this->getGridActionId($grid);

        $clientOptions = Json::encode(ArrayHelper::merge($this->getClientOptions(), [
            'dialogId' => $dialogId
        ]));

        $grid->view->registerJs(<<<JS
(function(sx, $, _)
{

    sx.createNamespace('sx.classes.grid', sx);

    sx.classes.grid.MultiDialogAction = sx.classes.grid.MultiAction.extend({

        _onDomReady: function()
        {
            var self = this;

            this.jDialog = $( '#' + this.get('dialogId') );
            this.jDialogContent = $( '.modal-content', this.jDialog );

            this.Blocker = new sx.classes.Blocker(this.jDialogContent);

            $('form', this.jDialog).on('submit', function()
            {
                var data = _.extend(self.Grid.getDataForRequest(), {
                    'formData' : $(this).serialize()
                });

                self.Blocker.block();

                var ajax = self.createAjaxQuery(data);
                ajax.onComplete(function()
                {
                    self.jDialog.modal('hide');
                    self.Blocker.unblock();
                    /*_.delay(function()
                    {
                        self.jDialog.modal('hide');
                    }, 1000);
*/
                });
                ajax.execute();

                return false;
            });

        },

        _go: function()
        {
            var self = this;
            self.jDialog.modal('show');
        },

    });

    new sx.classes.grid.MultiDialogAction({$grid->gridJsObject}, '{$this->id}' ,{$clientOptions});
})(sx, sx.$, sx._);
JS
);
        $content = '';
        if ($this->viewDialog)
        {
            $content = $this->controller->view->render($this->viewDialog, [
                'action' => $this,
            ]);
        }

        return \Yii::$app->view->render('@yiisns/admin/actions/modelEditor/views/multi-dialog', [
            'dialogId'  => $dialogId,
            'content'   => $content
        ], $this);
    }


    /**
     * @param GridViewStandart $grid
     * @return string
     */
    public function getGridActionId(GridViewStandart $grid)
    {
        return $grid->id . '-' . $this->id;
    }
}