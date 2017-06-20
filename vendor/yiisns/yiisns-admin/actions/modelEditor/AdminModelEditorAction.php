<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016 YiiSNS
 * @date 30.05.2016
 */
namespace yiisns\admin\actions\modelEditor;

use yiisns\admin\actions\AdminAction;
use yiisns\admin\components\UrlRule;
use yiisns\admin\controllers\AdminModelEditorController;
use yiisns\admin\controllers\AdminController;
use yiisns\admin\widgets\ControllerActions;
use yii\authclient\AuthAction;
use yii\helpers\Inflector;
use yii\web\Application;
use yii\web\ViewAction;

/**
 *
 * @property AdminModelEditorController $controller Class AdminModelsGridAction
 * @package yiisns\admin\actions\modelEditor
 */
class AdminModelEditorAction extends AdminAction
{

    public function init()
    {
        if (! $this->controller instanceof AdminModelEditorController) {
            throw new InvalidParamException(\Yii::t('yiisns/admin', 'This action is designed to work with the controller: ') . AdminModelEditorController::className());
        }
        
        parent::init();
    }
}