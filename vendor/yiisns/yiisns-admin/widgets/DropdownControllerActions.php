<?php
/**
 * DropdownControllerActions
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 07.11.2016
 * @since 1.0.0
 */

namespace yiisns\admin\widgets;

use yiisns\admin\components\UrlRule;
use yiisns\admin\controllers\AdminController;
use yiisns\admin\controllers\helpers\Action;
use yiisns\admin\controllers\helpers\ActionManager;
use yiisns\admin\controllers\helpers\ActionModel;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * Class ControllerActions
 * @package yiisns\admin\widgets
 */
class DropdownControllerActions
    extends ControllerActions
{
    public $ulOptions =
    [
        'class' => 'dropdown-menu'
    ];

    public $containerClass = 'dropdown';

    public $renderFirstAction = true;

    /**
     * @return string
     */
    public function run()
    {
        $actions = $this->controller->actions;

        $firstAction = '';
        if ($actions && is_array($actions) && count($actions) >= 1)
        {
            $firstAction = array_shift($actions);
        }

        $style = '';
        $firstActionString = '';

        if ($firstAction && $this->renderFirstAction)
        {
            $actionDataJson = Json::encode($this->getActionData($firstAction));

            $tagOptions = [
                'onclick'   => "new sx.classes.app.controllerAction({$actionDataJson}).go(); return false;",
                'class'     => 'btn btn-xs btn-default sx-row-action',
                'title'     => $firstAction->name
            ];

            $firstActionString = Html::a($this->getSpanIcon($firstAction), $this->getActionUrl($firstAction), $tagOptions);
            $style = 'min-width: 43px;';
        }


        return "<div class='{$this->containerClass}' title='".\Yii::t('yiisns/kernel', 'Possible actions')."'>
                    <div class=\"btn-group\" role=\"group\" style='{$style}'>
                        {$firstActionString}
                        <button type=\"button\" class='btn btn-xs btn-default sx-btn-caret-action' data-toggle=\"dropdown\">
                           <span class=\"caret\"></span>
                        </button>" .
                    parent::run()

                . "
                    </div>
                </div>
                ";
    }
}