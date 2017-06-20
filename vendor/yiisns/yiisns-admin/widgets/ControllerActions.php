<?php
/**
 * ControllerActions
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.10.2016
 * @since 1.0.0
 */

namespace yiisns\admin\widgets;

use yiisns\apps\helpers\UrlHelper;

use yiisns\admin\actions\AdminAction;
use yiisns\admin\components\UrlRule;
use yiisns\admin\controllers\AdminController;
use yiisns\admin\controllers\helpers\Action;
use yiisns\admin\controllers\helpers\ActionManager;
use yiisns\admin\controllers\helpers\ActionModel;
use yiisns\admin\widgets\controllerActions\Asset;

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
class ControllerActions
    extends Widget
{
    /**
     * @var string id
     */
    public $activeActionId          = null;

    public $isOpenNewWindow         = false;

    public $ulOptions               =
    [
        "class" => "nav nav-pills sx-nav"
    ];

    public $controller              = null;

    public $clientOptions           = [];

    public function init()
    {
        parent::init();
        $this->_ensure();
    }

    /**
     * @throws InvalidConfigException
     */
    protected function _ensure()
    {
        if (!$this->controller)
        {
            throw new InvalidConfigException(\Yii::t('yiisns/kernel', 'Incorrectly configured widget, you must pass an controller object to which is built widget'));
        }

        if (!$this->controller instanceof AdminController)
        {
            throw new InvalidConfigException(\Yii::t('yiisns/kernel', 'For this controller can not build action'));
        }
    }


    /**
     * @return string
     */
    public function run()
    {
        if (!$actions = $this->controller->actions())
        {
            return '';
        }

        $result = $this->renderListLi();

        Asset::register($this->getView());
        return Html::tag("ul", implode($result), $this->ulOptions);
    }

    /**
     * @return array
     */
    public function renderListLi()
    {
        $result = [];

        $actions = $this->controller->actions;

        if (!$actions)
        {
            return [];
        }

        foreach ($actions as $id => $action)
        {
            if (!$action->visible)
            {
                continue;
            }

            $tagA = $this->renderActionTagA($action);

            $actionDataJson = Json::encode($this->getActionData($action));
            $result[] = Html::tag('li', $tagA,
                [
                    'class' => $this->activeActionId == $action->id ? "active" : '',
                    'onclick' => "new sx.classes.app.controllerAction({$actionDataJson}).go(); return false;"
                ]
            );
        }

        return $result;
    }

    /**
     * @param AdminAction $action
     * @return array
     */
    public function getActionData($action)
    {
        $actionData = array_merge($this->clientOptions, [
            'url'               => (string) $this->getActionUrl($action),
            'isOpenNewWindow'   => $this->isOpenNewWindow,
            'confirm'           => $action->confirm,
            'method'            => $action->method,
            'request'           => $action->request,
        ]);

        return $actionData;
    }

    /**
     * @param AdminAction $action
     */
    public function renderActionTagA($action, $tagOptions = [])
    {
        if (!$action->visible)
        {
            return '';
        }

        $icon = '';
        if ($action->icon)
        {
            $icon = Html::tag('span', '', ['class' => $action->icon]);
        }

        return Html::a($icon . '  ' . $action->name, $this->getActionUrl($action), $tagOptions);
    }

    /**
     * @param AdminAction $action
     * @return string
     */
    public function getSpanIcon($action)
    {
        $icon = '';
        if ($action->icon)
        {
            $icon = Html::tag('span', '', ['class' => $action->icon]);
        }

        return $icon;
    }
    /**
     * @param AdminAction $action
     * @return UrlHelper
     */
    public function getActionUrl($action)
    {
        $url = $action->url;
        if ($this->isOpenNewWindow)
        {
            $url->setSystemParam(\yiisns\admin\Module::SYSTEM_QUERY_EMPTY_LAYOUT, 'true');
        }

        return $url;
    }
}